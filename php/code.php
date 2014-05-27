<?
	/**
	*  Code Generator 를 위한 페이지 
	*  HTML 페이지에 header 뷰어를 위한 알고리즘 
	*  HTML 페이지에 cpp 뷰어를 위한 알고리즘
	*  header 파일을 쓰기 위한 알고리즘
	*  cpp 파일을 쓰기 위한 알고리즘
	*  등이 들어 있다.
	**/
	require 'JSON.php';
	
	include("config.php");
	
	$db = new DataBase();
	$db->ConnectDB();
	
	/**
	*  해당 seq_id를 통한 diagram 정보를 받아온다.
	**/ 
	$seq_id = $_REQUEST['seqid'];
	$sql="SELECT f_diagram_info FROM t_diagram WHERE seq_id='$seq_id'";
	$result=mysql_query($sql);
	$data=mysql_fetch_array($result);
	$count=mysql_num_rows($result);
	
	/**
	*  sql문을 통한 diagram 정보(diagram_info)에서 해당 파일의 파싱을 위한 형태의 메모리 생성 및 입력
	**/
	if($count==1)
	{
		// Services_JSON 인스턴스 생성
		$json = new Services_JSON();
		$value = $json->decode($data[f_diagram_info]);
		
		// 다이어그램의 클래스 갯수
		$class_cnt = count($value->{'diagram'});
		for($i=0; $i<$class_cnt; $i++)
		{
			// 클래스 안 멤버 변수 갯수
			$properties_cnt = count($value->{'diagram'}[$i]->{'class_'}->{'variableData'}); 
			for($j=0; $j<$properties_cnt; $j++) {
				$properties[$j] = array($value->{'diagram'}[$i]->{'class_'}->{'variableData'}[$j]->{'access'}, $value->{'diagram'}[$i]->{'class_'}->{'variableData'}[$j]->{'data'}, $value->{'diagram'}[$i]->{'class_'}->{'variableData'}[$j]->{'name'});
			}

			// 클래스 안 멤버 함수 갯수
			$operations_cnt = count($value->{'diagram'}[$i]->{'class_'}->{'functionData'});
			for($j=0; $j<$operations_cnt; $j++) {
				$operations[$j] = array($value->{'diagram'}[$i]->{'class_'}->{'functionData'}[$j]->{'access'}, $value->{'diagram'}[$i]->{'class_'}->{'functionData'}[$j]->{'returns'}, $value->{'diagram'}[$i]->{'class_'}->{'functionData'}[$j]->{'name'}, $value->{'diagram'}[$i]->{'class_'}->{'functionData'}[$j]->{'param'});
			}

			// 관계도
			$relations_cnt = count($value->{'diagram'}[$i]->{'class_'}->{'relationship'}[1]);
			for($j=0; $j<$relations_cnt; $j++)
			{
				$relationship[$j] = array($value->{'diagram'}[$i]->{'class_'}->{'relationship'}[1][$j]->{'relation'}, $value->{'diagram'}[$i]->{'class_'}->{'relationship'}[1][$j]->{'classname'});
			}
			
			
			$class_name = $value->{'diagram'}[$i]->{'class_'}->{'classname'};
			$class[$i] = array($class_name, $properties, $operations, $relationship);
			array_splice($properties, 0);
			array_splice($operations, 0);
			array_splice($relationship, 0);
		}
		$diagram = $class;
	}	

	/**
	*  header 파일에 써질 code 부를 생성
	**/
	for($i=0; $i<count($diagram); $i++) 
	{
		// public, private, protected flag
		$public_flag = '0';
		$private_flag = '0';
		$protected_flag = '0';
		$inheritance_flag = 0;

		$header .= "<font color=\"blue\">" . "class " . "</font>";
		$header .= $diagram[$i][0];
		
		// inheritance relationship(상속관계 표현)
		for($j=0; $j<count($diagram[$i][3]); $j++)
		{
			if($diagram[$i][3][$j][0] == 'inheritance')
			{
				if($inheritance_flag == 0)
				{
					$header .= ' : ';
					$header .= $diagram[$i][3][$j][1];
					$inheritance_flag = 1;
				}
				else
				{
					$header .= ', ';
					$header .= $diagram[$i][3][$j][1];
				}
			}			
		}
			
		$header .= "\n{\n";
		
		// private member for relationship - association, aggregation, composition(각 관계에 따른 멤버 표현)
		for($j=0; $j<count($diagram[$i][3]); $j++)
		{
			if($diagram[$i][3][$j][0] == 'association' || $diagram[$i][3][$j][0] == 'aggregation' || $diagram[$i][3][$j][0] == 'composition')
			{
				if($private_flag == '0')
				{
					$header .= "<font color=\"blue\">" . "private:\n" . "</font>";
					$private_flag = '1';
				}
				$header .= "&nbsp;&nbsp;&nbsp;&nbsp;";
				$header .= "<font color=\"blue\">" . $diagram[$i][3][$j][1] . "</font>";
				$header .= " _";
				$header .= strtolower($diagram[$i][3][$j][1]);
				$header .= ";\n";
			}
		}
			
		// private member
		for($j=0; $j<count($diagram[$i][1]); $j++)
		{
			if($diagram[$i][1][$j][0] == 'private')
			{
				if($private_flag == '0')
				{
					$header .= "<font color=\"blue\">" . "private:\n" . "</font>";
					$private_flag = '1';
				}
				$header .= "&nbsp;&nbsp;&nbsp;&nbsp;";
				$header .= "<font color=\"blue\">" . $diagram[$i][1][$j][1] . "</font>";
				$header .= " ";
				$header .= $diagram[$i][1][$j][2];
				$header .= ";\n";
			}
		}

		// private operation
		for($j=0; $j<count($diagram[$i][2]); $j++)
		{
			if($diagram[$i][2][$j][0] == 'private')
			{
				if($private_flag == '0')
				{
					$header .= "<font color=\"blue\">" . "private:\n" . "</font>";
					$private_flag = '1';
				}
				$header .= "&nbsp;&nbsp;&nbsp;&nbsp;";
				$header .= "<font color=\"blue\">" . $diagram[$i][2][$j][1] . "</font>";
				$header .= " ";
				$header .= $diagram[$i][2][$j][2];
				$header .= "(";
				$header .= $diagram[$i][2][$j][3];
				$header .= ");\n";
			}
		}
			
		// protected member
		for($j=0; $j<count($diagram[$i][1]); $j++)
		{
			if($diagram[$i][1][$j][0] == 'protected')
			{
				if($protected_flag == '0')
				{
					$header .= "<font color=\"blue\">" . "protected:\n" . "</font>";
					$protected_flag = '1';
				}
				$header .= "&nbsp;&nbsp;&nbsp;&nbsp;";
				$header .= "<font color=\"blue\">" . $diagram[$i][1][$j][1] . "</font>";
				$header .= " ";
				$header .= $diagram[$i][1][$j][2];
				$header .= ";\n";
			}
		}

		// protected operation
		for($j=0; $j<count($diagram[$i][2]); $j++)
		{
			if($diagram[$i][2][$j][0] == 'protected')
			{
				if($protected_flag == '0')
				{
					$header .= "<font color=\"blue\">" . "protected:\n" . "</font>";
					$protected_flag = '1';
				}
				$header .= "&nbsp;&nbsp;&nbsp;&nbsp;";
				$header .= "<font color=\"blue\">" . $diagram[$i][2][$j][1] . "</font>";
				$header .= " ";
				$header .= $diagram[$i][2][$j][2];
				$header .= "(";
				$header .= $diagram[$i][2][$j][3];
				$header .= ");\n";
			}
		}

		// public member(변수)
		for($j=0; $j<count($diagram[$i][1]); $j++)
		{
			if($diagram[$i][1][$j][0] == 'public')
			{
				if($public_flag == '0')
				{
					$header .= "<font color=\"blue\">" . "public:\n" . "</font>";
					$public_flag = '1';
				}
				$header .= "&nbsp;&nbsp;&nbsp;&nbsp;";
				$header .= "<font color=\"blue\">" . $diagram[$i][1][$j][1] . "</font>";
				$header .= " ";
				$header .= $diagram[$i][1][$j][2];
				$header .= ";\n";
			}
		}


		// public generation(생성자)
		if($public_flag == '0')
		{
			$header .= "<font color=\"blue\">" . "public:\n" . "</font>";
			$public_flag = '1';
		}
		$header .= "&nbsp;&nbsp;&nbsp;&nbsp;";
		$header .= $diagram[$i][0];
		$header .= "();\n";
			
			
		// public generation overode(Aggregation 관계를 위함..)
		for($j=0; $j<count($diagram[$i][3]); $j++)
		{
			if($diagram[$i][3][$j][0] == 'aggregation')
			{
				$header .= "&nbsp;&nbsp;&nbsp;&nbsp;";
				$header .= $diagram[$i][0];
				$header .= "(";
				$header .= $diagram[$i][3][$j][1];
				$header .= " _";
				$header .= strtolower($diagram[$i][3][$j][1]);
				$header .=");\n";
			}
		}
			
		// public operation(함수)
		for($j=0; $j<count($diagram[$i][2]); $j++)
		{
			if($diagram[$i][2][$j][0] == 'public')
			{
				$header .= "&nbsp;&nbsp;&nbsp;&nbsp;";
				$header .= "<font color=\"blue\">" . $diagram[$i][2][$j][1] . "</font>";
				$header .= " ";
				$header .= $diagram[$i][2][$j][2];
				$header .= "(";
				$header .= $diagram[$i][2][$j][3];
				$header .= ");\n";
			}
		}

		$header .= "};\n\n";
	}

	
	$header = nl2br($header);

		
	/**
	*  Open diagram 페이지의 header 쪽 뷰어에 써질 code 부 생성
	*  기존 header 파일에 써질 부에서 색등의 조합의 html 코드가 추가되었다.
	**/
	for($i=0; $i<count($diagram); $i++) 
	{
		// public, private, protected flag
		$public_flag = '0';
		$private_flag = '0';
		$protected_flag = '0';
		$inheritance_flag = 0;

		$_header .= 'class ';
		$_header .= $diagram[$i][0];
		
		// inheritance relationship
		for($j=0; $j<count($diagram[$i][3]); $j++)
		{
			if($diagram[$i][3][$j][0] == 'inheritance')
			{
				if($inheritance_flag == 0)
				{
					$_header .= ' : ';
					$_header .= $diagram[$i][3][$j][1];
					$inheritance_flag = 1;
				}
				else
				{
					$_header .= ', ';
					$_header .= $diagram[$i][3][$j][1];
				}
			}			
		}
		
		$_header .= "\n{\n";
		
		// private member for relationship - association, aggregation, composition
		for($j=0; $j<count($diagram[$i][3]); $j++)
		{
			if($diagram[$i][3][$j][0] == 'association' || $diagram[$i][3][$j][0] == 'aggregation' || $diagram[$i][3][$j][0] == 'composition')
			{
				if($private_flag == '0')
				{
					$_header .= "private:\n";
					$private_flag = '1';
				}
				$_header .= "\t";
				$_header .= $diagram[$i][3][$j][1];
				$_header .= " _";
				$_header .= strtolower($diagram[$i][3][$j][1]);
				$_header .= ";\n";
			}
		}
		
		// private member
		for($j=0; $j<count($diagram[$i][1]); $j++)
		{
			if($diagram[$i][1][$j][0] == 'private')
			{
				if($private_flag == '0')
				{
					$_header .= "private:\n";
					$private_flag = '1';
				}
				$_header .= "\t";
				$_header .= $diagram[$i][1][$j][1];
				$_header .= " ";
				$_header .= $diagram[$i][1][$j][2];
				$_header .= ";\n";
			}
		}

		// private operation
		for($j=0; $j<count($diagram[$i][2]); $j++)
		{
			if($diagram[$i][2][$j][0] == 'private')
			{
				if($private_flag == '0')
				{
					$_header .= "private:\n";
					$private_flag = '1';
				}
				$_header .= "\t";
				$_header .= $diagram[$i][2][$j][1];
				$_header .= " ";
				$_header .= $diagram[$i][2][$j][2];
				$_header .= "(";
				$_header .= $diagram[$i][2][$j][3];
				$_header .= ");\n";
			}
		}
		
		// protected member
		for($j=0; $j<count($diagram[$i][1]); $j++)
		{
			if($diagram[$i][1][$j][0] == 'protected')
			{
				if($protected_flag == '0')
				{
					$_header .= "protected:\n";
					$protected_flag = '1';
				}
				$_header .= "\t";
				$_header .= $diagram[$i][1][$j][1];
				$_header .= " ";
				$_header .= $diagram[$i][1][$j][2];
				$_header .= ";\n";
			}
		}

		// protected operation
		for($j=0; $j<count($diagram[$i][2]); $j++)
		{
			if($diagram[$i][2][$j][0] == 'protected')
			{
				if($protected_flag == '0')
				{
					$header .= "protected:\n";
					$protected_flag = '1';
				}
				$_header .= "\t";
				$_header .= $diagram[$i][2][$j][1];
				$_header .= " ";
				$_header .= $diagram[$i][2][$j][2];
				$_header .= "(";
				$_header .= $diagram[$i][2][$j][3];
				$_header .= ");\n";
			}
		}

		// public member(변수)
		for($j=0; $j<count($diagram[$i][1]); $j++)
		{
			if($diagram[$i][1][$j][0] == 'public')
			{
				if($public_flag == '0')
				{
					$_header .= "public:\n";
					$public_flag = '1';
				}
				$_header .= "\t";
				$_header .= $diagram[$i][1][$j][1];
				$_header .= " ";
				$_header .= $diagram[$i][1][$j][2];
				$_header .= ";\n";
			}
		}


		// public generation(생성자)
		if($public_flag == '0')
		{
			$_header .= "public:\n";
			$public_flag = '1';
		}
		$_header .= "\t";
		$_header .= $diagram[$i][0];
		$_header .= "();\n";
		
		
		// public generation overode(Aggregation 관계를 위함..)
		for($j=0; $j<count($diagram[$i][3]); $j++)
		{
			if($diagram[$i][3][$j][0] == 'aggregation')
			{
				$_header .= "\t";
				$_header .= $diagram[$i][0];
				$_header .= "(";
				$_header .= $diagram[$i][3][$j][1];
				$_header .= " _";
				$_header .= strtolower($diagram[$i][3][$j][1]);
				$_header .=");\n";
			}
		}
		
				

		// public operation(함수)
		for($j=0; $j<count($diagram[$i][2]); $j++)
		{
			if($diagram[$i][2][$j][0] == 'public')
			{
				$_header .= "\t";
				$_header .= $diagram[$i][2][$j][1];
				$_header .= " ";
				$_header .= $diagram[$i][2][$j][2];
				$_header .= "(";
				$_header .= $diagram[$i][2][$j][3];
				$_header .= ");\n";
			}
		}		
		
		$private_flag = '0';
		$_header .= "};\n\n";
	}
	


	/**
	*  Open diagram 페이지의 cpp 쪽 뷰어에 써질 code 부 생성
	*  기존 cpp 파일에 써질 부에서 색등의 조합의 html 코드가 추가되었다.
	**/
	for($i=0; $i<count($diagram); $i++) 
	{
		$cpp .= "/***** ";
		$cpp .= $diagram[$i][0];
		$cpp .= " class *****/\n";

		$cpp .= $diagram[$i][0];
		$cpp .= "::";
		$cpp .= $diagram[$i][0];
		$cpp .= "()\n";
		$cpp .= "{\n";
		for($j=0; $j<count($diagram[$i][3]); $j++)
		{
			// composition 관계 시 추가
			if($diagram[$i][3][$j][0] == 'composition')
			{
				$cpp .= "&nbsp;&nbsp;&nbsp;&nbsp;_";
				$cpp .= strtolower($diagram[$i][3][$j][1]);
				$cpp .= " = new ";
				$cpp .= $diagram[$i][3][$j][1];
				$cpp .= "();\n";
			}
		}
		$cpp .= "}\n";
		$cpp .= "\n";		

		// public generation overode(Aggregation 관계를 위함..)
		for($j=0; $j<count($diagram[$i][3]); $j++)
		{
			if($diagram[$i][3][$j][0] == 'aggregation')
			{
				$cpp .= $diagram[$i][0];
				$cpp .= "::";
				$cpp .= $diagram[$i][0];
				$cpp .= "(";
				$cpp .= "<font color=\"blue\">" . $diagram[$i][3][$j][1] . "</font>";
				$cpp .= " _";
				$cpp .= strtolower($diagram[$i][3][$j][1]);
				$cpp .= ")\n";
				$cpp .= "{\n";
				$cpp .= "&nbsp;&nbsp;&nbsp;&nbsp;";
				$cpp .= "this._";
				$cpp .= strtolower($diagram[$i][3][$j][1]);
				$cpp .= " = _";
				$cpp .= strtolower($diagram[$i][3][$j][1]);
				$cpp .= ";\n";
				$cpp .= "}\n";
				$cpp .= "\n";
			}
		}
		
		for($j=0; $j<count($diagram[$i][2]); $j++)
		{
			$cpp .= "<font color=\"blue\">" . $diagram[$i][2][$j][1] . "</font>";
			$cpp .= " ";
			$cpp .= $diagram[$i][0];
			$cpp .= "::";
			$cpp .= $diagram[$i][2][$j][2];
			$cpp .= "(";
			$cpp .= $diagram[$i][2][$j][3];
			$cpp .= ")\n";
			$cpp .= "{\n}\n";
		}		

		$cpp .= "\n\n";
	}
	
	$cpp = nl2br($cpp);


	
	/**
	*  cpp 파일에 써질 code 부를 생성
	**/
	for($i=0; $i<count($diagram); $i++) 
	{
		$_cpp .= "/***** ";
		$_cpp .= $diagram[$i][0];
		$_cpp .= " class *****/\n";

		$_cpp .= $diagram[$i][0];
		$_cpp .= "::";
		$_cpp .= $diagram[$i][0];
		$_cpp .= "()\n";
		$_cpp .= "{\n";
		for($j=0; $j<count($diagram[$i][3]); $j++)
		{
			// composition 관계 시 추가
			if($diagram[$i][3][$j][0] == 'composition')
			{
				$_cpp .= "\t_";
				$_cpp .= strtolower($diagram[$i][3][$j][1]);
				$_cpp .= " = new ";
				$_cpp .= $diagram[$i][3][$j][1];
				$_cpp .= "();\n";
			}
		}
		$_cpp .= "}\n";
		$_cpp .= "\n";		

		// public generation overode(Aggregation 관계를 위함..)
		for($j=0; $j<count($diagram[$i][3]); $j++)
		{
			if($diagram[$i][3][$j][0] == 'aggregation')
			{
				$_cpp .= $diagram[$i][0];
				$_cpp .= "::";
				$_cpp .= $diagram[$i][0];
				$_cpp .= "(";
				$_cpp .= $diagram[$i][3][$j][1];
				$_cpp .= " _";
				$_cpp .= strtolower($diagram[$i][3][$j][1]);
				$_cpp .= ")\n";
				$_cpp .= "{\n";
				$_cpp .= "\t";
				$_cpp .= "this._";
				$_cpp .= strtolower($diagram[$i][3][$j][1]);
				$_cpp .= " = _";
				$_cpp .= strtolower($diagram[$i][3][$j][1]);
				$_cpp .= ";\n";
				$_cpp .= "}\n";
				$_cpp .= "\n";
			}
		}
		
		for($j=0; $j<count($diagram[$i][2]); $j++)
		{
			$_cpp .= $diagram[$i][2][$j][1];
			$_cpp .= " ";
			$_cpp .= $diagram[$i][0];
			$_cpp .= "::";
			$_cpp .= $diagram[$i][2][$j][2];
			$_cpp .= "(";
			$_cpp .= $diagram[$i][2][$j][3];
			$_cpp .= ")\n";
			$_cpp .= "{\n}\n";
		}		

		$_cpp .= "\n\n";	
	}

	
	/**
	*  code 폴더에 해당 cpp, header 파일의 생성을 위한 부분
	*  diagram_name을 얻어오기 위한 sql 부
	*  서버측의 폴더 생성 및 header, cpp 파일 생성을 담당하고 있다.
	**/
	$sql="SELECT f_diagram_name FROM t_diagram WHERE seq_id='$seq_id'";
	$result=mysql_query($sql);
	$data=mysql_fetch_array($result);
	
	$dir = "code";
	if(!file_exists($dir))		// 'code' 폴더가 존재 하지 않으면.. 폴더 생성
	{
		mkdir($dir);
		chmod($dir, 0777);			
	}
	
	// 'code' 폴더 안에 seq_id 폴더 생성 및 권한 부여
	$dir = $dir . "/" . $seq_id;
	mkdir($dir);
	chmod($dir, 0777);
	chdir($dir);
	
	$fp_header = fopen($data[f_diagram_name] . ".h", "w+");
	$fp_cpp = fopen($data[f_diagram_name] . ".cpp", "w+");
	
	fwrite($fp_header, $_header);
	fwrite($fp_cpp, $_cpp);
	
	fclose($fp_header);
	fclose($fp_cpp);

?>