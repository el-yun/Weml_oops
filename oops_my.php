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
</head>

<body>
	<? include "outlogin.php" ?>
	<header>
		<a href="oops_home.php" title="adinath web solutions">
			<div class="logo"></div>
		</a>
		<nav id="topnav" role="navigation">
			<ul>
				<li>
					<a href="oops_home.php" title="OOPs's home" style="opacity: 0.5;">HOME</a>
				</li>
				<li><a href="oops_about.php" title="About WeML?" style="opacity: 0.5;">About WeML?</a></li>
				<li><a href="oops_my.php" class="active" title="Manage to my diagram" style="opacity: 1;">My Diagram</a></li>
				<li><a href="oops_open.php" title="Open Diagram" style="opacity: 0.5;">Open Diagram</a></li>
				<li class="topnav-lastchild"><a href="oops_contect.php" title="Contect us" style="opacity: 0.5;">Contect</a></li>
			</ul>
		</nav>
	</header>
	
	<section id="intro">
		<!-- Introduction -->
		<div ><img src="images/concept_01.png" width="940" height="236" border="0" alt=""></div>
	</section>
	
	<div id="main">
		<div id="maincontainer">
			<section id="diagram-content-container" role="main">
			
			<ul></ul>
				
			<div class="srch" id="select_val">
				<select>
					<option>다이어그램이름</option>
				</select>
				<input type="text" accesskey="s" title="검색어" class="keyword" id="keyword">
				<input type="image" alt="검색" src="images/btn_srch.gif" id="search">
			</div>
			<div class="paginate" id="paginate">
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
						<li><a href="oops_my.php" title="Manage to my diagram">My Diagram</a></li>
						<li><a href="oops_open.php" title="why adinath web solutions">Open Diagram</a></li>
						<li><a href="oops_contect.php" title="why adinath web solutions">Forum</a></li>
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
	
	<!--<script src="http://cdn.jquerytools.org/1.2.6/full/jquery.tools.min.js"></script>-->
	<script src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
	<script defer="" src="../js/custom.js"></script>
	<script src="../js/mydiagram.js"></script>
  
</body>
</html>