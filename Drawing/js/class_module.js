
	var OperClass = new ClassStorage();
	var currentClass;

	var param;
	var classList = [];
	var classCnt = 0;
	var classNameList = [];
	var relationList = [];

	$(document).ready(function() 
	{

		if (typeof(localStorage) == 'undefined' ) {
		  alert("사용할 수 없는 브라우저입니다");
		} else {
		  try {
		 
		  } catch (e) {
			 if (e == QUOTA_EXCEEDED_ERR) {
			   alert('다이어그램 데이터 저장 할당량을 초과하였습니다.'); // 할당량 초과로 인하여 데이터를 저장할 수 없음
			}
		  }
		}
		
	});
	
	/**
	*
	*	캔버스를 Clear했을 때 호출되는 클래스관련 변수 초기화 함수
	*
	*	@param	없음
	*	@return 없음
	*/
	function initClassInfo()
	{	
		
		classCnt = 0;
		classList.length = 0;
		classNameList.length = 0;
		relationList.length=0;

	}

	/**
	*
	*	클래스의 이름을 수정할 때 호출되는 함수
	*
	*	@param	nodeId	현재 클래스의 고유ID
	*	@return 없음
	*/
	function modifyClass(nodeId)
	{
		var modfiyClassName = $("input[name=var_classname]").val();

		for(var i=0; i<classList.length; i++)
		{
			if(nodeId == classList[i]) // 현재 nodeid를 찾으면
			{
				var temp = classNameList[i];
				classNameList[i] = modfiyClassName; // 클래스 이름을 새로 수정
				exceptionRelation("3", classNameList[i], temp, nodeId);
				break;
			}
		}
	}
	
	/**
	*
	*	클래스간 관계를 삭제할 때 호출되는 함수
	*
	*	@param	sourceNodeID	처음 선택한 클래스(부모)의 고유 ID
	*	@param	targetNodeID	마지막으로 연결시킨(자식) 클래스의 고유 ID
	*	@param	tagetClassName	마지막으로 연결시킨(자식) 클래스의 이름
	*	@return 없음
	*/
	function deleteRelation(sourceNodeID, targetNodeID, targetClassName)
	{
		// sourceNode쪽 삭제
		var sourceNode = localStorage.getItem(sourceNodeID+"_relation");
		var sourceRel = JSON.parse(sourceNode);
		
		for(var i=0; i<sourceRel[1].length; i++)
		{
			if(sourceRel[1][i].classname == targetClassName)
			{
				sourceRel[1].splice(i, 1);
			}
		}

		localStorage.removeItem(sourceNodeID+"_relation");
		localStorage.setItem(sourceNodeID+"_relation", JSON.stringify(sourceRel));

		// targetNode쪽 삭제
		var targetNode = localStorage.getItem(targetNodeID+"_relation");
		var targetRel = JSON.parse(targetNode);

		for(var i=0; i<targetRel[0].length; i++)
		{
			if(targetRel[0][i] == sourceNodeID)
			{
				targetRel[0].splice(i, 1);
			}
		}

		localStorage.removeItem(targetNodeID+"_relation");
		localStorage.setItem(targetNodeID+"_relation", JSON.stringify(targetRel));
	}

	/**
	*
	*	클래스간 관계자체가 바뀌였을 때 호출되는 함수
	*
	*	@param	sourceNodeID	처음 선택한 클래스(부모)의 고유 ID
	*	@param	targetNodeID	마지막으로 연결시킨(자식) 클래스의 고유 ID
	*	@param	tagetClassName	마지막으로 연결시킨(자식) 클래스의 이름
	*	@return 없음
	*/
	function changingRelation(sourceNodeID, targetClassName, changeRelation)
	{
		// sourceNode쪽 삭제
		var sourceNode = localStorage.getItem(sourceNodeID+"_relation");
		var sourceRel = JSON.parse(sourceNode);
		
		for(var i=0; i<sourceRel[1].length; i++)
		{
			if(sourceRel[1][i].classname == targetClassName)
			{
				sourceRel[1][i].relation = changeRelation;
			}
		}

		localStorage.removeItem(sourceNodeID+"_relation");
		localStorage.setItem(sourceNodeID+"_relation", JSON.stringify(sourceRel));
	}

	/**
	*
	*	연관관계 선택할 때의 예외처리
	*
	*	@param	category	예외처리 넘버
	*	@param	modifyName	수정할 클래스 이름
	*	@param	originalName	본래 클래스 이름
	*	@param	nodeid	클래스의 고유ID
	*	@return 없음
	*/
	function exceptionRelation(category, modifyName, originalName, nodeid)
	{

		if(category == "1") //클래스가 삭제 됬을 때
		{
			var tempChildren = localStorage.getItem(nodeid+"_relation");
			var rel = JSON.parse(tempChildren);
			
			for(var i=0; i<rel[0].length; i++)
			{
				var from = localStorage.getItem(rel[0][i]+"_relation");
				var relationFrom = JSON.parse(from);

				for(var j=0; j<relationFrom[1].length; j++)
				{
					if(relationFrom[1][j].classname == originalName)
					{
						relationFrom[1].splice(j, 1);
					}
				}

				localStorage.removeItem(rel[0][i]+"_relation");
				localStorage.setItem(rel[0][i]+"_relation", JSON.stringify(relationFrom));
			}

			localStorage.removeItem(nodeid+"_relation");

		}
		else if(category == "3") //클래스 이름이 수정 됬을 때
		{
			var tempChildren = localStorage.getItem(nodeid+"_relation");
			var rel = JSON.parse(tempChildren);

			for(var i=0; i<rel[0].length; i++)
			{
				var from = localStorage.getItem(rel[0][i]+"_relation");
				var relationFrom = JSON.parse(from);
				
				for(var j=0; j<relationFrom[1].length; j++)
				{
					if(relationFrom[1][j].classname == originalName)
					{
						relationFrom[1][j].classname = modifyName;
					}
				}

				localStorage.removeItem(rel[0][i]+"_relation");
				localStorage.setItem(rel[0][i]+"_relation", JSON.stringify(relationFrom));
			}
			
		}
		else if(category == "4")		// 관계가 수정되었을 때
		{
		}
	}



	/**
	*
	*	클래스를 삭제할 때 호출되는 함수
	*
	*	@param	nodeId	현재클래스의 고유 ID
	*	@return 없음
	*/
	function deleteClassNamenNodeId(nodeId)
	{
		for(var i=0; i<classList.length; i++)
		{
			if(nodeId == classList[i]) // 현재 nodeid를 찾으면
			{
				exceptionRelation("1", '', classNameList[i], nodeId);
				classNameList.splice(i, 1);
				classList.splice(i, 1);
				break;
			}
		}
	}

	/**
	*
	*	클릭한 클래스를 활성화 시키고 활성화된 클래스의 멤버변수 / 멤버함수 List를 출력하는 함수
	*
	*	@param	data	활성화 시킬 클래스의 고유 ID
	*	@param	classname	활성화 시킬 클래스의 이름
	*	@return 없음
	*/
	function activateClass(data, classname)
	{
		$("#classlist").empty();
		currentClass = OperClass.makeClass_(data);
		$("input[name=currentclass_node]").val(data);

		var key = "#"+currentClass;
		var var_html = "<div id='"+currentClass+"_var'>";
		var func_html = "<div id='"+currentClass+"_func'>";
		var html = "<div id='"+currentClass+"_class'>";
			
		$(html).appendTo($("#classlist"));
		$(var_html).appendTo($("#"+currentClass+"_class"));
		$(func_html).appendTo($("#"+currentClass+"_class"));

		if(localStorage.getItem(currentClass+"_varCnt") == undefined)
		{
			localStorage.setItem(currentClass+"_varCnt", 0);
			classList[classCnt] = currentClass;
			classNameList[classCnt++] = classname;
			var relationFrom = [];
			var relationTo = [];
			var rel = [relationFrom, relationTo];
			//var rel = new addRelation(new addParentnChild(0,0), new addParentnChild(0,0), new addParentnChild(0,0), new addParentnChild(0,0), new addParentnChild(0,0));
			localStorage.setItem(currentClass+"_relation", JSON.stringify(rel));
		}
		if(localStorage.getItem(currentClass+"_funcCnt") == undefined)
		{
			localStorage.setItem(currentClass+"_funcCnt", 0);
		}
		$("#"+currentClass+"_var").html(OperClass.showLocalStorage("variable"));
		$("#"+currentClass+"_func").html(OperClass.showLocalStorage("function"));
	}

	/**
	*
	*	멤버변수를 저장할 때 호출되는 함수
	*
	*	@param	없음
	*	@return 없음
	*/
	function saveMemberVariable()
	{
			var access = $("input[name=var_access]:checked").val();
//			var data = $("input[name=var_data]:checked").val();
			var data = $("#data_name").val();
			var name = $("#var_name").val();
			if(currentClass && name){
				var key_cnt = currentClass+"_varCnt";
				var cnt = localStorage.getItem(key_cnt);
				var key = "#"+name;
				if($(key).length > 0) return;
				else
				{
					var result = new memberVarPro(access, name, data);
					
					if(OperClass.saveMembervar(currentClass, cnt, JSON.stringify(result)) == 1)
					{
						
						alert('맴버 함수가 저장되었습니다!');
						localStorage.setItem(key_cnt, ++cnt);
						$("#"+currentClass+"_var").html(OperClass.showLocalStorage("variable"));
						//$("#new_var").hide();
						$("#data_name").val("");
						$("#var_name").val("");

					}
					else
						alert('입력 실패! 로컬스토리지 입력 실패');
				}
			} else alert('선택된 클래스가 없거나 맴버 변수명이 입력되지 않았습니다.');
	}

	/**
	*
	*	멤버함수를 저장할 때 호출되는 함수
	*
	*	@param	없음
	*	@return 없음
	*/
	function saveMemberFunction()
	{
			var access = $("input[name=func_access]:checked").val();
			//var data = $("input[name=func_data]:checked").val();
			var data = $("#return_name").val();
			var name = $("#func_name").val();
			var param = $("#func_param").val();

		if(currentClass && name){
			var key_cnt = currentClass+"_funcCnt";
			var cnt = localStorage.getItem(key_cnt);

			var result = new memberFuncPro(access, name, data, param);
			//alert(param);
			if(OperClass.saveMemberFunc(currentClass, cnt, JSON.stringify(result)) == 1)
			{
				paramData = [];
				paramCnt = 0;
				param = "";
				//alert('로컬스토리지 입력 성공' + JSON.stringify(result));
				alert('맴버 함수가 저장되었습니다!');
				localStorage.setItem(key_cnt, ++cnt);
				$("#"+currentClass+"_func").html(OperClass.showLocalStorage("function"));
				//$("#new_func").hide();
				$("#return_name").val("");
				$("#func_name").val("");
				$("#func_param").val("");
				
			}
			else	alert('입력 실패! 로컬스토리지 입력 실패');
		} else alert('선택된 클래스가 없거나 맴버 함수명이 입력되지 않았습니다.');
	}


	/**
	*
	*	최종적으로 클래스를 저장할 때 호출되는 함수
	*
	*	@param	없음
	*	@return 없음
	*/
	function finalClassSave(seqid)
	{

		var classData = [];
		for(var j=0; j<classList.length; j++)
		{
			var funccnt = localStorage.getItem(classList[j]+"_funcCnt");
			var varcnt = localStorage.getItem(classList[j]+"_varCnt");
			var test = [];
			var test_ = [];

			for(var i=0; i<varcnt; i++)
			{
				test[i] = JSON.parse(localStorage.getItem(classList[j]+"_var_"+i));
				console.log(test);
			}

			for(var i=0; i<funccnt; i++)
			{
				test_[i] = JSON.parse(localStorage.getItem(classList[j]+"_func_"+i));
			}
			
			var temp_var = new createMemberVar(test);
			var temp_func = new createMemberFunc(test_);
			console.log(JSON.stringify(temp_var));
			console.log(JSON.stringify(temp_func));
			classData[j] = new createClass(test, test_, classNameList[j], JSON.parse(localStorage.getItem(classList[j]+"_relation")), classList[j]);
			classData[j] = new addPrefixClass(classData[j]);
		}

		var result = new createDiagram(classData);
		localStorage.setItem("diagram", JSON.stringify(result));
		var rectangle = localStorage.getItem("diagram_class_resource");
		//alert("다이어그램을 저장하였습니다!");
		
		var json_data = localStorage.getItem("diagram_class_resource", json_data);
		var json_conn = localStorage.getItem("diagram_conn_resource", json_conn);

		$.ajax({
			type:"POST",
			url : "../../CutyCapt/savediagram.php",
			
			data:{diagram:JSON.stringify(result), resource:rectangle, diagramname:$("input[name=diagram_name]").val(), secret:"1", explain:$("#diagram_explain").val(), jsondata:json_data, jsonconn:json_conn, seqid:seqid},
			beforeSend: function() {
					$("#save_progress").show();
			},
			success:function(data)
			{
					$("#save_progress").hide();
					//alert(data);
				if(data == 1)
				{
					alert("다이어그램을 저장하였습니다!");
					$("#diagram_name").hide();
				}else
				{
					alert("다이어그램을 저장에 실패하였습니다!");
				}	

			},
			error:function(x)
			{
				alert(x.responseText);
				$("#diagram_name").hide();
			}
		});
	}

	/**
	*
	*	클래스끼리 연관관계 연결할때 호출되는 함수( 클래스와 클래스 사이 연결 발생시 함수 호출 )
	*
	*	@param	SourceNode	출발 클래스의 노드ID ( 해당 아이디의 ID속성을 따라가서 text를 불러오면 클래스명이 됨 = sourceNode_Text )
	*	@param	TargetNode	도착 클래스의 노드ID  ( 해당 아이디의 ID속성을 따라가서 text를 불러오면 클래스명이 됨 = sourceNode_Text )
	*	@return 없음
	*/
	function node_connect(sourceNode,targetNode)
	{
		var sourceNode_Text = $("#" + sourceNode + "_content").text();
		var targetNode_Text = $("#" + targetNode + "_content").text();
		//alert("노드 생성!! \nFrom:" + sourceNode + "(" + sourceNode_Text + ") \n To: " + targetNode + " (" + targetNode_Text + ") ");
		modifyRelation(sourceNode, targetNode, targetNode_Text);
	}

	/**
	*
	*	클래스끼리 연결된 연관관계를 수정할 때 호출되는 함수
	*
	*	@param	sourceNode	출발 클래스의 노드ID ( 해당 아이디의 ID속성을 따라가서 text를 불러오면 클래스명이 됨 = sourceNode_Text )
	*	@param	targetNode	도착 클래스의 노드ID  ( 해당 아이디의 ID속성을 따라가서 text를 불러오면 클래스명이 됨 = sourceNode_Text )
	*	@param	targetNode_Text		도착 클래스의 이름
	*	@return 없음
	*/
	function modifyRelation(sourceNode, targetNode, targetNode_Text)
	{
		var relationFrom = localStorage.getItem(targetNode+"_relation");
		var from = JSON.parse(relationFrom);
		from[0].push(sourceNode);
		localStorage.setItem(targetNode+"_relation", JSON.stringify(from));

		var relationTo = localStorage.getItem(sourceNode+"_relation");
		var to = JSON.parse(relationTo);
		
		to[1].push(new addRelation("dependency", targetNode_Text));
		localStorage.setItem(sourceNode+"_relation", JSON.stringify(to));

	}
	/**
	*
	*	다이어그램을 로드할 때 호출되는 함수
	*
	*	@param	diagramdata	다이어그램 JSON DATA
	*	@return 없음
	*/
	function loadDiagramData(diagramdata)
	{
		/*
		classCnt = 0;
		classList.length = 0;
		classNameList.length = 0;
		relationList.length=0;
		*/

		//alert(diagramdata);
		initClassInfo();
		var data = JSON.parse(diagramdata);
		//alert(data.diagram.length);
		for(var i=0; i<data.diagram.length; i++)
		{
			//클래스 고유 ID 와 클래스 이름 메모리에 저장
			classList[i] = data.diagram[i].class_.classid;
			classNameList[i] = data.diagram[i].class_.classname;

			if(data.diagram[i].class_.variableData != 0)
			{
				//고유ID_varCnt 삭제 뒤 등록
				localStorage.removeItem(data.diagram[i].class_.classid+"_varCnt");
				localStorage.setItem(data.diagram[i].class_.classid+"_varCnt", data.diagram[i].class_.variableData.length);
				//localStorage.setItem(
				for(var j=0; j<data.diagram[i].class_.variableData.length; j++)
				{
					var result = new memberVarPro(data.diagram[i].class_.variableData[j].access, data.diagram[i].class_.variableData[j].name, data.diagram[i].class_.variableData[j].data);
					OperClass.saveMembervar(data.diagram[i].class_.classid, j, JSON.stringify(result));
				}
			}
			if(data.diagram[i].class_.functionData != 0)
			{
				localStorage.removeItem(data.diagram[i].class_.classid+"_funcCnt");
				localStorage.setItem(data.diagram[i].class_.classid+"_funcCnt", data.diagram[i].class_.functionData.length);
				//localStorage.setItem(
				for(var j=0; j<data.diagram[i].class_.functionData.length; j++)
				{
					var result = new memberFuncPro(data.diagram[i].class_.functionData[j].access, data.diagram[i].class_.functionData[j].name, data.diagram[i].class_.functionData[j].returns, data.diagram[i].class_.functionData[j].param);
					OperClass.saveMemberFunc(data.diagram[i].class_.classid, j, JSON.stringify(result));
				}
			}
		}

		//총 클래스의 개수 메모리에 저장
		classCnt = data.diagram.length;
		//alert(data.diagram[0].class_.functionData.length);
	}

	/*function showClassData(access, data, name, cnt)
	{
		alert(access + "." + data + "." + name + "." +cnt);
	}*/

    /*
	function node_recall_nodeId(selectedNodes)
	{
			for (index = 0; index < selectedNodes.length; index++) {
						var affectedConnections = selectedNodes[index].affectedConnections;
						var AlertText = " 연결된 클래스들 : ";
						// 노드로 연결된 컨넥션
					    for (i = 0; i < affectedConnections.length; i++) {
								AlertText += affectedConnections[i].nodeTo + " ";
						}
			}
		   //alert(AlertText);
	}*/
	/**
	*
	*	URL 파라미터 불러오는 함수
	*
	*	@param	strParamName URL에서 받을 파라미터명
	*	@return Param[1] 반환할 파라미터 값
	*/
				function getParameter(strParamName) {
					var strURL = location.search;
					var tmpParam = strURL.substring(1).split("&");
					if(strURL.substring(1).length > 0){
						var Params = new Array;
						for(var i=0;i<tmpParam.length;i++){
							Params = tmpParam[i].split("=");
							if(strParamName == Params[0]){
								return Params[1];
							}
						}
					 }
					 return "";
				}

	/**
	*
	*	확대/축소 전역 변수
	*
	*/
			var nowZoom = 100; // 현재비율
			var maxZoom = 200; // 최대비율(500으로하면 5배 커진다)
			var minZoom = 10; // 최소비율
	/**
	*
	*	화면 확대 함수
	*
	*	@param	없음
	*	@return 없음
	*/
			function zoomIn()
			{
				if (nowZoom < maxZoom)
				{
					nowZoom += 10; //25%씩 커진다.
				} 
				else
				{
					return;
				}
				document.getElementById("oops_canvas").style.zoom = nowZoom + "%";
			}
	/**
	*
	*	화면 축소 함수
	*
	*	@param	없음
	*	@return 없음
	*/
			function zoomOut()
			{
				if (nowZoom > minZoom)
				{
					nowZoom -= 10; //25%씩 작아진다.
				} 
				else
				{
					return;
				}
				document.getElementById("oops_canvas").style.zoom = nowZoom + "%";
			}
	/**
	*
	*	화면 초기화 함수
	*
	*	@param	없음
	*	@return 없음
	*/
			function zoomDefault() 
			{ 
				nowZoom = 100; 
				document.getElementById("oops_canvas").style.zoom = nowZoom + "%"; 
			}

	/**
	*
	*	도움말 출력함수
	*
	*	@param	tseq 출력할 도메인 고유값
	*	@return 없음
	*/
			function show_tooltip(tseq)
			{
				var view = "";
					switch(tseq){
							case 0:
								// 새로운 클래스 생성 도움말
							$("#helper_desk").empty();
								view += '<img src="../../images/help/addClass.gif" width="290" height="200" border="0" alt="">';
								view += '<p class="helper_subject">클래스 생성하기<p>';
								view += '<p class="helper_text">"Add Class"로 원하는 클래스를 생성할 수 있습니다.</p>';
								view += '<p class="helper_text">원하는 위치에 클래스를 배치합니다. UML 산출물의 경우 다이어그램의 클래스 위치를 기준으로 생성됩니다.</p>';
								view += '<p class="helper_text">Oops Tool은 C++ 기준의 코드를 제공하므로 코드 생성시 C++ 문법을 고려하여 다이어그램을 편집해야합니다.</p>';
							$("#helper_desk").html(view);
							break;
							case 1:
								// 관계 추가 도움말
							$("#helper_desk").empty();
								view += '<img src="../../images/help/addRelation.gif" width="290" height="200" border="0" alt="">';
								view += '<p class="helper_subject">관계 추가하기<p>';
								view += '<p class="helper_text">클래스에 마우스를 갖다대면 관계를 추가할 수 있는 포인터가 보여집니다.</p>';
								view += '<p class="helper_text">포인트를 마우스로 끌어서 다른 클래스의 포인터에 올리면 관계를 추가할 수 있습니다.</p>';
								view += '<p class="helper_text">추가한 후에는 클래스간의 관계를 선택합니다.</p>';
							$("#helper_desk").html(view);
							break;
							case 2:
								// 멤버 변수 & 멤버 함수 추가 삭제 도움말
							$("#helper_desk").empty();
								view += '<img src="../../images/help/addVarFunc&Del.gif" width="290" height="200" border="0" alt="">';
								view += '<p class="helper_subject">멤버 변수 및 함수 추가/삭제 도움말<p>';
								view += '<p class="helper_text">클래스를 선택 한 후에 Class Properties에서 멤버 변수 추가 또는 멤버 함수 추가를 클릭합니다.</p>';
								view += '<p class="helper_text">멤버 변수나 멤버 함수에 관한 정보를 입력하게되면 해당 클래스에 대해 생성하게 되며 생생된 멤버 변수/함수는 다시 수정이 가능합니다.</p>';
								view += '<p class="helper_text">각 클래스에 생성된 멤버 변수/함수는 해당 클래스를 클릭시 확인 할 수 있습니다.</p>';
							$("#helper_desk").html(view);
							break;
							case 3:
								// 다이어그램 기본 버튼 도움말  - 마우스 오버
							$("#helper_desk").empty();
								view += '<img src="../../images/help/3Buttons.gif" width="290" height="200" border="0" alt="">';
								view += '<p class="helper_subject">Oops Tool 다이어그램 기본 메뉴 도움말<p>';
								view += '<p class="helper_text">Oops Tool의 최초 기본 메뉴는 UML 전환, 다이어그램 저장, 다이어그램 초기화 버튼으로 나뉩니다.</p>';
								view += '<p class="helper_text">UML 전환은 다이어그램을 그린 후 다이어그램을 UML 클래스 다이어그램 산출물로 확인하고 싶을때 전환하여 볼 수 있습니다.</p>';
								view += '<p class="helper_text">다이어그램 저장 시에는 My Diagram에 저장되며 만들어진 다이어그램을 C++의 코드로 확인 할 수 있습니다.</p>';
							$("#helper_desk").html(view);
							break;
							case 4:
								// 확대 축소 도움말  - 마우스 오버
							$("#helper_desk").empty();
								view += '<img src="../../images/help/ZoominOut.gif" width="290" height="200" border="0" alt="">';
								view += '<p class="helper_subject">확대 축소 도움말<p>';
								view += '<p class="helper_text">다이어그램을 그린 후 아래 확대/축소 아이콘을 통해 확대 또는 축소해서 볼 수 있습니다.</p>';
								view += '<p class="helper_text">확대 축소는 넓게 보거나 자세히 보기 위한 목적이므로 다이어그램 수정에 제약이 있을 수 있습니다.</p>';
							$("#helper_desk").html(view);
							break;
							case 5:
								// UML 기본 버튼 도움말 - 
							$("#helper_desk").empty();
								view += '<img src="../../images/help/UML2buttons.gif" width="290" height="200" border="0" alt="">';
								view += '<p class="helper_subject">UML 기본 메뉴 도움말<p>';
								view += '<p class="helper_text">UML 클래스 다이어그램은 다이어그램에서 만든 객체와 메소드의 대한 정보를 확인합니다.</p>';
								view += '<p class="helper_text">UML 기본 메뉴에는 다이어그램 편집으로 돌아가기와 UML/다이어그램 초기화 버튼이 있습니다. </p>';
							$("#helper_desk").html(view);
							break;
							case 6:
								// UML 확대 축소 도움말
							$("#helper_desk").empty();
								view += '<img src="../../images/help/UMLZoominOut.gif" width="290" height="200" border="0" alt="">';
								view += '<p class="helper_subject">UML 보기 메뉴 도움말<p>';
								view += '<p class="helper_text">UML 화면의 기본 메뉴는 UML 화면 출력, 화면 확대 축소로 구성되어 있습니다. </p>';
							$("#helper_desk").html(view);
							break;
					}
			}