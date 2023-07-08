<?php
header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Content-Type: application/json');
require_once('includes/config.php');
if(isset($_POST['email']) || isset($_POST['officeno']) || isset($_POST['description']) 
|| isset($_POST['cinno']) || isset($_POST['address'])){
  $description = trim($_POST['description']); // description 
  $address = trim($_POST['address']); // address
  $city = trim($_POST['city']); // city
  $establishment = trim($_POST['establishment']); //establishment
  $establishmentyear = date('Y-m-d', strtotime($establishment)); //establishment
  $enrollment = trim($_POST['enrollment']); //enrollment
  $enrollmentdate = date('Y-m-d', strtotime($enrollment)); //establishment
  $pinno = trim($_POST['pinno']); // pinno
  $email = trim($_POST['email']); // email 
  $email2 = trim($_POST['email2']); // email2
  $mobileno = trim($_POST['mobileno']); // mobileno
  $officeno = trim($_POST['officeno']); // officeno
  $officeno2 = trim($_POST['officeno2']); // officeno2
  $officeno3 = trim($_POST['officeno3']); // officeno3
  $residenceno = trim($_POST['residenceno']); // residenceno
  $faxno = trim($_POST['faxno']); // faxno
  $intercom = trim($_POST['intercom']); // intercom
  $website = trim($_POST['website']); // website
  $cinno = trim($_POST['cinno']); // cinno
  $panno = trim($_POST['panno']); // panno
  $tinno = trim($_POST['tinno']); // tinno
  $cstno = trim($_POST['cstno']); // cstno 
  $exciseno = trim($_POST['exciseno']); // exciseno
  $exportimportno = trim($_POST['exportimportno']); // export import no
  $lbtno = trim($_POST['lbtno']); // lbt no
  $gstno = trim($_POST['gstno']); // gst no
  $updatedon = date('Y-m-d H:i:s'); // updated date
  $cid = trim($_POST['cid']);
  $error = FALSE;
  if(!$error) {
   $sql = "UPDATE `company_details_tbl` SET
			`BusinessDescription` = :description,
			`EstablishmentYear` = :establishment,
			`EnrollmentDate` = :enrollment,
			`Address` = :address,
			`Email` = :email,
			`Email2` = :email2,
			`City` = :city,
			`PinNo` = :pinno,
			`TelNo` = :officeno, 
			`TelNo2` = :officeno2,
			`TelNo3` = :officeno3,  
			`MobileNo` = :mobileno,     
			`ResidenceNo` = :residenceno, 
			`FaxNo` = :faxno, 
			`Intercom` = :intercom,
			`Website` = :website,
			`PanNo` = :panno,
			`CinNo` = :cinno,
			`TinNo` = :tinno,
			`CstNo` = :cstno,
			`ExciseNo` = :exciseno,
			`ExportImportNo` = :exportimportno,
			`LbtNo` = :lbtno,
			`GstNo` = :gstno,
			`UpdatedOn` = :updatedon" . " WHERE CompanyID = :cid";

    try {
			$stmt = $DB->prepare($sql);
			$stmt->bindValue(":description", $description);
			$stmt->bindValue(":establishment", $establishmentyear);
			$stmt->bindValue(":enrollment", $enrollmentdate);
			$stmt->bindValue(":address", $address);
			$stmt->bindValue(":city", $city);
			$stmt->bindValue(":pinno", $pinno);
			$stmt->bindValue(":email", $email);
			$stmt->bindValue(":email2", $email2);
			$stmt->bindValue(":officeno", $officeno);
			$stmt->bindValue(":officeno2", $officeno2);
			$stmt->bindValue(":officeno3", $officeno3); 
			$stmt->bindValue(":mobileno", $mobileno); 
			$stmt->bindValue(":residenceno", $residenceno);
			$stmt->bindValue(":faxno", $faxno);
			$stmt->bindValue(":intercom", $intercom);
			$stmt->bindValue(":website", $website);
			$stmt->bindValue(":panno", $panno);
			$stmt->bindValue(":cinno", $cinno);
			$stmt->bindValue(":tinno", $tinno);
			$stmt->bindValue(":cstno", $cstno);
			$stmt->bindValue(":exciseno", $exciseno);
			$stmt->bindValue(":exportimportno", $exportimportno);
			$stmt->bindValue(":lbtno", $lbtno);
			$stmt->bindValue(":gstno", $gstno);
			$stmt->bindValue(":updatedon", $updatedon);
			$stmt->bindValue(":cid", $cid);  
		    $stmt->execute();
		    $result = $stmt->rowCount();  
      if($result > 0){
		  $data = array("status" => "success", "message"=>"Your records has been updated successfully");
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