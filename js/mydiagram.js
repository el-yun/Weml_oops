/* portfolio */
$(document).ready(function(){
	//Caption Sliding (Partially Hidden to Visible)
	/*$('.boxgrid.caption').hover(function(){
		$(".cover", this).stop().animate({top:'140px'},{queue:false,duration:160});
	}, function() {
		$(".cover", this).stop().animate({top:'185px'},{queue:false,duration:160});
	});*/
	$(".boxgrid.caption").live("mouseover", 
		function() {
			$(".cover", this).stop().animate({top:'140px'},{queue:false,duration:160});
		}
	);
	$(".boxgrid.caption").live("mouseout", 
		function() {
			$(".cover", this).stop().animate({top:'185px'},{queue:false,duration:160});
		}
	);

	
});

/**
* 공개 클릭해서 다이어그램을 비공개로 바꿔주는 함수
*
* @param 다이어그램 seq_id
* @return 없음
**/
function lock(seqid)
{
	$.ajax({
		url:"./php/modify_mysecret.php",
		type:"POST",
		data:{seq_id:seqid, category:'unlock'},
		success:function(data)
		{

			location.reload();


		},
		error:function(x)
		{
			alert(x.responseText);
		}
	});
}

/**
* 비공개 클릭해서 다이어그램을 공개로 바꿔주는 함수
*
* @param 다이어그램 seq_id
* @return 없음
**/
function unlock(seqid)
{
	$.ajax({
		url:"./php/modify_mysecret.php",
		type:"POST",
		data:{seq_id:seqid, category:'lock'},
		success:function(data)
		{
			location.reload();
		},
		error:function(x)
		{
			alert(x.responseText);
		}
	});
}

/**
* Mydiagram 페이지에서 다이어그램 이름을 통한 검색을 클릭 시 호출
*
* @param 없음
* @return 없음
**/
$(document).ready(function(){
	sortRecord("f_date",1,0);

	$("#search").click(function(){
		var option = $("#select_val option:selected").val();
		var keyword = $("#keyword").val();


		sortSearchRecord(null, 1, 0, option, keyword);
	});
});


/**
* Mydiagram 페이지에서 추천다이어그램 페이지
*
* @param 없음
* @return 없음
**/
$(document).ready(function(){
	$.ajax({
		url:"./php/opendiagram.php",
		type:"POST",
		data:{category:'mainrecommlist'},
		success:function(data)
		{
			var data = JSON.parse(data);
			var html = "";
			
			for(var i=0; i<data.likelist.length; i++)
			{
				html = data.likelist[i].name;
				html += "(";
				html += data.likelist[i].likecnt;
				html += "), ";
				html += data.likelist[i].id;
				$("#rank-"+(i+1)).text(html);
			}
		},
		error:function(x)
		{
			alert(x.responseText);
		}
	});
});

/**
* Mydiagram 페이지에서 다이어그램 나열
*
* @param field 필드명
* @param startPage 시작 페이지 번호
* @param currentPage 현재 페이지 번호
* @return 없음
**/
function sortRecord(field, startPage,currentPage)
{
	if(field==null) field="f_date";
	$.ajax({
		type : "POST",
		url : "./php/mydiagram.php",
		data : {category:'openmylist', order:'desc', sidx:field, start:startPage, c_page:currentPage},
		success:function(response,status, request){
			if(response != 0)
			{
				//alert(response);
				$('#diagram-content-container ul').html(response);
				listNavigate(startPage,currentPage);
			}
			else
			{
				//alert("Please login first..!");	
			}
			
		},
		error:function(request, status,error){
				alert("code:"+request.status+"\n"+"message:"+request.responseText);
		}
	});
}

/**
* Mydiagram 페이지에서 다이어그램 네비게이터
*
* @param startPage 시작페이지 번호
* @param currentPage 현재 페이지 번호
* @param option 네비게이터 옵션값
* @param keyword 해당 다이어그램 제목을 위한 키워드
* @return 없음
**/
function listNavigate(startPage,currentPage, option, keyword)
{
	$.ajax({
		type : "POST",
		data : {category:'openmynavi', start:startPage, c_page:currentPage, option:option, keyword:keyword},
		url : "./php/mydiagram.php",
		success : function(response,status, request){
			if(response) {
				$('#paginate').html(response);
			}
		},
		error:function(request, status,error){
			alert("code:"+request.status+"\n"+"message:"+request.responseText);
		}
	});
}

/**
* Mydiagram 페이지에서 다이어그램 네비게이터
*
* @param startPage 시작페이지 번호
* @param currentPage 현재 페이지 번호
* @param option 네비게이터 옵션값
* @param keyword 해당 다이어그램 제목을 위한 키워드
* @return 없음
**/
function sortSearchRecord(id, startPage, c_page, option, keyword)
{		
		//(null, 1, 0, option, keyword)

		if(id==null) id = "f_date";
		$.ajax({
		type : "POST",
		data : {category:'searchlist', order:'desc', sidx:id, start:startPage, c_page:c_page, option:option, keyword:keyword},
		//             searchlist          desc      f_date        1                 0        다이어그램이름     찾을 내용
		url : "./php/mydiagram.php",
		success : function(result) {
			if(result) {
				$('#diagram-content-container ul').html(result);
				listNavigate(startPage,c_page, option, keyword);
			}
		},
		error : function(x) {
			alert(x.responseText);
		}
	});
}