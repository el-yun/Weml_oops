  <div id="access">
		<div class="member">
			<ul>
				<? if($_SESSION['login_user']) { ?>
				<li><a href="./php/logout.php" id="memberlogout">Logout</a></li> 
				<? } else { ?>
				<li><a href="oops_login.php" id="memberlogin">Login</a></li>
				<? } ?>
				<? if(!$_SESSION['login_user']) { ?>
				<li><a href="oops_join.php" id="memberjoin">Join</a></li>
				<? } ?>
			</ul>
			
		</div>
	</div>