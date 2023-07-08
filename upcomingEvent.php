<?php
	header('Access-Control-Allow-Origin: *'); 
	header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
	header('Content-Type: application/json');
    require_once('includes/config.php');
	  try{
      $sql = "SELECT * FROM upcoming_event_tbl WHERE Status = '1' ORDER BY EventDate DESC";  
	  $stmt = $DB->prepare($sql);
      $stmt->execute();
      $result = $stmt->fetchAll();
	  if($result){
		 $data = array("status" => "success", "events"=>$result);
		 echo json_encode($data);
	  } else {
		 $data = array("status" => "error", "message"=>"No event details available");
		 echo json_encode($data);
	  }
    	}catch(Exception $ex) {
		  $data = array("status" => "error", "message"=> $ex->getMessage());
		  echo json_encode($data);
    }
?>