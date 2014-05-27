
<?
	header("Content-Type: text/html; charset=UTF-8");
	$category = $_REQUEST['category'];
	$downfile = $_REQUEST['name'];

	if($category == "h")
	{
		$downfile.= ".h";
	}
	else
	{
		$downfile.= ".cpp";
	}
	
	
	$seq_id = $_REQUEST['seqid'];
	$downfiledir= '/code/'.$seq_id.'/';
	if(file_exists($_SERVER['DOCUMENT_ROOT'].$downfiledir.$downfile))
	{
		Header("Content-Type:application/octet-stream");
		Header("Content-Disposition:attachment; filename=$downfile");
		Header("Content-Transfer-Encoding: binary");
		Header("Content-Length : ".(string)(filesize($_SERVER['DOCUMENT_ROOT'].$downfiledir.$downfile)));
		Header("Cache-Control:cache, must-revalidate");
		Header("Pragma:no-cache");
		Header("Expires:0");
		
		chmod($_SERVER['DOCUMENT_ROOT'].$downfiledir.$downfile, 0777);
		$fp = fopen($_SERVER['DOCUMENT_ROOT'].$downfiledir.$downfile, "rb");
		
		while(!feof($fp))
		{
			echo fread($fp, 100*1024);
		}
		fclose($fp);
		flush();
	}
	else 
	{	
		echo $_SERVER['DOCUMENT_ROOT'].$downfiledir.$downfile;
		//echo "<script>alert('파일이 존재하지 않습니다.');history.back(-1);</script>";
	}//http://210.118.34.36/php/filedownload.php?name=tt&seqid=36
?>