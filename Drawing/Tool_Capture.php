<html charset="euc-kr">
<head>

	<meta charset="utf-8" name="keywords" content="jqueryui graph, jqueryui diagram,jqueryui chart, jqueryui flowchart,javascript graph, javascript diagram,javascript chart, javascript flowchart,jquery graph, jquery diagram,jquery chart, jquery flowchart" />
<link rel="stylesheet" href="./css/jquery.ui.all.css">
	<?
		$fp_data = fopen("../CutyCapt/jsondata.json", "r");
		while($file = fgets($fp_data,1024)){
			$jsondata .= $file;
		}
		//echo nl2br($jsondata);
		fclose($fp_data);

		$fp_conn = fopen("../CutyCapt/jsonconn.json", "r");
		while($file = fgets($fp_conn,1024)){
			$jsonconn .= $file;
		}
		//echo nl2br($jsonconn);
		fclose($fp_conn);
	?>

	<script>
		var load_class = '<?=nl2br($jsondata)?>';
		var load_conn = '<?=nl2br($jsonconn)?>';
	</script>
	<script src="./js/jquery-1.6.2.min.js"></script>
	<script src="./js/jquery.ui.core.min.js"></script>
	<script src="./js/jquery.ui.widget.min.js"></script>
	<script src="./js/jquery.ui.mouse.min.js"></script>
	<script src="./js/jquery.ui.draggable.min.js"></script>
	<script src="./js/jquery.ui.resizable.min.js"></script>
	<script src="./js/jquery.ui.droppable.min.js"></script>
	<script src="./js/jquery.ui.button.min.js"></script>
	<script src="./js/jgraphui_capture.js"></script>
	<!--<script src="js/makejson.js"></script>
	<script src="js/localStorage.js"></script>
	<script src="js/class_module.js"></script>-->
	<script src="./js/wz_jsgraphics.js"></script>

	<link rel="stylesheet" href="./css/diagram.css">
	<link rel="stylesheet" href="./css/demos.css">
	<link rel="stylesheet" href="./css/Tool_layout.css">
	</head>
	<title>:: Oops Tools - Diagram Designer ::</title>


	
	<script>
	$(document).ready(function(){
		//$("#oops_canvas").html('aaaaa');
		var diagram = new Diagram(
					{
					'xPosition':50, 
					'yPosition':0, 
					'width':1000, 
					'height':580,
					'imagesPath': '/tool/images/',
					'connectionColor': '#AA0000'
					});	
		$("#oops_canvas").html(diagram.fromJSON_ime());
		
	});

	</script>
<body>
<div id="oops_area" class="capturescreen">
			<div id="oops_canvas">
			</div>
	</div>

	
</body>
</html>

	<?
		unlink("../CutyCapt/jsondata.json");
		unlink("../CutyCapt/jsonconn.json");
	?>