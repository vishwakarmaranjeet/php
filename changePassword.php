<?php
header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Content-Type: application/json');
require_once('includes/config.php');
if(isset($_POST['newpassword']) || isset($_POST['confirmpassword'])){
  $password = trim($_POST['confirmpassword']);
  $cid = trim($_POST['cid']);
  $error = FALSE;
  if(!$error) {
    $sql = "UPDATE `company_details_tbl` SET `Password` = :password "." WHERE CompanyID =:cid"; 
    try {
      $stmt = $DB->prepare($sql);
      $stmt->bindValue(":password", $password);
  	  $stmt->bindValue(":cid", $cid);  
      $stmt->execute();
      $result = $stmt->rowCount();
      if($result > 0){
		  $data = array("status" => "success", "message"=>"Your Password has been changed successfully");
		  echo json_encode($data);
      	}else{ 
		   $data = array("status" => "password", "message"=>"Your password is same as previous");
		   echo json_encode($data);
      	}
    	}catch(Exception $ex) { 
		  $data = array("status" => "error", "message"=> $ex->getMessage());
		  echo json_encode($data);
    }
  } 
} else {
	 $data = array("status" => 0, "message"=> "Null");
	 echo json_encode($data);
}
?>