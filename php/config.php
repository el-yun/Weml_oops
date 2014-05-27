<?php

define("HOST", "210.118.34.31");
define("USER", "root");
define("PASS", "apmsetup");
define("DB", "oops");

class DataBase
{
	/**
	*	oops 데이터베이스에 연결하는 함수
	*
	*	@param 없음
	*	@return 없음
	*/
	function ConnectDB()
	{
		$bd = mysql_connect(HOST, USER, PASS) or die("db connect error - config.php line 6");
		mysql_select_db(DB, $bd) or die("db select error - config.php line 7");
	}

	/**
	*	open diagram의 List를 출력해주는 함수
	*
	*	@param index -1이면 공개다이어그램의 리스트를 아니면 특정 seq_id의 다이어그램 정보를 리턴
	*	@return 다이어그램의 정보를 리턴
	*/
	function ODgetDiagramData($data)
	{
		if($data == -1)
		{
			$table = "t_diagram";
			$query = "select * from ";
			$query .= $table;
			$query .= "  where f_diagram_secret = 1";
			
			$result = mysql_query($query) or die("Couldn't execute query.".mysql_error());
			$i=0;
			while($row = mysql_fetch_array($result, MYSQL_ASSOC))
			{
				$response->diagram[$i++] = array("memid"=>$row[f_memid], "diagraminfo"=>$row[f_diagram_info], "diagramname"=>$row[f_diagram_name], "diagramlike"=>$row[f_diagram_like], "diagramex"=>$row[f_diagram_explanation],"diagramsecret"=>$row[f_diagram_secret], 
						"date"=>$row[f_date], "fileimg"=>$row[f_filename], "diagramdrawing"=>$row[f_drawing], "diagramdrawing_connect"=>$row[f_drawing_connect]);
			}
		}
		else
		{
			$table = "t_diagram";
			$table_ = "t_member_info";

			$query = "select * from ";
			$query .= $table;
			$query .= " as td inner join ";
			$query .= $table_;
			$query .= " as tm where td.seq_id=";
			$query .= $data;
			$query .= " AND td.f_memid = tm.seq_id";
			$query .= " GROUP BY td.seq_id";
			//$query .= " AND f_diagram_secret = 1";
			$result = mysql_query($query) or die("Couldn't execute query.".mysql_error());
			$i=0;
			while($row = mysql_fetch_array($result, MYSQL_ASSOC))
			{
				$response->diagram[$i++] = array("memid"=>$row[f_id], "diagraminfo"=>$row[f_diagram_info], "diagramname"=>$row[f_diagram_name], "diagramlike"=>$row[f_diagram_like], "diagramex"=>$row[f_diagram_explanation],"diagramsecret"=>$row[f_diagram_secret], 
						"date"=>$row[f_date], "fileimg"=>$row[f_filename], "diagramdrawing"=>$row[f_drawing], "diagramdrawing_connect"=>$row[f_drawing_connect]);
			}
		}
			
		return json_encode($response);
	}
	
	/**
	*	Opendiagram에서 다이어그램의 리스트를 출력해주는 함수
	*
	*	@param start 페이지 네비게이터에서 사용하는 시작 페이지 넘버
	*	@param limit 한 페이지에서 보여주는 다이어그램의 개수
	*	@param sidx 정렬할 기준이 되는 컬럼명
	*	@param sord asc 혹은 desc(오름차순 혹은 내림차순)
	*	@return Query의 출력결과
	*/
	function ODgetDiagramDataList($start, $limit, $sidx, $sord)
	{
		$table = "t_diagram";
		$query = "select * from ";
		$query .= $table;
		$query .= " where f_diagram_secret = 1 ORDER BY $sidx $sord LIMIT $start, $limit";
		//echo $query;
		$result = mysql_query( $query ) or die("Couldn't execute query.".mysql_error());
		return $result;	
	}
	
