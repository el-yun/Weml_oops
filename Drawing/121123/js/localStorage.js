
/**
메모리내에 클래스영역 생성
*/
var ClassStorage = function()
{

	this.makeClass = function(value)
	{
		return value;
	};
	
	this.saveMembervar = function(classname, classcount, value)
	{
		var key = classname+"_var_"+classcount;
		localStorage.setItem(key, value);
		return 1;
	};

	this.saveMemberFunc = function(classname, classcount, value)
	{
		var key = classname+"_func_"+classcount;
		localStorage.setItem(key, value);
		return 1;
	};

	this.saveClassInfo = function(classname, variable, func)
	{
		//localStorage.setItem(class
	};

	this.showLocalStorage = function(category)
	{
		if(category == "variable")
		{
			var html ="";
			var data;
			var cnt = (localStorage.getItem(currentClass+"_varCnt"));
			if(cnt != 0)
			{
				for(var i=0; i<cnt; i++)
				{
					data = JSON.parse(localStorage.getItem(currentClass+"_var_"+i));
					html += "<span id='"+data.name+"'><b>";
					html += "<span id='var_access' onclick=\"showClassData('"+data.access+"','"+data.data+"','"+data.name+"','"+i+"')\""+"><font color='blue'>";
					html += data.access;
					html += "</font></span>&nbsp;&nbsp;<span id='var_data'>";
					html += data.data;
					html += "</span>&nbsp;&nbsp;<span id='var_name'>";
					html += data.name;
					html += "</span></b>";
					html += "<input type='hidden' id='var_cnt' value="+i+">";

					html += "</span>";
					//html += "<a href='#' id='"+data.name+"_show'>&nbsp;</a>";
					html += "<button onclick=\"javascript:OperClass.modifyLocalStorage_('"+data.access+"','"+data.data+"','"+data.name+"','"+i+"')\" id='"+data.name+"_show'>수정</button>";
					html += "<button onclick=\"OperClass.deleteLocalStorage('"+currentClass+"', '"+i+"', '"+'variable'+"', '"+'0'+"')\">삭제</button>";
					html += "<br><br>";

					console.log(data.access + "= " + data.name + "=" + data.data);
				}
			}
			return html;
		}
		else if(category == "function")
		{
			var html = "";
			var data;
			var cnt = (localStorage.getItem(currentClass+"_funcCnt"));
			if(cnt != 0)
			{
				for(var i=0; i<cnt; i++)
				{
					data = JSON.parse(localStorage.getItem(currentClass+"_func_"+i));
					html += "<span id='"+data.name+"'>";
					html += "<span id='func_access'><font color='blue'><b>";
					html += data.access;
					html += "</font></span>&nbsp;&nbsp;<span id='func_data'>";
					html += data.returns;
					html += "</span>&nbsp;&nbsp;<span id='func_name'>";
					html += data.name;
					html += "</span>";
					html += "<input type='hidden' id='func_cnt' value="+i+">";
					html += "<span>(</span>";

					for(var j=0; j<data.paramlist.param.length; j++)
					{
						html += "<span id='param_data'>"+data.paramlist.param[j].paramdata+"</span>&nbsp;&nbsp;";
						html += "<span id='param_name'>"+data.paramlist.param[j].paramname+"</span>";
						html += "<span>,</span>";
					}

					html += "<span>)</span></b>";
					html += "<button onclick=\"OperClass.deleteLocalStorage('"+currentClass+"', '"+i+"', '"+'function'+"','"+data.paramlist.param+"')\">삭제</button>";
				}
			}
			return html;
		}
	};

	this.modifyLocalStorage_ = function(access,data,name,cnt)
	{
		var html = "";
		html += '<div style="border:0px solid red;">';
		html += '<table><thead>';
		html += '<th>접근제한자</th><th>자료형</th><th>이름</th>';
		html += '</thead><tbody><tr>';
		html += '<td align="center"><font color="red">'+access+'</font></td>';
		html += '<td align="center"><font color="red">'+data+'</font></td>';
		html += '<td align="center"><font color="red">'+name+'</font></td>';


		html += '<tr><td>';
		html += '<input type="text" name="var_access_txt" size="7" value="';
		html += access;
		html += '"></td>';
		html += '<td>';
		html += '<input type="text" name="var_data_txt" size="7" value="';
		html += data;
		html += '"></td>';
		html += '<td>';
		html += '<input type="text" name="var_name_txt" size="10" value="';
		html += name;
		html += '"></td></tr></tbody></table>';

		html += "<a href=\"javascript:OperClass.modifyLocalStorage('"+currentClass+"','"+access+"','"+data+"','"+name+"','"+cnt+"')\" class=\"modify\">";
		html += '수정';
		html += '</a>';
		html += '</div>';
		$('#'+name+'_show').avgrund({
			height: 200,
			holderClass: 'custom',
			showClose: true,
			showCloseText: 'Close',
			enableStackAnimation: false,
			onBlurContainer: '.container',
			template:html
		});
		/*$('#'+name+'_show').html(html);
		var dialogOpts = {
			title:"dd",
			modal:true,
			height:450,
			width:450,
			open:function()
			{
				$(this).parents(".ui-dialog").find(".ui-dialog-titlebar").remove();
			},
			buttons:{
				수정:function()
				{$(this).dialog('close');},
				Cancel:function()
				{$(this).dialog('close');}
				
			}
		};
		//alert(html);
		$('#'+name+'_show').dialog({ dialogClass: "hide-title-bar" });
		$('#'+name+'_show').dialog(dialogOpts);	*/

	};

	this.modifyLocalStorage = function(currentClass, access, data, name, cnt)
	{	
		var access_ = $("input[name=var_access_txt]").val();
		var data_ = $("input[name=var_data_txt]").val();
		var name_ = $("input[name=var_name_txt]").val();
		if(access != access_) access = access_;
		else if(data != data_) data = data_;
		else if(name != name_) name = name_;

		localStorage.removeItem(currentClass+"_var_"+cnt);
		var result = new memberVarPro(access, name, data);
		if(this.saveMembervar(currentClass, cnt, JSON.stringify(result)) == 1)
		{
			alert('로컬스토리지 입력 성공');
			$("#"+currentClass).html(this.showLocalStorage("variable"));
		}
		
	};


	this.deleteLocalStorage = function(currentClass, currentcnt, category, param)
	{
		if(category == "variable")
		{
			localStorage.removeItem(currentClass+"_var_"+currentcnt);
			var key_cnt = currentClass+"_varCnt";
			var cnt = localStorage.getItem(key_cnt);
			var temp_cnt = cnt;
			if((currentcnt*1) == 0)
			{
				localStorage.setItem(key_cnt, (--cnt));
				$("#"+currentClass).html(this.showLocalStorage("variable"));
				return;
			}
			else
			{
				localStorage.setItem(key_cnt, (--cnt));
			}
			for(var i=(currentcnt*1)+1; i<temp_cnt; i++)
			{
				data = JSON.parse(localStorage.getItem(currentClass+"_var_"+i));
				var result = new memberVarPro(data.access, data.name, data.data);
				this.saveMembervar(currentClass, i-1, JSON.stringify(result));
				localStorage.removeItem(currentClass+"_var_"+i);
			}
			
			$("#"+currentClass+"_var").html(OperClass.showLocalStorage("variable"));

		}
		else if(category == "function")
		{	
			localStorage.removeItem(currentClass+"_func_"+currentcnt);

			var key_cnt = currentClass+"_funcCnt";
			var cnt = localStorage.getItem(key_cnt);
			var temp_cnt = cnt;
			if((currentcnt*1) == 0)
			{
				localStorage.setItem(key_cnt, (--cnt));
				$("#"+currentClass+"_func").html(OperClass.showLocalStorage("function"));
				return;
			}
			else
			{
				localStorage.setItem(key_cnt, (--cnt));
			}
			for(var i=(currentcnt*1)+1; i<temp_cnt; i++)
			{
				data = JSON.parse(localStorage.getItem(currentClass+"_func_"+i));
				var result = new memberFuncPro(data.access, data.name, data.returns, data.param);
				this.saveMemberFunc(currentClass, i-1, JSON.stringify(result));
				localStorage.removeItem(currentClass+"_func_"+i);
			}
			
			$("#"+currentClass+"_func").html(OperClass.showLocalStorage("function"));
		}
	};



	this.test = function()
	{
		return 0;
	};

}