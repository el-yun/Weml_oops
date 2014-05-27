<?
	session_start();
?>
<!DOCTYPE html>
<html>
<head>	
	<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">

	<title> OOP's | WeML </title>

	<link rel="stylesheet" href="css/oops_style.css" />
	<link rel="stylesheet" href="css/oops_common.css" />
	<script src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
	<script src="js/json2.js"></script>
</head>

<script type="text/javascript">
	$(document).ready(function (){
		sortRecord("f_date", 1, 0);

		$("#search").click(function(){
			//alert($("#select_val option:selected").val());
			//alert($("#keyword").val());
			var option = $("#select_val option:selected").val();
			var keyword = $("#keyword").val();


			sortSearchRecord(null, 1, 0, option, keyword);
		});
	});


	/**
	*
	*	검색한 결과를 OpenDiagram Page에 List를 출력하는 함수
	*
	*/
	function sortSearchRecord(id, startPage, c_page, option, keyword)
	{		
			
			if(id==null) id = "f_date";
			$.ajax({
			type : "POST",
			data : {category:'searchlist', order:'desc', sidx:id, start:startPage, c_page:c_page, option:option, keyword:keyword},
			url : "./php/opendiagram.php",
			success : function(result) {
				if(result) {
					$('#list ul').html(result);
					listNavigate(startPage,c_page, option, keyword);
				}
			},
			error : function(x) {
				alert(x.responseText);
			}
		});
	}
	
	/**
	*
	*	공개된 다이어그램을 OpenDiagram Page에 List를 출력하는 함수
	*
	*/
	function sortRecord(id, startPage,currentPage)
	{
		if(id==null) id = "f_date";
		$.ajax({
			type : "POST",
			data : {category:'openlist', order:'desc', sidx:id, start:startPage, c_page:currentPage},
			url : "./php/opendiagram.php",
			success : function(result) {
				if(result) {
					$('#list ul').html(result);
					listNavigate(startPage,currentPage);
				}
			},
			error : function(x) {
				alert(x.responseText);
			}
		});
	}

	/**
	*
	*	OpenDiagram 페이지 네비게이터를 만드는 함수
	*
	*/
	function listNavigate(startPage,currentPage, option, keyword)
	{
		$.ajax({
			type : "POST",
			data : {category:'navi', start:startPage, c_page:currentPage, option:option, keyword:keyword},
			url : "./php/opendiagram.php",
			success : function(result) {
				if(result) {
					$('#paginate').html(result);
				}
			},
			error : function(x) {
				alert(x.responseText);
			}
		});
	}
</script>
<body>
	<? include "outlogin.php" ?>
	<header>
		<a href="oops_home.php" title="adinath web solutions">
			<div class="logo"></div>
		</a>
		<nav id="topnav" role="navigation">
			<ul>
				<li><a href="oops_home.php" title="OOPs's home" style="opacity: 0.5;">HOME</a></li>
				<li><a href="oops_about.php" title="About WeML?" style="opacity: 0.5;">About WeML?</a></li>
				<li><a href="oops_my.php" title="Manage to my diagram" style="opacity: 0.5;">My Diagram</a></li>
				<li><a href="oops_open.php" class="active" title="Open Diagram" style="opacity: 1;">Open Diagram</a></li>
				<li class="topnav-lastchild"><a href="oops_contect.php" title="Forum" style="opacity: 0.5;">Contect</a></li>
			</ul>
		</nav>
	</header>
	
	<section id="intro">

			<div style="text-align:center; margin-bottom: 5px;"><img src="images/concept_02.png" width="940" height="236" border="0" alt=""></div>
	</section>
	
	<section>
		<!-- Main content area -->
		<article class="blogPost">  
		    <div class="fixed_img_col" style="width:940px; height:500px; border:0px dashed black;margin: 10px auto 0px;" id="list">&nbsp;
			  <ul></ul>			
		    </div>

			<div class="srch" id="select_val">
			<select>
				<option>다이어그램이름</option>
				<option>글쓴이</option>

			</select>
				<input type="text" accesskey="s" title="검색어" class="keyword" id="keyword">
				<input type="image" alt="검색" src="images/btn_srch.gif" id="search">
			</div>

			<div class="paginate" id="paginate">
			</div>
		</article>  
	</section>
	
	<footer>
		<div id="bottom">
			<ul>
				<li class="bottommenu">
					<ul>
						<li><a href="oops_home.php" title="oops website homepage">Home</a></li>
						<li><a href="oops_about.php" title="why adinath web solutions">About WeML</a></li>
						<li><a href="oops_my.php" title="why adinath web solutions">My Diagram</a></li>
						<li><a href="oops_open.php" title="why adinath web solutions">Open Diagram</a></li>
						<li><a href="oops_contect.php" title="why adinath web solutions">Contect</a></li>
					</ul>
					<p>
						Copyright 2012, 
						<a href="oops_home.php" title="oops website homepage">OOPs</a>
						. All rights reserved | Email: 
						<a href="soajo@jjssm.org" class="footermail">soajo@jjssm.org</a>
						, Mobile: +82-1036893702
					</p>
				</li>
				<li class="bottomlogo"></li>
			</ul>
		</div>
	</footer>
	
	<script src="http://cdn.jquerytools.org/1.2.6/full/jquery.tools.min.js"></script>
	<script defer="" src="../js/custom.js"></script>
  
</body>
</html>