	/**
	*	MyDiagram에서 다이어그램의 리스트를 출력해주는 함수, 로그인 아이디를 기반으로 한다.
	*
	*	@param start 페이지 네비게이터에서 사용하는 시작 페이지 넘버
	*	@param limit 한 페이지에서 보여주는 다이어그램의 개수
	*	@param sidx 정렬할 기준이 되는 컬럼명
	*	@param sord asc 혹은 desc(오름차순 혹은 내림차순)
	*   @param memid 로그인된 현재 아이디
	*	@return Query의 출력결과
	*/
	function ODgetDiagramDataListFromID($start, $limit, $sidx, $sord, $memid)
	{
		$table = "t_diagram";
		$query = "select * from ";
		$query .= $table;
		$query .= " where f_memid='$memid'";
		$query .= " ORDER BY $sidx $sord LIMIT $start, $limit";

		$result = mysql_query( $query ) or die("Couldn't execute query.".mysql_error());
		return $result;	
	}
	
	/**
	*	Opendiagram에서 검색한 다이어그램의 리스트를 출력해주는 함수
	*
	*	@param start 페이지 네비게이터에서 사용하는 시작 페이지 넘버
	*	@param limit 한 페이지에서 보여주는 다이어그램의 개수
	*	@param sidx 정렬할 기준이 되는 컬럼명
	*	@param sord asc 혹은 desc(오름차순 혹은 내림차순)
	*	@param option 이름검색 혹은 키워드검색
	*	@param keyword 검색할 키워드
	*	@return Query의 출력결과
	*/
	function ODgetSearchDataList($start, $limit, $sidx, $sord, $option, $keyword)
	{
		if($option == "다이어그램이름") 
		{
			$option = "f_diagram_name";
			
			$table = "t_diagram";
			$query = "select * from ";
			$query .= $table;
			$query .= " where ".$option." LIKE '%".$keyword."%' AND f_diagram_secret = 1";
			$query .= " ORDER BY $sidx $sord LIMIT $start, $limit";
		}
		else 
		{
			$option = "f_memid";
			$table = "t_diagram";
			$table_ = "t_member_info";
			$query = "select * from ";
			$query .= $table;
			//$query .= " as td inner join ";
			//$query .= $table_;
			//$query .= " as tm on td.f_memid=";
			$query .= " where f_memid=";
			$query .= "(select seq_id from ";
			$query .= $table_;
			$query .= " where f_id='".$keyword."') AND f_diagram_secret = 1";
			$query .= " GROUP BY seq_id ORDER BY $sidx $sord LIMIT $start, $limit";
		}
		$result = mysql_query( $query ) or die("Couldn't execute query.".mysql_error());
		return $result;	
		//select * from t_diagram where f_diagram_name  LIKE '%c%' order by f_date desc limit 1, 8
//http://210.118.34.36/php/opendiagram.php?category=searchlist&order=desc&sidx=f_date&start=1&c_page=0&option=다이어그램이름&keyword=class
	}

	/**
	*	MyDiagram 에서 검색한 다이어그램의 리스트를 출력해주는 함수, 아이디를 기반으로 한다.
	*
	*	@param start 페이지 네비게이터에서 사용하는 시작 페이지 넘버
	*	@param limit 한 페이지에서 보여주는 다이어그램의 개수
	*	@param sidx 정렬할 기준이 되는 컬럼명
	*	@param sord asc 혹은 desc(오름차순 혹은 내림차순)
	*	@param option 이름검색 혹은 키워드검색
	*	@param keyword 검색할 키워드
	*   @param %memid 내 아이디
	*	@return Query의 출력결과
	*/
	function ODgetSearchDataListFromID($start, $limit, $sidx, $sord, $option, $keyword, $memid)
	{
		$query = "select * from t_diagram where f_memid='$memid' and f_diagram_name like '%" . $keyword . "%'";

		$result = mysql_query( $query ) or die("Couldn't execute query.".mysql_error());
		return $result;	
	}
	
