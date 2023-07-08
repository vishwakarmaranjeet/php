<?php
	header('Access-Control-Allow-Origin: *'); 
	header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
	header('Content-Type: application/json');
    require_once('includes/config.php');
	if(isset($_POST['keyword'])){
		$keyword = trim($_POST['keyword']);
		$sql="SELECT * FROM `category_tbl` WHERE CategoryName LIKE :keyword ORDER BY CategoryName";
		//$sql = "SELECT * FROM `category_tbl` WHERE CategoryName LIKE ? ORDER BY CategoryName";
		$stmt = $DB->prepare($sql);  
		$stmt->bindValue(':keyword','%'.$keyword.'%');
		//$keyword = $keyword . '%';
    	//$stmt->bindParam(1, $keyword, PDO::PARAM_STR, 100);
		$stmt->execute();
		$results = $stmt->fetchAll();
		if(!$results){
			$data = array("status" => "error", "message"=>"No Results Found");   
			echo json_encode($data);
		} else {
			$data = array("status" => "success", "category"=>$results);    
			echo json_encode($data);
		}
	}
	?>