<?php
	header('Access-Control-Allow-Origin: *'); 
	header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
	header('Content-Type: application/json');
    require_once('includes/config.php');
	if(isset($_GET['cid'])){ 
		$cid = intval($_GET['cid']);    
		  try{
		  $sql = "SELECT PersonName FROM personnel_information_tbl WHERE CompanyID =:cid AND Status = '1' LIMIT 0,1";  
		  $stmt = $DB->prepare($sql);
		  $stmt->bindValue(":cid", $cid); 
		  $stmt->execute();
		  $result = $stmt->fetchAll();
		   if($result){
			 $data = array("status" => "success", "persondetails"=>$result);   
			 echo json_encode($data); 
		   }
			}catch(Exception $ex){ 
			  $data = array("status" => "error", "message"=> $ex->getMessage());
			  echo json_encode($data);
		}
	} else {
		$data = array("status" => "error", "message"=>"null");
	    echo json_encode($data);
	}
?>