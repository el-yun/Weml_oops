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
<script type="text/javascript">
	
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
				<li><a href="oops_my.php" title="Create Diagram" style="opacity: 0.5;">My Diagram</a></li>
				<li><a href="oops_open.php" title="Open Diagram" style="opacity: 0.5;">Open Diagram</a></li>
				<li class="topnav-lastchild"><a href="oops_contect.php" class="active" title="Forum" style="opacity: 1;">Contect</a></li>
			</ul>
		</nav>
	</header>
	

			<div style="text-align:center; margin-top: 5px;margin-bottom: 5px;"><img src="images/concept_03.png" width="940" height="236" border="0" alt=""></div>
	
	<div id="main">
		<div id="maincontainer">
			<aside id="main-aside">
				<!-- side bar -->
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
				<span class="headings">Team Member</span>
				<div class="rightside-content">
					<ul class="contactd">
						<li id="q-man">PL, 21-2기 소상훈</li>
						<li id="q-woman">Developer, 21-1기 황설희</li>
						<li id="q-man">Developer, 22-1기 윤지환</li>
					</ul>
				</div>
			</aside>
			<section id="content-contatiner" role="main">
				<iframe style="border:solid 1px #666666;" width="715" height="600" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?q=%EC%A0%84%EC%A3%BC+%EC%82%BC%EC%84%B1%EC%86%8C%ED%94%84%ED%8A%B8%EC%9B%A8%EC%96%B4%EB%A9%A4%EB%B2%84%EC%8B%AD&amp;hl=ko&amp;ie=UTF8&amp;sll=35.833469,127.120737&amp;sspn=0.001674,0.002658&amp;hq=%EC%82%BC%EC%84%B1%EC%86%8C%ED%94%84%ED%8A%B8%EC%9B%A8%EC%96%B4%EB%A9%A4%EB%B2%84%EC%8B%AD&amp;hnear=%EB%8C%80%ED%95%9C%EB%AF%BC%EA%B5%AD+%EC%A0%84%EB%9D%BC%EB%B6%81%EB%8F%84+%EC%A0%84%EC%A3%BC%EC%8B%9C&amp;t=m&amp;ll=35.833341,127.120462&amp;spn=0.00788,0.015932&amp;z=14&amp;iwloc=A&amp;cid=12883216954751199908&amp;output=embed">
				</iframe>
				<br>
				<small>View <a href="https://maps.google.com/maps?q=%EC%A0%84%EC%A3%BC+%EC%82%BC%EC%84%B1%EC%86%8C%ED%94%84%ED%8A%B8%EC%9B%A8%EC%96%B4%EB%A9%A4%EB%B2%84%EC%8B%AD&amp;hl=ko&amp;ie=UTF8&amp;sll=35.833469,127.120737&amp;sspn=0.001674,0.002658&amp;hq=%EC%82%BC%EC%84%B1%EC%86%8C%ED%94%84%ED%8A%B8%EC%9B%A8%EC%96%B4%EB%A9%A4%EB%B2%84%EC%8B%AD&amp;hnear=%EB%8C%80%ED%95%9C%EB%AF%BC%EA%B5%AD+%EC%A0%84%EB%9D%BC%EB%B6%81%EB%8F%84+%EC%A0%84%EC%A3%BC%EC%8B%9C&amp;t=m&amp;ll=35.833341,127.120462&amp;spn=0.00788,0.015932&amp;z=14&amp;iwloc=A&amp;cid=12883216954751199908&amp;source=embed" style="color:#0000FF;text-align:left">O_Ops</a> in a larger map</small>
				
			</section>
		</div>
	</div>

	<section>
		<!-- Main content area -->
		<br><br><br><br>
	</section>

	
	
	<footer>
		<div id="bottom">
			<ul>
				<li class="bottommenu">
					<ul>
						<li><a href="oops_home.php" title="oops website homepage">Home</a></li>
						<li><a href="oops_about.php" title="why adinath web solutions">About WeML</a></li>
						<li><a href="oops_my.php" title="Manage to my diagram">My Diagram</a></li>
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