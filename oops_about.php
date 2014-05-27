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
		<a href="oops_home.php" title="oops homepage">
			<div class="logo"></div>
		</a>
		<nav id="topnav" role="navigation">
			<ul>
				<li>
					<a href="oops_home.php" title="OOPs's home" style="opacity: 0.5;">HOME</a>
				</li>
				<li><a href="oops_about.php" class="active" title="About WeML?" style="opacity: 1;">About WeML?</a></li>
				<li><a href="oops_my.php" title="Create Diagram" style="opacity: 0.5;">My Diagram</a></li>
				<li><a href="oops_open.php" title="Open Diagram" style="opacity: 0.5;">Open Diagram</a></li>
				<li class="topnav-lastchild"><a href="oops_contect.php" title="Forum" style="opacity: 0.5;">Contect</a></li>
			</ul>
		</nav>
	</header>
	
	<section id="intro">
		<div class="intro-content">
			<h1>Be the first, be the best, or be the different.</h1>  
			<h2>So sang hun, Hwang seol hee, Yoon ji hwan</h2>
			<p>WeML�� We Make Language�� ���ڷ�, ���� �Ｚ����Ʈ�������� �һ���,����ȯ,Ȳ���� ȸ������ ������ �����Դϴ�. ���α׷� ���� �� ���Ǵ� UML�� ���� ���� ���ϰ� ������ �� �ִ� ȯ�� ���ø� �������� �� ����� Ŭ���� ���̾�׷� ������ ���� �����ϰ��� �𿴽��ϴ�. �� ���α׷��� ���� ���� ���� UML�� ���� �� ������, ������ �� ���л����� �н� ȿ���� ����ϰ� �ֽ��ϴ�.</p> 
			<!-- ���⿡ ��ȯ�� ��ũ�Ѱ� �߰� �ϸ� �� -->
		</div>
		<div class="intro-img">
			<a href="#">
				<img src="images/weml-team.png" alt="" width="254" height="170">
			</a>
		</div>
		
	</section>
	
	<div id="main">
		<div id="maincontainer">
			<aside id="main-aside">
				<!-- side bar -->
				<span class="headings">Team Member</span>
				<div class="rightside-content">
					<ul class="contactd">
						<li id="q-man">PL, 21-2�� �һ���</li>
						<li id="q-woman">Developer, 21-1�� Ȳ����</li>
						<li id="q-man">Developer, 22-1�� ����ȯ</li>
					</ul>
				</div>
			</aside>
			<section id="content-contatiner" role="main">
				<iframe  width="720" height="396" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="images/img_so"></iframe>
				<iframe  width="720" height="396" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="images/img_hwang"></iframe>
				<iframe  width="720" height="396" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="images/img_yoon"></iframe>
				<br>
				
				
			</section>
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
						<a href="oops_main.php" title="oops website homepage">OOPs</a>
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