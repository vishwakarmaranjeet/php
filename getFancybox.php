<?php
	header('Access-Control-Allow-Origin: *'); 
	header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
	header('Content-Type: application/json');
    require_once('includes/config.php');
	if(isset($_GET['fancybox'])){ 
		 try{ 
		  $sql = "SELECT FancyboxID,Image,ShowonApp,Status FROM fancybox WHERE Status='1' AND ShowonApp = '1'";   
		  $stmt = $DB->prepare($sql); 
		  //$stmt->bindValue(':image', $show); 
		  $stmt->execute();
		  $result = $stmt->fetchAll();
		  if($result){
			  $data = array("status" => "success", "fancybox"=>$result);   
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