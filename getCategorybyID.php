<?php
	header('Access-Control-Allow-Origin: *'); 
	header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
	header('Content-Type: application/json');
    require_once('includes/config.php');
	if(isset($_GET['category_id'])){
		$cat_id = $_REQUEST['category_id'];    
		  try{
		  $sql = "SELECT * FROM category_tbl WHERE CategoryID =:cat_id AND Status = '1' ORDER BY CategoryName ASC";  
		  $stmt = $DB->prepare($sql);
		  $stmt->bindValue(":cat_id", $cat_id); 
		  $stmt->execute();
		  $result = $stmt->fetchAll();
		  if($result){
			 $data = array("status" => "success", "category"=>$result);    
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