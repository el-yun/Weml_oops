<?
	session_start();
	
	logincheck();
	
	/**
	*	현재 로그인된 유저가 있는지 세션을 체크하는 함수
	*
	*	@param	없음
	*	@return 없음
	*/
	function logincheck() {
		if($_SESSION['login_user']) {
			echo $_SESSION['login_user'];
		}
		else
		{
			echo 0;
		}
	}
?>