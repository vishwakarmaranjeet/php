<?php
	header('Access-Control-Allow-Origin: *'); 
	header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
	header('Content-Type: application/json');
    require_once('includes/config.php');
	if(isset($_GET['category_id'])){
		$category_id = $_REQUEST['category_id']; 
		 try{
			  $sql = "SELECT * FROM app_category_banner_tbl WHERE CategoryID =:cat_id AND Status = '1' ORDER BY SortOrder ASC";
			  $stmt = $DB->prepare($sql);
			  $stmt->bindValue(":cat_id", $category_id);
			  $stmt->execute();
			  $result = $stmt->fetchAll();
			  if($result){
				$data = array("status" => "success", "banners"=>$result);    
				echo json_encode($data); 
			  } else {
				    $data = array("status" => "noimage", "message"=>"No image found");    
					echo json_encode($data); 
				}
				}catch(Exception $ex) {
				 $data = array("status" => "error", "message"=> $ex->getMessage());  
			   	 echo json_encode($data);
		  }
	}
?>