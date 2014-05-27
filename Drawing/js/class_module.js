
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
		  alert("����� �� ���� �������Դϴ�");
		} else {
		  try {
		 
		  } catch (e) {
			 if (e == QUOTA_EXCEEDED_ERR) {
			   alert('���̾�׷� ������ ���� �Ҵ緮�� �ʰ��Ͽ����ϴ�.'); // �Ҵ緮 �ʰ��� ���Ͽ� �����͸� ������ �� ����
			}
		  }
		}
		
	});
	
	/**
	*
	*	ĵ������ Clear���� �� ȣ��Ǵ� Ŭ�������� ���� �ʱ�ȭ �Լ�
	*
	*	@param	����
	*	@return ����
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
	*	Ŭ������ �̸��� ������ �� ȣ��Ǵ� �Լ�
	*
	*	@param	nodeId	���� Ŭ������ ����ID
	*	@return ����
	*/
	function modifyClass(nodeId)
	{
		var modfiyClassName = $("input[name=var_classname]").val();

		for(var i=0; i<classList.length; i++)
		{
			if(nodeId == classList[i]) // ���� nodeid�� ã����
			{
				var temp = classNameList[i];
				classNameList[i] = modfiyClassName; // Ŭ���� �̸��� ���� ����
				exceptionRelation("3", classNameList[i], temp, nodeId);
				break;
			}
		}
	}
	
	/**
	*
	*	Ŭ������ ���踦 ������ �� ȣ��Ǵ� �Լ�
	*
	*	@param	sourceNodeID	ó�� ������ Ŭ����(�θ�)�� ���� ID
	*	@param	targetNodeID	���������� �����Ų(�ڽ�) Ŭ������ ���� ID
	*	@param	tagetClassName	���������� �����Ų(�ڽ�) Ŭ������ �̸�
	*	@return ����
	*/
	function deleteRelation(sourceNodeID, targetNodeID, targetClassName)
	{
		// sourceNode�� ����
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

		// targetNode�� ����
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
	*	Ŭ������ ������ü�� �ٲ�� �� ȣ��Ǵ� �Լ�
	*
	*	@param	sourceNodeID	ó�� ������ Ŭ����(�θ�)�� ���� ID
	*	@param	targetNodeID	���������� �����Ų(�ڽ�) Ŭ������ ���� ID
	*	@param	tagetClassName	���������� �����Ų(�ڽ�) Ŭ������ �̸�
	*	@return ����
	*/
	function changingRelation(sourceNodeID, targetClassName, changeRelation)
	{
		// sourceNode�� ����
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
	*	�������� ������ ���� ����ó��
	*
	*	@param	category	����ó�� �ѹ�
	*	@param	modifyName	������ Ŭ���� �̸�
	*	@param	originalName	���� Ŭ���� �̸�
	*	@param	nodeid	Ŭ������ ����ID
	*	@return ����
	*/
	function exceptionRelation(category, modifyName, originalName, nodeid)
	{

		if(category == "1") //Ŭ������ ���� ���� ��
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
		else if(category == "3") //Ŭ���� �̸��� ���� ���� ��
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
		else if(category == "4")		// ���谡 �����Ǿ��� ��
		{
		}
	}



	/**
	*
	*	Ŭ������ ������ �� ȣ��Ǵ� �Լ�
	*
	*	@param	nodeId	����Ŭ������ ���� ID
	*	@return ����
	*/
	function deleteClassNamenNodeId(nodeId)
	{
		for(var i=0; i<classList.length; i++)
		{
			if(nodeId == classList[i]) // ���� nodeid�� ã����
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
	*	Ŭ���� Ŭ������ Ȱ��ȭ ��Ű�� Ȱ��ȭ�� Ŭ������ ������� / ����Լ� List�� ����ϴ� �Լ�
	*
	*	@param	data	Ȱ��ȭ ��ų Ŭ������ ���� ID
	*	@param	classname	Ȱ��ȭ ��ų Ŭ������ �̸�
	*	@return ����
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
	*	��������� ������ �� ȣ��Ǵ� �Լ�
	*
	*	@param	����
	*	@return ����
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
						
						alert('�ɹ� �Լ��� ����Ǿ����ϴ�!');
						localStorage.setItem(key_cnt, ++cnt);
						$("#"+currentClass+"_var").html(OperClass.showLocalStorage("variable"));
						//$("#new_var").hide();
						$("#data_name").val("");
						$("#var_name").val("");

					}
					else
						alert('�Է� ����! ���ý��丮�� �Է� ����');
				}
			} else alert('���õ� Ŭ������ ���ų� �ɹ� �������� �Էµ��� �ʾҽ��ϴ�.');
	}

	/**
	*
	*	����Լ��� ������ �� ȣ��Ǵ� �Լ�
	*
	*	@param	����
	*	@return ����
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
				//alert('���ý��丮�� �Է� ����' + JSON.stringify(result));
				alert('�ɹ� �Լ��� ����Ǿ����ϴ�!');
				localStorage.setItem(key_cnt, ++cnt);
				$("#"+currentClass+"_func").html(OperClass.showLocalStorage("function"));
				//$("#new_func").hide();
				$("#return_name").val("");
				$("#func_name").val("");
				$("#func_param").val("");
				
			}
			else	alert('�Է� ����! ���ý��丮�� �Է� ����');
		} else alert('���õ� Ŭ������ ���ų� �ɹ� �Լ����� �Էµ��� �ʾҽ��ϴ�.');
	}


	/**
	*
	*	���������� Ŭ������ ������ �� ȣ��Ǵ� �Լ�
	*
	*	@param	����
	*	@return ����
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
		//alert("���̾�׷��� �����Ͽ����ϴ�!");
		
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
					alert("���̾�׷��� �����Ͽ����ϴ�!");
					$("#diagram_name").hide();
				}else
				{
					alert("���̾�׷��� ���忡 �����Ͽ����ϴ�!");
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
	*	Ŭ�������� �������� �����Ҷ� ȣ��Ǵ� �Լ�( Ŭ������ Ŭ���� ���� ���� �߻��� �Լ� ȣ�� )
	*
	*	@param	SourceNode	��� Ŭ������ ���ID ( �ش� ���̵��� ID�Ӽ��� ���󰡼� text�� �ҷ����� Ŭ�������� �� = sourceNode_Text )
	*	@param	TargetNode	���� Ŭ������ ���ID  ( �ش� ���̵��� ID�Ӽ��� ���󰡼� text�� �ҷ����� Ŭ�������� �� = sourceNode_Text )
	*	@return ����
	*/
	function node_connect(sourceNode,targetNode)
	{
		var sourceNode_Text = $("#" + sourceNode + "_content").text();
		var targetNode_Text = $("#" + targetNode + "_content").text();
		//alert("��� ����!! \nFrom:" + sourceNode + "(" + sourceNode_Text + ") \n To: " + targetNode + " (" + targetNode_Text + ") ");
		modifyRelation(sourceNode, targetNode, targetNode_Text);
	}

	/**
	*
	*	Ŭ�������� ����� �������踦 ������ �� ȣ��Ǵ� �Լ�
	*
	*	@param	sourceNode	��� Ŭ������ ���ID ( �ش� ���̵��� ID�Ӽ��� ���󰡼� text�� �ҷ����� Ŭ�������� �� = sourceNode_Text )
	*	@param	targetNode	���� Ŭ������ ���ID  ( �ش� ���̵��� ID�Ӽ��� ���󰡼� text�� �ҷ����� Ŭ�������� �� = sourceNode_Text )
	*	@param	targetNode_Text		���� Ŭ������ �̸�
	*	@return ����
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
	*	���̾�׷��� �ε��� �� ȣ��Ǵ� �Լ�
	*
	*	@param	diagramdata	���̾�׷� JSON DATA
	*	@return ����
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
			//Ŭ���� ���� ID �� Ŭ���� �̸� �޸𸮿� ����
			classList[i] = data.diagram[i].class_.classid;
			classNameList[i] = data.diagram[i].class_.classname;

			if(data.diagram[i].class_.variableData != 0)
			{
				//����ID_varCnt ���� �� ���
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

		//�� Ŭ������ ���� �޸𸮿� ����
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
						var AlertText = " ����� Ŭ������ : ";
						// ���� ����� ���ؼ�
					    for (i = 0; i < affectedConnections.length; i++) {
								AlertText += affectedConnections[i].nodeTo + " ";
						}
			}
		   //alert(AlertText);
	}*/
	/**
	*
	*	URL �Ķ���� �ҷ����� �Լ�
	*
	*	@param	strParamName URL���� ���� �Ķ���͸�
	*	@return Param[1] ��ȯ�� �Ķ���� ��
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
	*	Ȯ��/��� ���� ����
	*
	*/
			var nowZoom = 100; // �������
			var maxZoom = 200; // �ִ����(500�����ϸ� 5�� Ŀ����)
			var minZoom = 10; // �ּҺ���
	/**
	*
	*	ȭ�� Ȯ�� �Լ�
	*
	*	@param	����
	*	@return ����
	*/
			function zoomIn()
			{
				if (nowZoom < maxZoom)
				{
					nowZoom += 10; //25%�� Ŀ����.
				} 
				else
				{
					return;
				}
				document.getElementById("oops_canvas").style.zoom = nowZoom + "%";
			}
	/**
	*
	*	ȭ�� ��� �Լ�
	*
	*	@param	����
	*	@return ����
	*/
			function zoomOut()
			{
				if (nowZoom > minZoom)
				{
					nowZoom -= 10; //25%�� �۾�����.
				} 
				else
				{
					return;
				}
				document.getElementById("oops_canvas").style.zoom = nowZoom + "%";
			}
	/**
	*
	*	ȭ�� �ʱ�ȭ �Լ�
	*
	*	@param	����
	*	@return ����
	*/
			function zoomDefault() 
			{ 
				nowZoom = 100; 
				document.getElementById("oops_canvas").style.zoom = nowZoom + "%"; 
			}

	/**
	*
	*	���� ����Լ�
	*
	*	@param	tseq ����� ������ ������
	*	@return ����
	*/
			function show_tooltip(tseq)
			{
				var view = "";
					switch(tseq){
							case 0:
								// ���ο� Ŭ���� ���� ����
							$("#helper_desk").empty();
								view += '<img src="../../images/help/addClass.gif" width="290" height="200" border="0" alt="">';
								view += '<p class="helper_subject">Ŭ���� �����ϱ�<p>';
								view += '<p class="helper_text">"Add Class"�� ���ϴ� Ŭ������ ������ �� �ֽ��ϴ�.</p>';
								view += '<p class="helper_text">���ϴ� ��ġ�� Ŭ������ ��ġ�մϴ�. UML ���⹰�� ��� ���̾�׷��� Ŭ���� ��ġ�� �������� �����˴ϴ�.</p>';
								view += '<p class="helper_text">Oops Tool�� C++ ������ �ڵ带 �����ϹǷ� �ڵ� ������ C++ ������ ����Ͽ� ���̾�׷��� �����ؾ��մϴ�.</p>';
							$("#helper_desk").html(view);
							break;
							case 1:
								// ���� �߰� ����
							$("#helper_desk").empty();
								view += '<img src="../../images/help/addRelation.gif" width="290" height="200" border="0" alt="">';
								view += '<p class="helper_subject">���� �߰��ϱ�<p>';
								view += '<p class="helper_text">Ŭ������ ���콺�� ���ٴ�� ���踦 �߰��� �� �ִ� �����Ͱ� �������ϴ�.</p>';
								view += '<p class="helper_text">����Ʈ�� ���콺�� ��� �ٸ� Ŭ������ �����Ϳ� �ø��� ���踦 �߰��� �� �ֽ��ϴ�.</p>';
								view += '<p class="helper_text">�߰��� �Ŀ��� Ŭ�������� ���踦 �����մϴ�.</p>';
							$("#helper_desk").html(view);
							break;
							case 2:
								// ��� ���� & ��� �Լ� �߰� ���� ����
							$("#helper_desk").empty();
								view += '<img src="../../images/help/addVarFunc&Del.gif" width="290" height="200" border="0" alt="">';
								view += '<p class="helper_subject">��� ���� �� �Լ� �߰�/���� ����<p>';
								view += '<p class="helper_text">Ŭ������ ���� �� �Ŀ� Class Properties���� ��� ���� �߰� �Ǵ� ��� �Լ� �߰��� Ŭ���մϴ�.</p>';
								view += '<p class="helper_text">��� ������ ��� �Լ��� ���� ������ �Է��ϰԵǸ� �ش� Ŭ������ ���� �����ϰ� �Ǹ� ������ ��� ����/�Լ��� �ٽ� ������ �����մϴ�.</p>';
								view += '<p class="helper_text">�� Ŭ������ ������ ��� ����/�Լ��� �ش� Ŭ������ Ŭ���� Ȯ�� �� �� �ֽ��ϴ�.</p>';
							$("#helper_desk").html(view);
							break;
							case 3:
								// ���̾�׷� �⺻ ��ư ����  - ���콺 ����
							$("#helper_desk").empty();
								view += '<img src="../../images/help/3Buttons.gif" width="290" height="200" border="0" alt="">';
								view += '<p class="helper_subject">Oops Tool ���̾�׷� �⺻ �޴� ����<p>';
								view += '<p class="helper_text">Oops Tool�� ���� �⺻ �޴��� UML ��ȯ, ���̾�׷� ����, ���̾�׷� �ʱ�ȭ ��ư���� �����ϴ�.</p>';
								view += '<p class="helper_text">UML ��ȯ�� ���̾�׷��� �׸� �� ���̾�׷��� UML Ŭ���� ���̾�׷� ���⹰�� Ȯ���ϰ� ������ ��ȯ�Ͽ� �� �� �ֽ��ϴ�.</p>';
								view += '<p class="helper_text">���̾�׷� ���� �ÿ��� My Diagram�� ����Ǹ� ������� ���̾�׷��� C++�� �ڵ�� Ȯ�� �� �� �ֽ��ϴ�.</p>';
							$("#helper_desk").html(view);
							break;
							case 4:
								// Ȯ�� ��� ����  - ���콺 ����
							$("#helper_desk").empty();
								view += '<img src="../../images/help/ZoominOut.gif" width="290" height="200" border="0" alt="">';
								view += '<p class="helper_subject">Ȯ�� ��� ����<p>';
								view += '<p class="helper_text">���̾�׷��� �׸� �� �Ʒ� Ȯ��/��� �������� ���� Ȯ�� �Ǵ� ����ؼ� �� �� �ֽ��ϴ�.</p>';
								view += '<p class="helper_text">Ȯ�� ��Ҵ� �а� ���ų� �ڼ��� ���� ���� �����̹Ƿ� ���̾�׷� ������ ������ ���� �� �ֽ��ϴ�.</p>';
							$("#helper_desk").html(view);
							break;
							case 5:
								// UML �⺻ ��ư ���� - 
							$("#helper_desk").empty();
								view += '<img src="../../images/help/UML2buttons.gif" width="290" height="200" border="0" alt="">';
								view += '<p class="helper_subject">UML �⺻ �޴� ����<p>';
								view += '<p class="helper_text">UML Ŭ���� ���̾�׷��� ���̾�׷����� ���� ��ü�� �޼ҵ��� ���� ������ Ȯ���մϴ�.</p>';
								view += '<p class="helper_text">UML �⺻ �޴����� ���̾�׷� �������� ���ư���� UML/���̾�׷� �ʱ�ȭ ��ư�� �ֽ��ϴ�. </p>';
							$("#helper_desk").html(view);
							break;
							case 6:
								// UML Ȯ�� ��� ����
							$("#helper_desk").empty();
								view += '<img src="../../images/help/UMLZoominOut.gif" width="290" height="200" border="0" alt="">';
								view += '<p class="helper_subject">UML ���� �޴� ����<p>';
								view += '<p class="helper_text">UML ȭ���� �⺻ �޴��� UML ȭ�� ���, ȭ�� Ȯ�� ��ҷ� �����Ǿ� �ֽ��ϴ�. </p>';
							$("#helper_desk").html(view);
							break;
					}
			}