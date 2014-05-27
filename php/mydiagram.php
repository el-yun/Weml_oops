<?
	session_start();
	include("config.php");
	define("LIMIT", 6);				// 페이지당 출력 레코드 수
	define("PAGE_SCALE", 5);		// 화면당 출력할 페이지 수
	define("TABLENUM", 5);

	/**
	*	현재 로그인 세션 체크
	*/
	if($_SESSION['login_user']) {
		$db = new DataBase();
		$db->ConnectDB();

		$category = $_REQUEST['category'];
		
		$memid=$_SESSION['login_user'];
			
		$sql="SELECT seq_id FROM t_member_info WHERE f_id='$memid'";
		$result=mysql_query($sql);
		$data=mysql_fetch_array($result);

		/**
		*	mydiagram의 List를 출력해주는 분기문
		*/
		if($category == "openmylist")
		{
			$start = $_REQUEST['start'];
			$currentpage = $_REQUEST['c_page'];
			$order = $_REQUEST['order']; // desc
			$sidx = $_REQUEST['sidx']; //f_date

			
			$count=mysql_num_rows($result);
			
			$count = $db->TotalRecord("SELECT * FROM t_diagram where f_memid='$data[seq_id]'");

			if( $count > 0 ) 
			{
				$total_pages = ceil($count/LIMIT);
			} else 
			{
				$total_pages = 0;
			}

			if( $currentpage <= 0 ) $currentpage = 1;
			else if ($currentpage > $total_pages) $currentpage=$total_pages;
			if($start <= 0) $start = 0;
			else $start = LIMIT*$currentpage - LIMIT;
			
			$page = floor($total_pages / PAGE_SCALE);
			$n_page = floor($_REQUEST['start'] / PAGE_SCALE);
			
			$result = $db->ODgetDiagramDataListFromID($start, LIMIT, $sidx, $order, $data[seq_id]);
			$html='';
			//<a href="#" id="save">Download</a>
			while($row = mysql_fetch_array($result, MYSQL_ASSOC))
			{
				$html .= "<li>";
				$html .= "<div class=\"boxgrid caption\">";
				
				$html .= "<img src=\"CutyCapt/Thumbnail/".$row[f_filename]."\" width=\"315\" height=\"215\">";
				$html .= "<div class=\"cover boxcaption\" style\"top: 185px;\">";
				$html .= "<h3 class=\"content-h3\">";
				if($row[f_diagram_secret] == 0) {
					$html .= "<a href=\"javascript:unlock($row[seq_id])\">[비공개]</a>"; // "<img id=\"lock\" src=\"images/lock.png\" height=\"18\" width=\"18\">";
				}
				
				else {
					$html .= "<a href=\"javascript:lock($row[seq_id])\">[공개]</a>"; //$html .= "<img id=\"lock_open\" src=\"images/lock_open.png\" height=\"18\" width=\"18\">";
				}
				

				$html .= "&nbsp;";
				$html .= $row[f_diagram_name];
				$html .= "</h3>";
				$html .= "<p>";
				$html .= $row[f_date];
				$html .= "<br>";
				$html .= "<a href=\"javascript:window.open('./Drawing/Tool_Canvas.htm?autoload=yes&seq=";
				$html .= $row[seq_id];
				$html .= "');\" target=\"_BLANK\">Modify Diagram</a>";
				$html .= "</p>";
				$html .= "</div>";
				$html .= "</div>";
				$html .= "</li>";
			}

			echo $html;
		}
		/**
		*	게시판의 페이지 네비게이터를 계산하는 분기문
		*/
		else if($category == "openmynavi")
		{
			$start = $_REQUEST['start'];
			$currentpage = $_REQUEST['c_page'];
			$option = $_REQUEST['option'];
			$keyword = $_REQUEST['keyword'];

			$memid=$_SESSION['login_user'];
			
			$sql="SELECT seq_id FROM t_member_info WHERE f_id='$memid'";
			$result=mysql_query($sql);
			$data=mysql_fetch_array($result);
			$count=mysql_num_rows($result);
			
			$count = $db->TotalRecord("SELECT * FROM t_diagram where f_memid='$data[seq_id]'");

			if( $count > 0 ) {
				$total_pages = ceil($count/LIMIT);
			} 
			else {
				$total_pages = 0;
			}
			
			if( $currentpage <= 0 ) $currentpage = 1;
			else if ($currentpage > $total_pages) $currentpage=$total_pages;
			if($start <= 0) $start = 0;
			else $start = LIMIT*$currentpage - LIMIT;
			
			$page = floor($total_pages / PAGE_SCALE);
			$n_page = floor($_REQUEST['start'] / PAGE_SCALE); 


			if($n_page > 0 ){ 
				$p_start = ($n_page-1)*PAGE_SCALE; 
				$c_page = $p_start+1;
				if($option != "")
				{
					$link = "<a class=\"pre\" href=\"javascript:sortSearchRecord(null, ${p_start},${c_page}, $option, $keyword);\"><span>Prev</span> </a>";
				}
				else
				{
					$link = "<a class=\"pre\" href=\"javascript:sortRecord(null, ${p_start},${c_page});\"><span>Prev</span> </a>";
				}
				echo $link." ";
			}
		
			$is = $n_page * PAGE_SCALE; 
		
			for($i=$is; $i<$is+PAGE_SCALE; $i++)
			{
				if($i < $total_pages){
					$c_page = $i+1;
					if($i+1 == $currentpage) {$link= "<strong>" . $currentpage  ."</strong>";}
					else 
					{
						if($option != "")
						{
							$link = "<a href=\"javascript:sortSearchRecord(null, ${i},${c_page}, $option, $keyword);\">";$link .=	$i+1;$link.="</a>";
						}
						else
						{
							$link = "<a href=\"javascript:sortRecord(null, ${i},${c_page});\">";$link .=	$i+1;$link.="</a>";
						}
					}	
					echo $link;			
				}
			}
			
			if($n_page < $page){
				$c_page = $i+1;
				if($option != "")
				{
					$link = "<a class=\"next\" href=\"javascript:sortSearchRecord(null, ${i},${c_page}, $option, $keyword);\"> <span>Next</span></a>";
				}
				else
				{
					$link = "<a class=\"next\" href=\"javascript:sortRecord(null, ${i},${c_page});\"> <span>Next</span></a>";
				}
				echo $link;
			}
		}
		
		/**
		*	MyDiagram에서 다이어그램 검색결과를 출력하는 분기문
		*/
		else if($category == "searchlist")
		{
			$start = $_REQUEST['start'];			// 1
			$currentpage = $_REQUEST['c_page'];		// 0
			$order = $_REQUEST['order'];			// desc
			$sidx = $_REQUEST['sidx'];				// f_date
			$option = $_REQUEST['option'];			//다이어그램 이름
			$keyword = $_REQUEST['keyword'];		// textbox값

			$count = $db->TotalMyRecordSearch($data[seq_id], $keyword);

			if( $count > 0 ) {
				$total_pages = ceil($count/LIMIT);
			} 
			else {
				$total_pages = 0;
			}

			if($currentpage <= 0 ) $currentpage = 1;
			else if($currentpage > $total_pages) $currentpage=$total_pages;
		
			if($start <= 0) $start = 0;
			else $start = LIMIT*$currentpage - LIMIT;
			

			$page = floor($total_pages / PAGE_SCALE);
			$n_page = floor($_REQUEST['start'] / PAGE_SCALE);

			$result = $db->ODgetSearchDataListFromID($start, LIMIT, $sidx, $order, $option, $keyword, $data[seq_id]);
			$html='';
			//$i=$db->TotalRecordSearch($option, $keyword);

			while($row = mysql_fetch_array($result, MYSQL_ASSOC))
			{
				$html .= "<li>";
				$html .= "<div class=\"boxgrid caption\">";
				$html .= "<img src=\"\" width=\"315\" height=\"215\">";
				$html .= "<div class=\"cover boxcaption\" style\"top: 185px;\">";
				$html .= "<h3 class=\"content-h3\">" . $row[f_diagram_name] . "</h3>";
				$html .= "<p>";
				$html .= $row[f_date];
				$html .= "<br>";
				$html .= "<a href=\"\" target=\"_BLANK\">Visit Website..</a>";
				$html .= "</p>";
				$html .= "</div>";
				$html .= "</div>";
				$html .= "</li>";
			}
			echo $html;
		}
		
		/**
		*	Main Page의 추천다이어그램 리스트를 출력하는 분기문
		*/
		else if($category == "mainrecommlist")
		{
			echo $db->MAINgetRecommList();
		}
	}
	else
	{
		echo 0;
	}
?>