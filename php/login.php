<?
	/**
	*  로그인 페이지.
	*  아이디, 암호를 받아 세션에 등록한다.
	**/
	include("config.php");
	session_start();

	$db = new DataBase();
	$db->ConnectDB();

	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		// username and password sent from Form 
		$myusername=$_POST['username']; 
		$mypassword=$_POST['password']; 
		
		$sql="SELECT seq_id FROM t_member_info WHERE f_id='$myusername' and f_pw=password('$mypassword')";
		$result=mysql_query($sql);
		$count=mysql_num_rows($result);
		
		//echo $count;
		
		if($count==1)
		{
			session_register("myusername");
			$_SESSION['login_user']=$myusername;

			header("location: ../oops_home.php");
		}
		else
		{
			$error="Your Login Name or Password is invalid";
			header("location: ../oops_login.php");
		}
	}
	
?>