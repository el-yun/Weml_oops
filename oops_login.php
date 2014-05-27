<?
 session_start();
?>
<!DOCTYPE html>
<html>
<head>	
	<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">

	<title> OOP's | WeML </title>
	<link rel="stylesheet" href="css/oops_login.css" />
	<link rel="stylesheet" href="css/oops_common.css" />
</head>
<body>
	<div id="top"></div>
	<div class="topbar-container">
		<div class="member">
			<ul>
				<li><a href="oops_login.php" id="memberlogin">login</a></li>
				<li><a href="oops_join.php" id="memberjoin">join</a></li>
			</ul>
			
		</div>
	</div>
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
				<li><a href="oops_my.php" title="Create Diagram" style="opacity: 0.5;">My Diagram</a></li>
				<li><a href="oops_open.php" title="Open Diagram" style="opacity: 0.5;">Open Diagram</a></li>
				<li class="topnav-lastchild"><a href="oops_contect.php" title="Forum" style="opacity: 0.5;">Contect</a></li>
			</ul>
		</nav>
	</header>
	<article>
		<form id="login" action="php/login.php" method="post">
		<h1>Log In</h1>
		<fieldset id="inputs">
			<input name="username" type="text" placeholder="Username" autofocus required>
			<input name="password" type="password" placeholder="Password" required>
		</fieldset>
		<fieldset id="actions">
			<input type="submit" id="memlogin" value="로그인">
			<input type="button" id="memregister" value="회원가입">
			<a href="">Forgot your password?</a>
		</fieldset>
		</form>
	</article>
	
	
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
	<script type="text/javascript">
		$(document).ready(function(){
			$("#memregister").click(function(){
				location.replace("oops_join.php");
			});
		});
	</script>
  
</body>
</html>