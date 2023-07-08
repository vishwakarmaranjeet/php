<?php
header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Content-Type: application/json');
require_once('includes/config.php');
if(isset($_POST['personname']) || isset($_POST['designation']) || isset($_POST['dob']) 
|| isset($_POST['gender']) || isset($_POST['maritalstatus'])){ 
  $cid = trim($_POST['cid']); // company name
  $personname = trim($_POST['personname']); // person name
  $designation = trim($_POST['designation']); // designation
  $dob = trim($_POST['dob']); // dob
  $persondob = date('Y-m-d', strtotime($dob)); //dob
  $gender = trim($_POST['gender']); // gender
  $caste = trim($_POST['caste']); // caste
  $maritalstatus = trim($_POST['maritalstatus']); // marital status
  $email = trim($_POST['email']); // email
  $mobileno = trim($_POST['mobileno']); // mobile no
  $panno = trim($_POST['panno']); // pan no
  $aadharno = trim($_POST['aadharno']); // aadhar no
  $createdon = date('Y-m-d H:i:s'); // created date
  $updatedon = date('Y-m-d H:i:s'); // updated date
  $status = 1; // status 
  $error = FALSE;
   if(!$error) {
	$check = "SELECT CompanyID, PersonName FROM personnel_information_tbl WHERE CompanyID =:cid AND PersonName =:personname";
	$stmt = $DB->prepare($check);
	$stmt->bindValue(":cid", $cid);
	$stmt->bindValue(":personname", $personname);  
	$stmt->execute();
	$result = $stmt->rowCount();
	if($result > 0){
		  $data = array("status" => "exits", "message"=>"This records alredy exits");
		  echo json_encode($data);
	}
  else{
 $sql = "INSERT INTO `personnel_information_tbl`(`CompanyID`, `PersonName`, `Designation`, `DOB`, `Gender`, `Caste`, `MaritalStatus`, `Email`, `MobileNo`, `PanNo`, `AadharNo`, `CreatedOn`, `UpdatedOn`, `Status`)
	
	   VALUES "."(:cname, :personname, :designation, :dob, :gender, :caste, :maritalstatus, 
	   :email, :mobileno, :panno, :aadharno, :createdon, :updatedon, :status)";
    try {
		  $stmt = $DB->prepare($sql);
		  $stmt->bindValue(":cname", $cid);
		  $stmt->bindValue(":personname", $personname); 
		  $stmt->bindValue(":designation", $designation); 
		  $stmt->bindValue(":dob", $persondob);
		  $stmt->bindValue(":gender", $gender);
		  $stmt->bindValue(":caste", $caste);
		  $stmt->bindValue(":maritalstatus", $maritalstatus);
		  $stmt->bindValue(":email", $email);
		  $stmt->bindValue(":mobileno", $mobileno);
		  $stmt->bindValue(":panno", $panno);
		  $stmt->bindValue(":aadharno", $aadharno);
		  $stmt->bindValue(":createdon", $createdon);
		  $stmt->bindValue(":updatedon", $updatedon);
		  $stmt->bindValue(":status", $status);   
		  $stmt->execute();
		  $result = $stmt->rowCount();
      if($result > 0){
		  $data = array("status" => "success", "message"=>"Personnel information updated successfully");
		  echo json_encode($data);
      	}else{ 
		   $data = array("status" => "error", "message"=>"No changes made to data"); 
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
}
?>