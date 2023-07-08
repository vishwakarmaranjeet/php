<?php
header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Content-Type: application/json');
require_once('includes/config.php');
if(isset($_GET['defaulterList'])){
		$sql = "SELECT * FROM defaulter_tbl WHERE Status = '1' ORDER BY CompanyName ASC";  
		try{ 
			$stmt = $DB->prepare($sql);
			$stmt->execute();
			$users = $stmt->fetchAll();
			if($users){
				$results = array("status" => "success", "defaulter" =>$users);
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
?>