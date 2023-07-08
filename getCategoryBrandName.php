<?php
	header('Access-Control-Allow-Origin: *'); 
	header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
	header('Content-Type: application/json');
    require_once('includes/config.php');
	if(isset($_GET['category']) || $_GET['brand']){
		$categoryID = $_REQUEST['category']; 
		$brandID = $_REQUEST['brand'];    
	  try{
		  $sql = "SELECT CBT.CategoryID, CBT.BrandID, CT.CategoryName, BT.BrandName FROM category_brand_tbl AS CBT
		  INNER JOIN category_tbl AS CT ON CBT.CategoryID = CT.CategoryID
		  INNER JOIN brand_tbl AS BT on CBT.BrandID = BT.BrandID
		  WHERE CBT.CategoryID =:category_id AND CBT.BrandID =:brand_id LIMIT 1";
		  $stmt = $DB->prepare($sql);
		  $stmt->bindValue(":category_id", $categoryID);
		  $stmt->bindValue(":brand_id", $brandID);
		  $stmt->execute();
		  $result = $stmt->fetchAll();
		  if($result){
			 $data = array("status" => "success", "cbname"=>$result);     
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