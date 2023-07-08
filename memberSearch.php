<?php
header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS'); 
header('Content-Type: application/json');
require_once('includes/config.php');
if(isset($_GET['keyword'])){
	if($_GET['keyword'] != NULL){
		$query = $_GET['keyword'];
		//$sql = "SELECT * FROM members WHERE CONCAT(First_Name, ' ', Last_Name) LIKE :query OR
		 //Company_name LIKE :query OR Proprietor LIKE :query OR Mobile LIKE :query OR 
		 //Contact_no LIKE :query OR Office_no LIKE :query"; 
		 $sql = "SELECT * FROM company_details_tbl WHERE CompanyName LIKE :query OR
		  City LIKE :query OR State LIKE :query OR PinNo LIKE :query OR 
		  CompanyType LIKE :query OR TelNo LIKE :query OR TelNo2 LIKE :query OR TelNo3 LIKE :query LIMIT 1";  
		try{
			$stmt = $DB->prepare($sql);
			//$query = "%".$query."%"; 
			//$query = '%'.$query.'%';
			$query = $query.'%';
			$stmt->bindValue(":query", $query);
			$stmt->execute();
			$users = $stmt->fetchAll();
			if($users){
				$results = array("status" => "success", "members" =>$users);
				echo json_encode($results); 
				$DB = null;
			} else{
				$data = array("status" => "error", "message" =>"No records found");
				echo json_encode($data); 
			}
		} catch(PDOException $e){
			$data = array("status" => "error", "message" =>$e->getMessage());
			echo json_encode($data); 
		}
	} else {
		$data = array("status"=>"error", "message"=>"Failed");
		echo json_encode($data);
	}
} else {
	$data = array("status"=>"error", "message"=>"null");
	echo json_encode($data);
}
?>