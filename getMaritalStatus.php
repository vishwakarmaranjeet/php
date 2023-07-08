<?php
	header('Access-Control-Allow-Origin: *'); 
	header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
	header('Content-Type: application/json');
    require_once('includes/config.php');
	 try{
		  $sql = "SELECT * FROM marital_status_tbl WHERE Status = '1' ORDER BY MaritalStatus ASC";  
		  $stmt = $DB->prepare($sql);
		  $stmt->bindValue(":cid", $cid);
		  $stmt->execute();
		  $result = $stmt->fetchAll();
			 $data = array("status" => "success", "maritalstatus"=>$result);   
			 echo json_encode($data); 
			}catch(Exception $ex) {
			  $data = array("status" => "error", "message"=> $ex->getMessage()); 
			  echo json_encode($data);
		}

?>