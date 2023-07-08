<?php
	header('Access-Control-Allow-Origin: *'); 
	header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS'); 
	header('Content-Type: application/json');
	require_once('includes/config.php'); 
	require_once("vendor/class.phpmailer.php");
	if(isset($_POST['email'])){
		$email = trim($_POST['email']); 
		try{ 
			$sql = "SELECT CompanyName, Username, Password FROM company_details_tbl WHERE Username =:username LIMIT 0,1";
			$stmt = $DB->prepare($sql);
			$stmt->bindValue(":username", $email);   
			$stmt->execute();
			$result = $stmt->fetchAll();
			if($result){
				$sql = "SELECT Username, Password, CompanyName FROM company_details_tbl WHERE Username =:username LIMIT 0,1";
				$stmt = $DB->prepare($sql);
				$stmt->execute(array(":username"=> $email)); 
				$results = $stmt->fetchAll(); 
				if($results[0]['Username'] && $results[0]['Password']  == TRUE) {
					$password = $results[0]['Password'];
					$cname = $results[0]['CompanyName']; 
					$username = $results[0]['Username']; 
					$mail = new PHPMailer();
					$mail->IsSMTP();
					$mail->Host = "";
					$mail->SMTPAuth = true;
					$mail->Port = 587;
					$mail->Username = ""; 
					$mail->Password = ""; 
					$mail->AddAddress($email);  
					$mail->From = "";
					$mail->FromName = ""; 
					$message = '<html><body>';
					$message .= "<p> Dear, <strong> ".$cname." </strong> </p>";
					$message .= "<p> Your Username & Password are below</p>";
					$message .= "<p> <strong>Username</strong> : ".$username." </p>";
					$message .= "<p> <strong>Password</strong> : ".$password." </p>"; 
					$message .= "<p> Regards,</p>" ;
					$message .= "<p style='font-size:12px;'><strong>The Electric Merchants’ Association</strong></p>";
					$message .= "<p style='font-size:12px;'><strong>Tel. No:</strong> 022-22060625 / 22088141</p>";
					$message .= "<p style='font-size:12px;'><strong>Email:</strong> emamub@gmail.com </p>";
					$message .= "<p style='font-size:12px;'><strong>Website:</strong>
					<a href='http://www.xyz.com' target='_blank'>www.xyz.com </a> </p>";
					$message .= "</body></html>";			
					$mail->IsHTML(true);
					$mail->Subject = "Password Recovery from";  
					$mail->Body = $message;
					$mail->Send(); 
				if(!$mail->Send()){
					$data = array("status" => "error", "message"=>"Something went wrong try again later");
                    echo json_encode($data);
				} else {
					$data = array("status" => "success", "message" =>"Your password has been sent to you email address."); 
					echo json_encode($data);  
				}
			} else {
				 	$data = array("status" => "error", "message"=>"Your Username & password has not been 
				 	created, kindly contact to Ema.");
				 	echo json_encode($data);
			}
		} else {
					$data = array("status" => "error", "message"=>"Sorry, your email address not registered with us.");
               	    echo json_encode($data);
			}
	} catch(Exception $ex){
		echo $ex->getMessage(); 
	}
} else{
		$data = array("status" => "error", "message"=>"null");
		echo json_encode($data); 
}
?>