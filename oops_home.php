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
</head>
<script type="text/javascript">
$(document).ready(function(){
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
});
</script>
<body>

	<!--<div class="topbar-container">-->
	<? include "outlogin.php" ?>
	<header>
		<a href="oops_home.php" title="oops homepage">
			<div class="logo"></div>
		</a>
		<nav id="topnav" role="navigation">
			<ul>
				<li><a href="oops_home.php" class="active" title="OOPs's home" style="opacity: 1;">HOME</a></li>
				<li><a href="oops_about.php" title="About WeML?" style="opacity: 0.5;">About WeML?</a></li>
				<li><a href="oops_my.php" title="Create Diagram" style="opacity: 0.5;">My Diagram</a></li>
				<li><a href="oops_open.php" title="Open Diagram" style="opacity: 0.5;">Open Diagram</a></li>
				<li class="topnav-lastchild"><a href="oops_contect.php" title="Forum" style="opacity: 0.5;">Contect</a></li>
			</ul>
		</nav>
	</header>
	
	<section id="intro">
		<div class="intro-content">
			<img src="./images/banner-bg.png" width="940" height="236" border="0" usemap="#Map" />
			<map name="Map" id="Map">
			<?
				if($_SESSION['login_user']){
			?>
			  <area shape="rect" coords="65,136,354,202" href="#" onclick="window.open('./Drawing/Tool_Canvas.htm');">
			 <?} else{?>
				<area shape="rect" coords="65,136,354,202" href="#" onclick="alert('로그인이 필요합니다.');">
			<?}?>
			</map>
		</div>

		<!--
		<div class="intro-img">
			<a href="#">
				<img src="images/adaptive-web-design_bannerimg.png" alt="" width="254" height="170">
			</a>
		</div>
		-->
	</section>
	
	<div id="main">
		<div id="maincontainer">
			<aside id="main-aside">
				<!-- side bar -->
				<span class="headings">추천 다이어그램</span>
				<div class="rightside-content" id="recommlist">
					<ul class="contactd">
						<li id="rank-1">사각형 다이어그램, soajo</li>
						<li id="rank-2">스택, besth</li>
						<li id="rank-3">우선순위큐, lovesorka</li>
						<li id="rank-4">리그오브레전드, DAK</li>
						<li id="rank-5">마우스 이벤트 핸들러, Roi Kim</li>
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

			<!-- 여기를 채워주면 된다. Home Main -->
			<div id="weml_introduce" class="introduce">
				<!--<table width="100%" height="100%" border="0px">
					<tr>
						<td class="piece-introduce">asdf</td>
						<td class="piece-introduce"></td>
					</tr>

					<tr>
						<td class="piece-introduce"></td>
						<td class="piece-introduce"></td>
					</tr>
				</table>-->


				<div class="piece-introduce">
					<span class="title-font">Create Diagram</span><br>
					<span class="body-font">WE ML의 OOPs툴을 이용하여 다양한 다이어그램을 만들 수 있습니다.
					<img src="../images/diagram.png" class="image-style" width="290px" height="130px">
					</span>
				</div>

				<div class="piece-introduce">
					<span class="title-font">Convert UML</span><br>
					<span class="body-font">OOPs는 만들어진 다이어그램을 UML 형식으로 변환해주는 기능을 포함하고 있습니다.
					<img src="../images/urml.png" class="image-style" width="290px" height="130px">
					</span>
				</div>

				<div class="piece-introduce">
					<span class="title-font">Sharing Diagram</span><br>
					<span class="body-font">다른 사용자들과 자신의 다이어그램을 공유할 수 있습니다. 다른 사용자의 디자인을 참고하세요.
					<img src="../images/share.png" class="image-style" width="290px" height="130px">
				</div>

				<div class="piece-introduce">
					<span class="title-font">Code Generate</span><br>
					<span class="body-font">OOPs UML로 변환된 설계도를 코드로
					변환해 주는 기능을 포함하고 있습니다.<br>
					<img src="../images/test.png" class="image-style">
					</span>
				</div>
			</div>

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

	<script src="http://cdn.jquerytools.org/1.2.6/full/jquery.tools.min.js"></script>
	<script defer="" src="../js/custom.js"></script>
	
</body>
</html>