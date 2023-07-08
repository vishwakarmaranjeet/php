<?php
	header('Access-Control-Allow-Origin: *'); 
	header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
	header('Content-Type: application/json');
    require_once('includes/config.php');
	if(isset($_GET['c_id'])){
		$c_id = $_REQUEST['c_id'];    
		  try{
		  $sql = "SELECT CompanyID, CompanyName, Email, Mobile FROM justclick_company_details_tbl WHERE CompanyID =:c_id";  
		  $stmt = $DB->prepare($sql);
		  $stmt->bindValue(":c_id", $c_id);  
		  $stmt->execute();
		  $result = $stmt->fetchAll();
		  if($result){
			 $data = array("status" => "success", "company"=>$result);    
			 echo json_encode($data); 
		  }
			}catch(Exception $ex) {
			  $data = array("status" => "error", "message"=> $ex->getMessage());
			  echo json_encode($data);
		}
	} else {
		$data = array("status" => "error", "message"=>"null");
	    echo json_encode($data); 
	}
?>