$(document).ready(function (){
	variables = '{"var":[';
	methods = '"methods":[';
	param = "[";
	classname= "";
	diagram = "";

});

	function Initialize()
	{
		$("#radio1, #radio2, #radio1_, #radio2_, #radio3").buttonset();
		$("#varname").bind('keyup', function(event){
			$("#span_name").html($("#varname").val());
		});

		$("#paramname").keyup(function(event){
			$("#method_param_var"+cnt).html($("#paramname").val());
		});

		$("#classname").keyup(function(event){
			$("#method_name").html($("#classname").val());
		});

		$("input[name=access]").change(function()
		{
			$("#span_access").html("<b><u><font color=\"blue\">"+$("input[name=access]:checked").val()+"</b></u></font>");
		});

		$("input[name=data]").change(function()
		{
			$("#span_data").html("<b><u>"+$("input[name=data]:checked").val()+"</b></u>");
		});

		$("input[name=method_access]").change(function()
		{
			$("#method_access").html("<b><u><font color=\"blue\">"+$("input[name=method_access]:checked").val()+"</b></u></font>");
		});

		$("input[name=method_data]").change(function()
		{
			$("#method_data").html("<b><u>"+$("input[name=method_data]:checked").val()+"</b></u>");
		});
		
		$("input[name=paramdata]").change(function()
		{
			$("#method_param_data"+cnt).html("<b><font color=\"blue\">"+$("input[name=paramdata]:checked").val()+"</b></font>");
		});
		
		/**
			tabs event

		*/
		 $("#tab1").fadeIn(); // Show first tab content
		 $("#tab2").fadeOut();
		 $("#tabs li:first").attr("class","current"); // Activate first tab
	}
	function clickMemberVariable()
	{
		$("#tab1").fadeIn(); // Show first tab content
		$("#tab2").hide();	
		$("#tabs li").attr("class",""); //Reset id's
        $("#mem_var").attr("class","current"); // Activate this
	}

	function clickMemberFunction()
	{
		$("#tab2").fadeIn(); // Show first tab content
		$("#tab1").hide();	
		$("#tabs li").attr("class",""); //Reset id's
        $("#mem_function").attr("class","current"); // Activate this
	}

	function createDiagram()
	{
		if($("#diagram_name").val() == "") 
		 {
			alert("다이어그램 이름을 입력하세요.");return;
		 }
		else
		{
			diagram = '{"'+$("#diagram_name").val()+'":';
			alert("입력 완료");
		}
	}

	function createClass()
	{
		if(diagram == "")
		{
			alert("다이어그램을 만들어야 합니다.");
			return;
		}
		else if($("#class_name").val() == "")
		{
			alert("클래스 이름을 입력하세요.");
			return;
		}
		else
		{
			classname = '{"'+$("#class_name").val()+'":';
			alert("입력 완료");
		}
	}

	function saveVariable()
	{
		if(classname == "" || diagram == "")
		{
			alert("클래스와 다이어그램을 만들어야 합니다.");
			return;
		}
		variables += '{"access":"' + $("input[name=access]:checked").val() + '", "name" :"' + $("#varname").val() + '", "data":"' + $("input[name=data]:checked").val()+'"},';
		$("#var_form").each(function(){
			this.reset();
		});

		$("#span_access").text("접근 제한자");
		$("#span_data").text("자료형");
		$("#span_name").text("변수 이름");
	}

	function addParameter()
	{
		if(classname == "" || diagram == "")
		{
			alert("클래스와 다이어그램을 만들어야 합니다.");
			return;
		}
		$("#method_param_var"+cnt).append(", <br><br>");
		
		param += '{"paramdata":"'+$("input[name=paramdata]:checked").val()+'", "paramname":"'+$("#paramname").val()+'"},';
		cnt++;
		$("<span id=\"method_param_data"+cnt+"\" class=\"member_variable\">").appendTo("#method_param_var"+(cnt-1));
		$("<span id=\"method_param_var"+cnt+"\" class=\"member_variable\">").appendTo("#method_param_var"+(cnt-1));
	}

	function saveFunction()
	{
		if(classname == "" || diagram == "")
		{
			alert("클래스와 다이어그램을 만들어야 합니다.");
			return;
		}
		param += '{"paramdata":"'+$("input[name=paramdata]:checked").val()+'", "paramname":"'+$("#paramname").val()+'"}';
		methods += '{"access":"'+$("input[name=method_access]:checked").val()+'", "name":"'+$("input[name=method_name]").val()+'", "return":"'+$("input[name=method_data]:checked").val()+'", "parameter":'+param+']},';
		for(var i=1; i<=cnt; i++)
		{
			$("#method_aram_var"+cnt).detach();
		}
		cnt = 0;
		param = "";

		$("#method_form").each(function()
		{
			this.reset();
		});

		$("#method_access").text("접근 제한자");
		$("#method_data").text("자료형");
		$("#method_name").text("함수 이름");
		
		$("#method_param_data0").text("매개");
		$("#method_param_var0").text("변수");
	}

	function saveClass()
	{
		localStorage.clear(); // localstorage 초기화

		variables += "]}";
		methods += "]}";
		//alert(variables);
		var str = variables.substr(0, variables.length-4);
		str += "}]";

		var method_str = methods.substr(0, methods.length-4);
		method_str += "}]}";

		if(typeof(localStorage) == 'undefined') alert('not support HTML5');
		else
		{
				//localStorage.variable = JSON.stringify(str);
				//localStorage.method = JSON.stringify(method_str);
				classname += str + ", " + method_str + "}";
				
		}
		
		variables = "";
		methods = "";
	}

	function saveDiagram()
	{
		if(typeof(localStorage) == 'undefined') alert('not support HTML5');
		else
		{
			try{

					diagram += classname + '}}';
					localStorage.t = diagram;
			}
			catch (e)
			{
				if(e == QUOTA_EXCEEDED_ERR)
					alert('할당량 초과. 더이상 데이터 삽입 불가능');
			}
		}

	}