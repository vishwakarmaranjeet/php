<?php
	header('Access-Control-Allow-Origin: *'); 
	header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
	header('Content-Type: application/json');
    require_once('includes/config.php');
	if(isset($_GET['pid'])){ 
		$pid = intval($_GET['pid']);    
		  try{
		  $sql = "SELECT * FROM personnel_information_tbl WHERE PersonnelID =:pid AND Status = '1'";  
		  $stmt = $DB->prepare($sql);
		  $stmt->bindValue(":pid", $pid);  
		  $stmt->execute();
		  $result = $stmt->fetchAll();
			 $data = array("status" => "success", "details"=>$result);   
			 echo json_encode($data); 
			}catch(Exception $ex){ 
			  $data = array("status" => "error", "message"=> $ex->getMessage());
			  echo json_encode($data);
		}
	} else {
		$data = array("status" => "error", "message"=>"null");
	    echo json_encode($data);
	}
?>