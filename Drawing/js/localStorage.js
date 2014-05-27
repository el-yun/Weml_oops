//document.write('<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css" />');
//document.write('<script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>');
/**
�޸𸮳��� Ŭ�������� ����
*/
var ClassStorage = function()
{

	/**
	*
	*	���� Ŭ������ ����ID ��ȯ
	*
	*	@param value	���� Ŭ������ ���� ID
	*	@return ����
	*/
	this.makeClass_ = function(value)
	{
		return value;
	};
	
	/**
	*
	*	��� ���� ����
	*
	*	@param classname	���� Ŭ���� �̸�
	*	@param classcount	���ݱ��� ������� Ŭ���� ����
	*	@param	value		Ŭ������ ���ϴ� ����JSON ������
	*	@return 1 ��������
	*/
	this.saveMembervar = function(classname, classcount, value)
	{
		var key = classname+"_var_"+classcount;
		localStorage.setItem(key, value);
		return 1;
	};
	
	/**
	*
	*	��� �Լ� ����
	*
	*	@param classname	���� Ŭ���� �̸�
	*	@param classcount	���ݱ��� ������� Ŭ���� ����
	*	@param	value		Ŭ������ ���ϴ� �Լ�JSON ������
	*	@return 1 ��������
	*/
	this.saveMemberFunc = function(classname, classcount, value)
	{
		var key = classname+"_func_"+classcount;
		localStorage.setItem(key, value);
		return 1;
	};
	

	/*this.saveClassInfo = function(classname, variable, func)
	{
		//localStorage.setItem(class
	};*/


	/**
	*
	*	���ý��丮���� ����Ǿ� �ִ� �������/�Լ� ���
	*
	*	@param category		������� / ����Լ�
	*	@return html ������� / ����Լ��� HTML�±׷� ���
	*/
	this.showLocalStorage = function(category)
	{
		if(category == "variable")
		{
			//$("#"+currentClass+"_var").html("");
			//$("#classlist").html("");
			//alert(currentClass + "besth");
			var html ="";
			var data;
			var cnt = (localStorage.getItem(currentClass+"_varCnt"));
			if(cnt != 0)
			{
				for(var i=0; i<cnt; i++)
				{
					data = JSON.parse(localStorage.getItem(currentClass+"_var_"+i));
					html += "<div id='"+data.name+"' class='code_line'><b>";
					html += "<span id='var_access' onclick=\"showClassData('"+data.access+"','"+data.data+"','"+data.name+"','"+i+"')\""+"><font style='color:#aa7b00'>";
					html += data.access;
					html += "</font></span>&nbsp;&nbsp;<span id='var_data'>";
					html += data.data;
					html += "</span>&nbsp;&nbsp;<span id='var_name'>";
					html += data.name;
					html += "</span></b>";
					html += "<input type='hidden' id='var_cnt' value="+i+">";

					html += "</span>";
					html += "&nbsp;<img src=\"./img/revi.png\"  alt=\"�����ϱ�\" onclick=\"javascript:OperClass.modifyLocalStorage_('"+data.access+"','"+data.data+"','"+data.name+"','"+i+"', '"+'variable'+"', '0')\" id='"+data.name+"_show'>";
					html += "&nbsp;<img src=\"./img/del.png\"  alt=\"�����ϱ�\" onclick=\"OperClass.deleteLocalStorage('"+currentClass+"', '"+i+"', '"+'variable'+"')\">";
					html += "</div>";

					console.log(data.access + "= " + data.name + "=" + data.data);
				}
			}
			return html;
		}
		else if(category == "function")
		{
			var html = "";
			var data;
			var param = [];
			//var param = "'paramlist':[";
			var paramlist;
			var cnt = (localStorage.getItem(currentClass+"_funcCnt"));
			if(cnt != 0)
			{
				for(var i=0; i<cnt; i++)
				{
					data = JSON.parse(localStorage.getItem(currentClass+"_func_"+i));
					html += "<div id='"+data.name+"' class='code_line'>";
					html += "<span id='func_access'><font color='blue'><b>";
					html += data.access;
					html += "</font></span>&nbsp;&nbsp;<span id='func_data'>";
					html += data.returns;
					html += "</span>&nbsp;&nbsp;<span id='func_name'>";
					html += data.name;
					html += "</span>";
					html += "<input type='hidden' id='func_cnt' value="+i+">";
					html += "<span>(</span>";
					//if(data.param){
						/*for(var j=0; j<data.param.length; j++)
						{
							html += "<span id='param_data'>"+data.param[j].paramdata+"</span>&nbsp;&nbsp;";
							html += "<span id='param_name'>"+data.param[j].paramname+"</span>";
							html += "<span>,</span>";
							//param += "{\\\"paramdata\\\":\\\""+data.paramlist.param[j].paramdata+"\\\", \\\"paramname\\\":\\\""+data.paramlist.param[j].paramname+"\\\"},";
							//param += "{'paramdata':'"+data.paramlist.param[j].paramdata+"', 'paramname':'"+data.paramlist.param[j].paramname+"'},";
							param[j] = new addParameter(data.paramlist.param[j].paramdata, data.paramlist.param[j].paramname);

						}*/
						//paramlist = new addFinalParameter(param);
						html += "<span id='param_name'>"+data.param+"</span>";
						html += "<input id='pp"+i+"' type='hidden' value='"+JSON.stringify(data.param)+"'>";
						html += "<span>)</b>";
						html += "<img src=\"./img/revi.png\" width=\"20\" height=\"20\" onclick=\"javascript:OperClass.modifyLocalStorage_('"+data.access+"','"+data.returns+"','"+data.name+"','"+i+"', '"+'function'+"', '"+data.param+"')\" id='"+data.name+"_show'>";
						html += "<img src=\"./img/del.png\" width=\"20\" height=\"20\"  onclick=\"OperClass.deleteLocalStorage('"+currentClass+"', '"+i+"', '"+'function'+"')\">";
					//}
					//else
					//{
					//	html += "<span>)</b>";
					//	html += "<button onclick=\"OperClass.deleteLocalStorage('"+currentClass+"', '"+i+"', '"+'function'+"')\">����</button>";
					//}
					html += "</div>";
					//param += "]}";
					//var str = param.substr(0, param.length-4);
					//str += "}]";
					//var t = JSON.stringify(param);


					//alert(paramlist.param[0].paramdata);
					//alert(JSON.stringify(paramlist));
					param.splice();
					//console.log(param.length);
					//param = "";
				}
			}
			return html;
		}
	};
	
	/**
	*
	*	������� / ����Լ� '����' ���̾�α׻��¿��� ��ҹ�ư�� ������ �� ȣ��Ǵ� �Լ�
	*
	*	@param ����
	*	@return ����
	*/
	this.modifycancle = function()
	{
		$("#show_modify").hide();
	}

	/**
	*
	*	���̾�׷� '����' ���̾�α׻��¿��� ��ҹ�ư�� ������ �� ȣ��Ǵ� �Լ�
	*
	*	@param ����
	*	@return ����
	*/
	this.diagramcancle = function()
	{
		$("#diagram_name").hide();
	}

	/**
	*
	*	������� / ����Լ��� ������ �� ȣ��Ǵ� �Լ�1
	*
	*	@param	access	����������
	*	@param	data	�ڷ���
	*	@param	name	����/�Լ� �̸�
	*	@param	cnt		���ݱ��� ������ ������� / ����Լ��� ����
	*	@param	category	������� / ����Լ�
	*	@param	length
	*	@return ����
	*/
	this.modifyLocalStorage_ = function(access,data,name,cnt,category,length)
	{
		
		var type;
		var dialogOpts;
		if(category == "variable")
		{
			var height = 200;
			var html = "";

			html += '<div class="inbox">';
			html += '<label>���������� &nbsp; ';
			if(access == "public")	html += '<input type="radio" value="public" name="var_access_txt" checked>Public'; else html += '<input type="radio" value="public" name="var_access_txt">Public';
			if(access == "private")	html += '<input type="radio" value="private" name="var_access_txt" checked>Private'; else html += '<input type="radio" value="private" name="var_access_txt">Private';
			if(access == "protected")	html += '<input type="radio" value="protected" name="var_access_txt" checked>Protected'; else html += '<input type="radio" value="protected" name="var_access_txt">Protected';
			html += '</label>';
			html += '<label>��&nbsp;&nbsp;&nbsp;&nbsp;��&nbsp;&nbsp;&nbsp;&nbsp;��&nbsp;';
			html += '<input type="text" name="var_data_txt" value=' + data + '>';
			html += '</label>';
			html += '<label>��&nbsp;��&nbsp;&nbsp;��&nbsp;�� &nbsp;';
			html += '<input type="text" name="var_name_txt" value=' + name + '>';
			html += '</label>';
			html += "<a class='grd_button shadow' href=\"javascript:OperClass.modifyLocalStorage('"+currentClass+"','"+access+"','"+data+"','"+name+"','"+cnt+"', '"+'variable'+"', '0')\">����</span>";
			html += "&nbsp;<a class='grd_button shadow' href=\"javascript:OperClass.modifycancle()\" >���</span>";
			html += '</div>';
			/*	dialogOpts = {
				title:"dd",
				modal:true,
				height:450,
				width:450,
				open:function()
				{
					//$(this).parents(".ui-dialog").find(".ui-dialog-title").remove();
				},
				buttons:{
					����:function()
					{
						OperClass.modifyLocalStorage(currentClass,access,data,name,cnt, type, '0');
						$(this).dialog('close');
					},
					Cancel:function()
					{$(this).dialog('close');}
					
				}
			};*/
		}
		else if(category == "function")
		{
			var height = 1000;
			//var param = JSON.parse($("#pp"+cnt).val());
			//alert(param.param[0].paramdata);
			var html = "";

			html += '<div class="inbox">';
			html += '<label>���������� &nbsp; ';
			if(access == "public")	html += '<input type="radio" value="public" name="func_access_txt" checked>Public'; else html += '<input type="radio" value="public" name="func_access_txt">Public';
			if(access == "private")	html += '<input type="radio" value="private" name="func_access_txt" checked>Private'; else html += '<input type="radio" value="private" name="func_access_txt">Private';
			if(access == "protected")	html += '<input type="radio" value="protected" name="func_access_txt" checked>Protected'; else html += '<input type="radio" value="protected" name="func_access_txt">Protected';
			html += '</label>';
			html += '<label>��&nbsp;&nbsp;&nbsp;&nbsp;ȯ&nbsp;&nbsp;&nbsp;&nbsp;�� &nbsp; ';
			html += '<input type="text" name="func_data_txt" value=' + data + '>';
			html += '</label>';
			html += '<label>��&nbsp;��&nbsp;&nbsp;��&nbsp;�� &nbsp; ';
			html += '<input type="text" name="func_name_txt" value=' + name + '>';
			html += '</label>';
			html += '<label>��&nbsp;��&nbsp;&nbsp;��&nbsp;�� &nbsp; ';
			html += '<input type="text" name="func_param_txt" value=' + length + '>';
			html += '</label>';
			html += "<a class='grd_button shadow' href=\"javascript:OperClass.modifyLocalStorage('"+currentClass+"','"+access+"','"+data+"','"+name+"','"+cnt+"', '"+'function'+"', '"+length+"')\">����</span>";
			html += "&nbsp;<a class='grd_button shadow' href=\"javascript:OperClass.modifycancle()\" >���</span>";
			html += '</div>';
		}
		$("#modify_field").html(html);
		$("#show_modify").show();
		//alert(html);
		//$('#modi').dialog({ dialogClass: "hide-title-bar" });
		//$('#modi').dialog(dialogOpts);

	};

	/**
	*
	*	������� / ����Լ��� ������ �� ȣ��Ǵ� �Լ�2
	*
	*	@param	currentClass	���� Ŭ������ ����ID
	*	@param	access	����������
	*	@param	data	�ڷ���
	*	@param	name	����/�Լ� �̸�
	*	@param	cnt		���ݱ��� ������ ������� / ����Լ��� ����
	*	@param	category	������� / ����Լ�
	*	@param	length
	*	@return ����
	*/
	this.modifyLocalStorage = function(currentClass, access, data, name, cnt, category, length)
	{	
		if(category == "variable")
		{
			var access_ = $("input[name=var_access_txt]:checked").val();
			var data_ = $("input[name=var_data_txt]").val();
			var name_ = $("input[name=var_name_txt]").val();
			localStorage.removeItem(currentClass+"_var_"+cnt);
			var result = new memberVarPro(access_, name_, data_);
			if(this.saveMembervar(currentClass, cnt, JSON.stringify(result)) == 1)
			{
				alert('���ý��丮�� �Է� ����');
				$("#"+currentClass+"_var").html(this.showLocalStorage("variable"));
				$("#show_modify").hide();
			}
		}
		else if(category == "function")
		{
			var access_ = $("input[name=func_access_txt]:checked").val();
			var data_ = $("input[name=func_data_txt]").val();
			var name_ = $("input[name=func_name_txt]").val();
			var param_ = $("input[name=func_param_txt]").val();
			localStorage.removeItem(currentClass+"_func_"+cnt);

			var result = new memberFuncPro(access_, name_, data_, param_);
			if(this.saveMemberFunc(currentClass, cnt, JSON.stringify(result)) == 1)
			{
				alert('���ý��丮�� �Է� ����');
				$("#"+currentClass+"_func").html(this.showLocalStorage("function"));
				$("#show_modify").hide();
			}
		}
		
	};


	/**
	*
	*	������� / ����Լ��� ������ �� ȣ��Ǵ� �Լ�
	*
	*	@param	currentClass	���� Ŭ������ ����ID
	*	@param	currentcnt		���� Ȱ��ȭ�� Ŭ������ �ѹ�
	*	@param	category	������� / ����Լ�
	*	@return ����
	*/
	this.deleteLocalStorage = function(currentClass, currentcnt, category)
	{
		//seolhee
		if(currentcnt == '-1')
		{
			var key_cnt = currentClass+"_varCnt";
			var cnt = localStorage.getItem(key_cnt);
			for(var i=0; i<(cnt*1); i++)
			{
				localStorage.removeItem(currentClass+"_var_"+i);
			}
			localStorage.removeItem(key_cnt);
			var key_cnt = currentClass+"_funcCnt";
			var cnt = localStorage.getItem(key_cnt);
			for(var i=0; i<(cnt*1); i++)
			{
				localStorage.removeItem(currentClass+"_func_"+i);
			}
				
			localStorage.removeItem(key_cnt);
			$("#"+currentClass+"_class").remove();

		}
		else
		{
			if(category == "variable")
			{
				localStorage.removeItem(currentClass+"_var_"+currentcnt);
				var key_cnt = currentClass+"_varCnt";
				var cnt = localStorage.getItem(key_cnt);
				var temp_cnt = cnt;
				if((cnt*1) == 1)
				{
					localStorage.setItem(key_cnt, (--cnt));
					$("#"+currentClass+"_var").html(this.showLocalStorage("variable"));
					return;
				}
				else
				{
					localStorage.setItem(key_cnt, (--cnt));
				}
				for(var i=(currentcnt*1)+1; i<temp_cnt; i++)
				{
					var data = JSON.parse(localStorage.getItem(currentClass+"_var_"+i));
					var result = new memberVarPro(data.access, data.name, data.data);
					this.saveMembervar(currentClass, i-1, JSON.stringify(result));
					localStorage.removeItem(currentClass+"_var_"+i);
				}
				
				$("#"+currentClass+"_var").html(this.showLocalStorage("variable"));

			}
			else if(category == "function")
			{	
				//var paramlist = JSON.parse($("#pp"+currentcnt).val());

				localStorage.removeItem(currentClass+"_func_"+currentcnt);

				var key_cnt = currentClass+"_funcCnt";
				var cnt = localStorage.getItem(key_cnt);
				var temp_cnt = cnt;
				//alert('this1');
				if((cnt*1) == 1)
				{
					//alert('this2');
					localStorage.setItem(key_cnt, (--cnt));
					$("#"+currentClass+"_func").html(this.showLocalStorage("function"));
					return;
				}
				else
				{
						
					//alert('this3');
					localStorage.setItem(key_cnt, (--cnt));
				}
				for(var i=(currentcnt*1)+1; i<temp_cnt; i++)
				{
					//alert('this4');
					data = JSON.parse(localStorage.getItem(currentClass+"_func_"+i));
					var result = new memberFuncPro(data.access, data.name, data.returns, JSON.parse($("#pp"+i).val()));
					this.saveMemberFunc(currentClass, i-1, JSON.stringify(result));
					localStorage.removeItem(currentClass+"_func_"+i);
				}
				
				$("#"+currentClass+"_func").html(OperClass.showLocalStorage("function"));
			}
		}
	};


}