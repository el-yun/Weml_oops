<?
	
	session_start();
	include("../php/config.php");
	
	

	$script_start = "<script>";
	$script_end = "</script>";
	$html_start = "<html>";
	$html_end = "</html>";
	$seqid = $_REQUEST['seqid'];
	$jsondata = $_REQUEST['jsondata'];
	$jsonconn = $_REQUEST['jsonconn'];
	$jsonmember =  $_REQUEST['jsonmember'];

	$in_url = "http://210.118.34.36/Drawing/Tool_UML_Print.php";
	//echo $in_url;
	//$id = $_SESSION['login_user'];
	//$in_url = "../Drawing/Tool_UML_Print.html";
	
	$dir = "CutyCapt";
	chmod($dir, 0777);
	chdir($dir);
	$fp_data = fopen("./uml_jsondata.json", "w+");
	$fp_conn = fopen("./uml_jsonconn.json", "w+");
	$fp_mem = fopen("./uml_jsonmember.json", "w+");
	fwrite($fp_data, $jsondata);
	fwrite($fp_conn, $jsonconn);
	fwrite($fp_mem, $jsonmember);
	fclose($fp_data);
	fclose($fp_conn);
	fclose($fp_mem);

	$filename =  $seqid."_".date("YmdHis",time()). '.png'; // Will probably need to normalize 
	if(!file_exists('./UMLThumbnail/' . $filename)) {
		
	   putenv("DISPLAY=:0");
	  @exec('./CutyCapt --url=' . $in_url . ' --min-width=1000 --min-height=580 --js-can-open-windows=on --method=post --print-backgrounds=on --js-can-access-clipboard=on --plugins=on --java=on --javascript=on --private-browsing=on --delay=3000 --body-base64=on --body-string=on --out=' . './UMLThumbnail/' . $filename);

	}
	echo $filename;
/*
	if(file_exists('./UMLThumbnail/' . $filename))
	{
		$body = "<img src=\"".'./UMLThumbnail/' . $filename."\"">;
		echo $html_start.$body.$html_end;
	}
	else
	{
		$script_body = "alert('UML파일을 출력할 수 없습니다.');";

		echo $script_start.$script_body.$script_end;
	}*/
?>