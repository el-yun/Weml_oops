<?
	/**
	*  다이어그램 공개/비공개 수정을 위한 페이지
	*  각 다이어그램의 seq_id를 받아 해당 다이어그램의 공개 비공개 여부를 수정한다. 
	**/
	include("config.php");
	$db = new DataBase();
	$db->ConnectDB();
	
	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		// username, password, email sent from Form 
		$seqid=$_POST['seq_id']; 
		$category=$_POST['category'];
		
		if($category=="lock")
		{
			$sql="UPDATE t_diagram SET f_diagram_secret='1' WHERE seq_id='$seqid'";
		}
		else
		{
			$sql="UPDATE t_diagram SET f_diagram_secret='0' WHERE seq_id='$seqid'";
		}
		$result=mysql_query($sql);
		echo $seqid;
	}
	
?>