<?
	$id = $_REQUEST['seqid'];
	
	include("php/code.php");
	$_header = $header;
	$_cpp = $cpp;

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
 <HEAD>
  <title> OOP's | WeML </title>
	<meta charset="utf-8">
    <link rel="stylesheet" href="css/oops_style.css" />
	<link rel="stylesheet" href="css/oops_common.css" />
	<script src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
	<script src="js/json2.js"></script>
  <META NAME="Generator" CONTENT="EditPlus">
  <META NAME="Author" CONTENT="">
  <META NAME="Keywords" CONTENT="">
  <META NAME="Description" CONTENT="">
 </HEAD>
<style>
::-webkit-scrollbar {width: 8px; height: 8px; border: 3px solid #fff; }
::-webkit-scrollbar-button:start:decrement, ::-webkit-scrollbar-button:end:increment {display: block; height: 10px; background: url('./images/bg.png') #efefef}
::-webkit-scrollbar-track {background: #efefef; -webkit-border-radius: 10px; border-radius:10px; -webkit-box-shadow: inset 0 0 4px rgba(0,0,0,.2)}
::-webkit-scrollbar-thumb {height: 50px; width: 50px; background: rgba(0,0,0,.2); -webkit-border-radius: 8px; border-radius: 8px; -webkit-box-shadow: inset 0 0 4px rgba(0,0,0,.1)}
</style>
<script type="text/javascript">
$(document).ready(function (){
	//recommlist
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
			//$("#recommlist").html();
			
			//$("#likecnt").text(data);
		},
		error:function(x)
		{
			alert(x.responseText);
		}
	});

	$("#btnlike").click(function(e)
	{
		$.ajax({
			url:"./php/opendiagram.php",
			type:"POST",
			data:{category:'like', seqid:'<?=$id?>'},
			success:function(data)
			{
		
				$("#likecnt").text(data);
			},
			error:function(x)
			{
				alert(x.responseText);
			}
		});
	});
	$.ajax({
		url:"./php/opendiagram.php",
	    type:"POST",
		data:{category:'opendetail', seqid:'<?=$id?>'},
		success:function(data)
		{
			var data = JSON.parse(data);
			var diagramimg = '<div style="background-image:url(./CutyCapt/Thumbnail/'+data.diagram[0].fileimg+')" class="imgsize" id="diagramimg">';
			$("#dname").text(data.diagram[0].diagramname);
			$("#dname_").text(data.diagram[0].diagramname);
			$("#dex").text(data.diagram[0].diagramex);
			$("#did").text("제작자 : " + data.diagram[0].memid);
			$("#dda").text("[" + data.diagram[0].date + "]");
			$("#likecnt").text(data.diagram[0].diagramlike);
			$("#diagramimg").html(diagramimg);
			
			var header = "";
			header += "<a href=\"./php/filedownload.php?category=h&name="+data.diagram[0].diagramname+"&seqid="+'<?=$id?>'+"\">Header File</a>";
			$("#header").html(header);

			var cpp = "";
			cpp += "<a href=\"./php/filedownload.php?category=cpp&name="+data.diagram[0].diagramname+"&seqid="+'<?=$id?>'+"\">CPP File</a>";
			$("#cpp").html(cpp);
									
		},
		error:function(x)
		{
			alert(x.responseText);
		}
	});
});
</script>
 <BODY>
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
				<li class="topnav-lastchild"><a href="oops_contect.php" title="Forum" style="opacity: 0.5;">Contact</a></li>
			</ul>
		</nav>
	</header>
	<div id="main">
		<div id="maincontainer">
			<div style="text-align:center; margin-bottom: 5px;"><img src="images/concept_02.png" width="940" height="236" border="0" alt=""></div>
			<section id="diagram-content-container" role="main">
				<div class="diagraminfo">
				<div class="create_info"><span id="did"></span> <span id="dda"></span></div>
				    <div class="diagram_title"><span class='title_name' id="dname"></span></div>
					<div class="diagramright">
						<div class="cont_img" id="diagramimg"></div>
							<div class="load_bt">
								<a href="javascript:window.open('./Drawing/Tool_Canvas.htm?autoload=yes&seq=<?=$id?>');" class="btn btn-purple">
									<span>다이어그램 보기</span>
								</a>
								<a href="javascript:window.open('./Drawing/Tool_UML.html?autoload=yes&seq=<?=$id?>');" class="btn btn-orange">
									<span>UML 보기</span>
								</a>
							</div>
					</div>
					<div class="code_box">
							<div class="code_title" id="header">32434</div>
							<div class="code"><?=$_header?>
							</div>

							<div class="code_title"  id="cpp"></div>
							<div class="code"><?=$_cpp?>
							</div>
				  </div>
				</div>
			</section>
			
			<aside id="main-aside">
				<!-- side bar -->
				<span class="headings">추천 다이어그램</span>
				<div class="rightside-content" id="recommlist">
					<ul class="contactd">
						<li id="rank-1"></li>
						<li id="rank-2"></li>
						<li id="rank-3"></li>
						<li id="rank-4"></li>
						<li id="rank-5"></li>
					</ul>
				</div>
				<span class="headings">Contact Details</span>
				<div class="rightside-content">
					<ul class="contactd">
						<li id="q-email">
							<a href="mailto:soajo@jjssm.org">soajo@jjssm.org</a>
						</li>
						<li id="q-call">+82-632737064</li>
						<li id="q-address">대한민국, 전라북도 전주시 완산구 서신동 766번지 KT빌딩 7층, 삼성소프트웨어멤버십</li>
					</ul>
				</div>
			</aside>
		</div>
	</div>



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

 </BODY>
</HTML>
