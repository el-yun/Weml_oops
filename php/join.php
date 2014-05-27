<?
	/**
	*  회원가입을 위한 페이지. 
	*  각 id. pw, email을 등록받아 sql에 등록한다. 
	*  세션 등록을 통해 로그인 세션을 유지한다.
	**/
	include("config.php");
	session_start();
	$db = new DataBase();
	$db->ConnectDB();
	
	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		// username, password, email sent from Form 
		$myusername=$_POST['memid']; 
		$mypassword=$_POST['mempw']; 
		$myemail=$_POST['mememail'];

		$sql="SELECT seq_id FROM t_member_info WHERE f_id='$myusername'";
		$result=@mysql_query($sql);
		$count=@mysql_num_rows($result);
		
		//echo $count;

		if($count==0)
		{
			$sql="INSERT INTO `t_member_info`(`f_id`, `f_pw`, `f_email`, `f_date`) VALUES ('$myusername', password('$mypassword'), '$myemail', now())";
			$result=mysql_query($sql) or die("Couldn't execute query.".mysql_error());

			session_register("myusername");
			$_SESSION['login_user']=$myusername;

			//header("location: ../oops_home.php");
			echo 0;
		}
		else
		{
			echo -1;
		}
	}
	
?>