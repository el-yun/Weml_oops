<?
	include("../php/config.php");
	session_start();
	
	$db = new DataBase();
	$db->ConnectDB();

	/** get Data(POST) **/
	$diagram=$_REQUEST['diagram']; 
	$resource=$_REQUEST['resource'];
	$explain=$_REQUEST['explain'];
	$diagramname=$_REQUEST['diagramname'];
	$secret=$_REQUEST['secret'];
	$id = $_SESSION['login_user'];
	$jsondata = $_REQUEST['jsondata'];
	$jsonconn = $_REQUEST['jsonconn'];
	$seqid = $_REQUEST['seqid'];
	//$filename = "not";

	/** capture Woring **/
	$in_url = 'http://210.118.34.36/Drawing/Tool_Capture.php';

	$dir = "CutyCapt";
	chmod($dir, 0777);
	chdir($dir);
	$fp_data = fopen("./jsondata.json", "w+");
	$fp_conn = fopen("./jsonconn.json", "w+");
	fwrite($fp_data, $jsondata);
	fwrite($fp_conn, $jsonconn);
	fclose($fp_data);
	fclose($fp_conn);

	if($seqid != 0)
	{
		$sql = "SELECT f_filename FROM t_diagram WHERE seq_id = '$seqid'";
		$result = mysql_query($sql) or die("Couldn't execute query.".mysql_error());

		while($row = mysql_fetch_array($result, MYSQL_ASSOC))
		{
			$filename = $row[f_filename];
		}
		unlink("../CutyCapt/Thumbnail/".$filename);
		$filename =  $id."_".date("YmdHis",time()). '.png'; // Will probably need to normalize filename too, this is just an illustration
		   putenv("DISPLAY=:0");
		  @exec('./CutyCapt --url=' . $in_url . ' --min-width=1000 --min-height=580 --js-can-open-windows=on --method=post --print-backgrounds=on --js-can-access-clipboard=on --plugins=on --java=on --javascript=on --private-browsing=on --delay=3000 --body-base64=on --body-string=on --out=' . './Thumbnail/' . $filename);

		$sql = "UPDATE t_diagram SET f_diagram_info = '$diagram', f_diagram_name='$diagramname', f_diagram_explanation = '$explain', f_drawing='$jsondata', f_drawing_connect = '$jsonconn', f_filename='$filename', f_date = now() WHERE seq_id='$seqid'";
		$result=mysql_query($sql) or die("Couldn't execute query.".mysql_error());
		echo $result;
	}
	else
	{
		$filename =  $id."_".date("YmdHis",time()). '.png'; // Will probably need to normalize filename too, this is just an illustration
		if(!file_exists($filename)) {
		   putenv("DISPLAY=:0");
		  @exec('./CutyCapt --url=' . $in_url . ' --min-width=1000 --min-height=580 --js-can-open-windows=on --method=post --print-backgrounds=on --js-can-access-clipboard=on --plugins=on --java=on --javascript=on --private-browsing=on --delay=3000 --body-base64=on --body-string=on --out=' . './Thumbnail/' . $filename);
		}
		$sql="INSERT INTO t_diagram(`f_memid`, `f_diagram_info`, `f_diagram_name`, `f_diagram_explanation`, `f_diagram_like`, `f_diagram_secret`, `f_drawing`, `f_drawing_connect`, `f_filename`, `f_date`) VALUES ((select seq_id from t_member_info where f_id = '$id'), '$diagram', '$diagramname', '$explain', '0', '$secret', '$jsondata', '$jsonconn', '$filename', now())";

		$result=mysql_query($sql) or die("Couldn't execute query.".mysql_error());
		echo $result;
		//echo 1;
		  header('Content-type: image/png');
		 print file_get_contents($filename);
	}


	/** DB Wokring **/
	
	


	//$count=mysql_num_rows($result);
?>