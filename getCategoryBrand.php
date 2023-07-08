<?php
	header('Access-Control-Allow-Origin: *'); 
	header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
	header('Content-Type: application/json');
    require_once('includes/config.php');
	if(isset($_GET['category_id'])){    
		  try{
		  $category_id = $_REQUEST['category_id'];
		  $sql = "SELECT BT.BrandID, BT.BrandName, CBT.CategoryID FROM brand_tbl AS BT
		  INNER JOIN category_brand_tbl AS CBT ON BT.BrandID = CBT.BrandID WHERE CBT.CategoryID =:category_id 
		  ORDER BY BrandName ASC"; 
		  $stmt = $DB->prepare($sql);
		  $stmt->bindValue(":category_id", $category_id);  
		  $stmt->execute();
		  $result = $stmt->fetchAll();
		  if($result){
			 $data = array("status" => "success", "brand"=>$result);    
			 echo json_encode($data);
		  } else {
			  $data = array("status" => "success", "brand"=> "0");
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