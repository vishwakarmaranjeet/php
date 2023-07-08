<?php
header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Content-Type: application/json');
require_once('includes/config.php');
if(isset($_POST['personname']) || isset($_POST['designation']) || isset($_POST['dob']) 
|| isset($_POST['gender']) || isset($_POST['maritalstatus'])){
  $personname = trim($_POST['personname']); // personname
  $bloodgroup = trim($_POST['bloodgroup']); // bloodgroup
  $dob = trim($_POST['dob']); // dob
  $dateofbirth = date('Y-m-d', strtotime($dob)); // dob
  $gender = trim($_POST['gender']); // gender
  $caste = trim($_POST['caste']); // caste
  $maritalstatus = trim($_POST['maritalstatus']); // marital status
  $email = trim($_POST['email']); // email
  $mobileno = trim($_POST['mobileno']); // mobile no
  $residenceno = trim($_POST['residenceno']); // residence no
  $panno = trim($_POST['panno']); // panno
  $aadharno = trim($_POST['aadharno']); // aadharno
  $updatedon = date('Y-m-d H:i:s'); // updated date 
  $pid = trim($_POST['pid']);
  $error = FALSE;
  if(!$error) {
   $sql = "UPDATE `personnel_information_tbl` SET
	        `PersonName` = :personname,
			`DOB` = :dob,
			`BloodGroup` = :bloodgroup,
			`Gender` = :gender,
			`Caste` = :caste,
			`MaritalStatus` = :maritalstatus,
			`Email` = :email, 
			`MobileNo` = :mobileno,
			`ResidenceNo` = :residenceno, 
			`PanNO` = :panno, 
			`AadharNo` = :aadharno,
			`UpdatedOn` = :updatedon" . " WHERE PersonnelID = :pid";

    try {
			$stmt = $DB->prepare($sql);
			$stmt->bindValue(":personname", $personname);
			$stmt->bindValue(":dob", $dateofbirth);
			$stmt->bindValue(":bloodgroup", $bloodgroup);
			$stmt->bindValue(":gender", $gender);
			$stmt->bindValue(":caste", $caste);
			$stmt->bindValue(":maritalstatus", $maritalstatus);
			$stmt->bindValue(":email", $email);
			$stmt->bindValue(":mobileno", $mobileno);
			$stmt->bindValue(":residenceno", $residenceno);
			$stmt->bindValue(":panno", $panno);
			$stmt->bindValue(":aadharno", $aadharno);
			$stmt->bindValue(":updatedon", $updatedon);
			$stmt->bindValue(":pid", $pid);   
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
	 $data = array("status" => "error", "message"=> "Null");
	 echo json_encode($data);
}
?>