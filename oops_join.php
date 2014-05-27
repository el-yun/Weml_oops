<?
 session_start();
?>
<!DOCTYPE html>
<html>
<head>	
	<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">

	<title> OOP's | WeML </title>

	<link rel="stylesheet" href="css/oops_join.css" />
	<link rel="stylesheet" href="css/oops_style.css" />
	<link rel="stylesheet" href="css/oops_common.css" />
</head>
<body>
	<div id="top"></div>
	<div class="topbar-container">
	</div>
	<header>
		<a href="oops_home.php" title="adinath web solutions">
			<div class="logo"></div>
		</a>
		<nav id="topnav" role="navigation">
			<ul>
				<li><a href="oops_home.php" title="OOPs's home" style="opacity: 0.5;">HOME</a></li>
				<li><a href="oops_about.php" title="About WeML?" style="opacity: 0.5;">About WeML?</a></li>
				<li><a href="oops_my.php" title="Manage to my diagram" style="opacity: 0.5;">My Diagram</a></li>
				<li><a href="oops_open.php" title="Open Diagram" style="opacity: 0.5;">Open Diagram</a></li>
				<li class="topnav-lastchild"><a href="oops_contect.php" title="Forum" style="opacity: 0.5;">Contect</a></li>
			</ul>
		</nav>
	</header>
	<section id="banner-inner">
		<hgroup id="hgroup-banner-inner">
			<h1>Join Member</h1>
			<h2>Please join this page to be O_Ops member!</h2>
		 </hgroup>
	</section>
	<article>
		<p>If you require a quotation for a specific requirement  please give a brief description in the comments field.</p>
		<div id="joinform" action="php/join.php" method="post">
			<div class="element">
				id *<br>
				<input id="memid" name="memid" type="text"  class="text" autofocus>
			</div>
			<div class="element">
				password *<br>
				<input id="mempw" name="mempw" type="password"  class="text" >
			</div>
			<div class="element">
				email *<br>
				<input id="mememail" name="mememail" type="email"  class="text" >
			</div>
			<br>
			<input type="button" id="memjoin" value="회원 가입">
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
	<script defer="" src="js/custom.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#memjoin").click(function(){
				if($("#memid").val()=="" || $("#mempw").val()=="" || $("#mememail").val()=="")
				{
					alert("빈 영역을 채워주세요.");
				}
				else {
					$.ajax({
						url: "php/join.php",
						type: "post",
						dataType: "json",
						data: ({"memid":$("#memid").val(),"mempw":$("#mempw").val(),"mememail":$("#mememail").val()}),
						success:function(response,status, request){
							if(response == -1)	// 중복 아이디일 경우
							{
								alert("이미 등록된 아이디입니다. 다른 아이디를 사용하세요.");
							}
							else				// 회원 가입이 완료된 경우
							{
								alert("가입이 완료되었습니다. oops에 가입하신 것을 환영합니다.");
								location.replace("oops_home.php");
							}
								
							//alert(response);	
						},
						error:function(request, status,error){
							alert("code:"+request.status+"\n"+"message:"+request.responseText);
						}
					});
				}
			});
		});
							
			
	</script>
  
</body>
</html>