	/**
	*	검색결과의 레코드 수를 출력해주는 함수
	*
	*	@param option 이름검색 혹은 키워드검색
	*	@param keyword 검색할 키워드
	*	@return 레코드의 개수
	*/
	function TotalRecordSearch($option, $keyword)
	{
		if($option == "다이어그램이름") 
		{
			$option = "f_diagram_name";
			$table = "t_diagram";
			$query = "select * from ";
			$query .= $table;
			$query .= " where ".$option." LIKE '%".$keyword."%' AND f_diagram_secret = 1";
		}
		else 
		{
			$option = "f_memid";
			$table = "t_diagram";
			$table_ = "t_member_info";
			$query = "select * from ";
			$query .= $table;
			$query .= " as td inner join ";
			$query .= $table_;
			$query .= " as tm on td.f_memid=";
			$query .= "(select seq_id from ";
			$query .= $table_;
			$query .= " where f_id='".$keyword."') AND f_diagram_secret = 1 GROUP BY ".'td.'."seq_id";
			//select * from t_diagram as td inner join t_member_info as tm on td.f_memid = (select seq_id from t_member_info where f_id = 'besth')

		}


		//echo $query;
		
		$result = mysql_query($query);
		return mysql_num_rows($result);


	}
	/**
	*	마이다이어그램 페이지의 검색결과의 레코드 수를 출력해주는 함수
	*
	*	@param option 이름검색 혹은 키워드검색
	*	@param keyword 검색할 키워드
	*	@return 레코드의 개수
	*/
	function TotalMyRecordSearch($memid, $keyword)
	{
		$query = "select * from t_diagram where f_memid='$memid' and f_diagrma_name like %'$keyword'%";
		
		$result = mysql_query($query);
		return mysql_num_rows($result);
	}

	/**
	*	테이블의 총 레코드 수를 출력해주는 함수
	*
	*	@param sql 쿼리문
	*	@return 레코드의 개수
	*/
	function TotalRecord($sql)
	{
		$result = mysql_query($sql);
		return mysql_num_rows($result);
	}
	
	/**
	*	'like'개수를 증가시키는 함수
	*
	*	@param seqid 다이어그램의 유니크 키
	*	@return 성공여부(0, 1)
	*/
	function ODincreaseLikeCnt($seqid)
	{
		$table = "t_diagram";
		$query = "insert into ";
		$query .= $table;
		$query .= " (seq_id, f_diagram_like) values ($seqid, 1) on duplicate key update f_diagram_like = f_diagram_like + 1";

		$result = mysql_query($query) or die("Couldn't execute query.".mysql_error());
		
		if($result) return 1;
		else return 0;
	}

	/**
	*	'like'의 수를 리턴하는 함수
	*
	*	@param seqid 다이어그램의 유니크 키
	*	@return 'like'개수
	*/
	function ODgetLikeCnt($seqid)
	{
		$table = "t_diagram";
		$query = "select f_diagram_like from ";
		$query .= $table;
		$query .= " where seq_id = $seqid";
		
		$result = mysql_query($query);
		while($row = mysql_fetch_array($result, MYSQL_ASSOC))
		{
			return $row[f_diagram_like];
		}
		//return mysql_num_rows($result);
	}
	
	/**
	*	Main Page의 추천다이어그램 리스트를 출력하는 함수
	*
	*	@param 없음
	*	@return 'like'수가 높은 상위 5개 다이어그램의 정보
	*/
	function MAINgetRecommList()
	{
		//select distinct tm.f_id, td.f_diagram_like from t_diagram as td inner join t_member_info as tm group by td.f_diagram_like order by td.f_diagram_like desc limit 0, 5
		$table = "t_diagram";
		$table_ = "t_member_info";
		$query = "select distinct tm.f_id, td.f_diagram_like,td.f_diagram_name from ";
		$query .= $table;
		$query .= " as td inner join ";
		$query .= $table_;
		$query .= " as tm group by td.f_diagram_like order by td.f_diagram_like desc limit 0, 5";

		$result = mysql_query($query) or die("Couldn't execute query.".mysql_error());
		$i=0;
		while($row = mysql_fetch_array($result, MYSQL_ASSOC))
		{
			$response->likelist[$i++] = array("likecnt"=>$row[f_diagram_like], "id"=>$row[f_id], "name"=>$row[f_diagram_name]);
		}

		return json_encode($response);
	}
}
	
?>