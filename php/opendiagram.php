<?
	include("config.php");
	define("LIMIT", 8); // 페이지당 출력 레코드 수
	define("PAGE_SCALE", 5); // 화면당 출력할 페이지 수
	define("TABLENUM", 5);

	$db = new DataBase();
	$db->ConnectDB();

	$category = $_REQUEST['category'];

	/**
	*	open diagram의 List를 출력해주는 분기문
	*/
	if($category == "open")
	{
		echo $db->ODgetDiagramData(-1);
	}
	/**
	*	open diagram의 List를 출력해주는 분기문
	*/
	else if($category == "openlist")
	{
		$start = $_REQUEST['start'];
		$currentpage = $_REQUEST['c_page'];
		$order = $_REQUEST['order']; // desc
		$sidx = $_REQUEST['sidx']; //f_request_date

		$count = $db->TotalRecord("SELECT * FROM t_diagram where f_diagram_secret = 1");
	
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
		
		$page = floor($total_pages / PAGE_SCALE); //단위블럭 페이지수
		$n_page = floor($_REQUEST['start'] / PAGE_SCALE); // 현재 단위블럭 페이지 번호

		$result = $db->ODgetDiagramDataList($start, LIMIT, $sidx, $order);
		$html='';
		$i=$db->TotalRecord("SELECT * FROM t_diagram where f_diagram_secret = 1");

		while($row = mysql_fetch_array($result, MYSQL_ASSOC))
		{
			$url = "../oops_open_detail.php?seqid=".$row[seq_id];
			$html .= "<li>";
			$html .= "<a href=\"".$url."\"><span class=\"thumb\"><img src=\"CutyCapt/Thumbnail/".$row[f_filename]."\">";
			$html .= "<em>Click Diagram</em>";
			$html .= "</span>";
			$html .= "<strong>";
			$html .= $row[f_diagram_name];
			$html .= "</strong>";
			$html .= "</a><p>";
			$html .= $row[f_date];
			$html .= "</p></li>";
		}
		echo $html;
	}
	/**
	*	게시판의 페이지 네비게이터를 계산하는 분기문
	*/
	else if($category == "navi")
	{
		$start = $_REQUEST['start'];
		$currentpage = $_REQUEST['c_page'];
		//$order = $_REQUEST['order']; // desc
		//$sidx = $_REQUEST['sidx']; //f_request_date
		$option = $_REQUEST['option'];
		$keyword = $_REQUEST['keyword'];
		
		if($option != "")
		{
			//$Temp = "'$view[mb_id]'";
			$count = $db->TotalRecordSearch($option, $keyword);
			$option = "'$option'";
			$keyword = "'$keyword'";
			//addslashes($opt);

		}
		else
		{
			$count = $db->TotalRecord("SELECT * FROM t_diagram where f_diagram_secret = 1");
		}
	
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
		
		$page = floor($total_pages / PAGE_SCALE); //단위블럭 페이지수
		$n_page = floor($_REQUEST['start'] / PAGE_SCALE); // 현재 단위블럭 페이지 번호


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
	*	Open Diagram에서 특정 다이어그램을 선택 했을 때 다이어그램의 정보를 출력하는 분기문
	*/
	else if($category == "opendetail")
	{
		$seq_id = $_REQUEST['seqid'];
		echo $db->ODgetDiagramData($seq_id);
	}
	/**
	*	Open Diagram에서 다이어그램 검색결과를 출력하는 분기문
	*/
	else if($category == "searchlist")
	{
		$start = $_REQUEST['start'];
		$currentpage = $_REQUEST['c_page'];
		$order = $_REQUEST['order']; // desc
		$sidx = $_REQUEST['sidx']; //f_request_date
		$option = $_REQUEST['option']; //다이어그램이름
		$keyword = $_REQUEST['keyword']; //textbox값

		$count = $db->TotalRecordSearch($option, $keyword);

		if( $count > 0 ) 
		{
			$total_pages = ceil($count/LIMIT);
		} else 
		{
			$total_pages = 0;
		}
		
		if($currentpage <= 0 ) $currentpage = 1;
		else if($currentpage > $total_pages) $currentpage=$total_pages;
	
		if($start <= 0) $start = 0;
		else $start = LIMIT*$currentpage - LIMIT;
		
		$page = floor($total_pages / PAGE_SCALE); //단위블럭 페이지수
		$n_page = floor($_REQUEST['start'] / PAGE_SCALE); // 현재 단위블럭 페이지 번호

		$result = $db->ODgetSearchDataList($start, LIMIT, $sidx, $order, $option, $keyword);
		$html='';
		$i=$db->TotalRecordSearch($option, $keyword);

		while($row = mysql_fetch_array($result, MYSQL_ASSOC))
		{
			$url = "../oops_open_detail.php?seqid=".$row[seq_id];
			$html .= "<li>";
			$html .= "<a href=\"".$url."\"><span class=\"thumb\"><img src=\"CutyCapt/Thumbnail/".$row[f_filename]."\">";
			$html .= "<em>Click Diagram</em>";
			$html .= "</span>";
			$html .= "<strong>";
			$html .= $row[f_diagram_name];
			$html .= "</strong>";
			$html .= "</a><p>";
			$html .= $row[f_date];
			$html .= "</p></li>";
		}
		echo $html;

	}
	/**
	*	Open Diagram에서 다이어그램의 상세정보 페이지에서 'like'수를 올리는 분기문
	*/
	else if($category == "like")
	{
		//insert into t_diagram (seq_id, f_diagram_like) values (1, 1) on duplicate key update f_diagram_like = f_diagram_like + 1
		$seqid = $_REQUEST['seqid'];
		$result = $db->ODincreaseLikeCnt($seqid);
		if($result)
		{
			echo $db->ODgetLikeCnt($seqid);
		}
		else
		{
			echo "추천개수가 정상적으로 입력되지 않았습니다.";
		}
	}
	
	/**
	*	Main Page의 추천다이어그램 리스트를 출력하는 분기문
	*/
	else if($category == "mainrecommlist")
	{
		echo $db->MAINgetRecommList();
	}
?>