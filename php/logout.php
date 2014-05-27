
<?
	/**
	*  로그아웃을 눌렀을 시 세션을 파괴시키고 oops_home 페이지로 이동하는 역할을 한다.
	*/
	session_start();
	if(session_destroy())
	{
		header("Location: ../oops_home.php");
	}
?>