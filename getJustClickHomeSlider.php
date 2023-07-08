<?php
	header('Access-Control-Allow-Origin: *'); 
	header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
	header('Content-Type: application/json');
    require_once('includes/config.php');
	 try{
		  $sql = "SELECT Image, SortOrder, Url, Status FROM app_homepage_advt_slider_tbl WHERE Status = '1' AND AppPagesID = '2' 
		  ORDER BY SortOrder ASC";
		  $stmt = $DB->prepare($sql);
		  $stmt->execute();
		  $result = $stmt->fetchAll();
		  if($result){
			$data = array("status" => "success", "banners"=>$result);    
			echo json_encode($data); 
		  }
			}catch(Exception $ex) {
			  $data = array("status" => "error", "message"=> $ex->getMessage());  
		   echo json_encode($data);
      }
?>