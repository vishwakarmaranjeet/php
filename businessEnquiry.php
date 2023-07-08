<?php
    // default timezone india
	header('Access-Control-Allow-Origin: *'); 
	header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
	header('Content-Type: application/json');
	date_default_timezone_set("Asia/Kolkata");
	require_once('vendor/class.phpmailer.php');
	if(isset($_POST['name']) || isset($_POST['email']) || isset($_POST['contact']) || isset($_POST['message'])){	
		$mail = new PHPMailer(); 
		$mail->IsSMTP();
		$mail->Host = "mail.xyz.com";	 	
		$mail->SMTPAuth = true;
		$mail->Port = 587;
		$mail->Username = "app@xyx.com"; 
		$mail->Password = "";
		$mail->From = "";
		$mail->FromName = ""; 
		$mail->AddBcc("");
		$mail->AddAddress("");    
		// declared variable
		$name = trim($_POST['name']);
		$email = trim($_POST['email']);
		$phone = trim($_POST['contact']); 
		$city = trim($_POST['city']); 
		$feedback = trim($_POST['message']);
		$date = date("l, F j, Y, g:i a") ;
		$ip = $_SERVER['REMOTE_ADDR'];
		$message = '<!doctype html>';
		$message = '<html><body>';
		$message .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
		$message .= "<tr><td><strong> Caller Name</strong> </td><td>".$name."</td></tr>";
		$message .= "<tr><td><strong> Caller Email</strong> </td><td> ".$email." </td></tr>";
		$message .= "<tr><td><strong> Caller Contact no. </strong> </td><td> ".$phone." </td></tr>";
		$message .= "<tr><td><strong> Caller City </strong> </td><td> ".$city." </td></tr>"; 
		$message .= "<tr><td><strong> Date & Time </strong> </td><td>" .$date."</td></tr>";
		$message .= "<tr><td><strong> IP Address </strong> </td><td>" .$ip."</td></tr>"; 
		$message .= "</table>";
		$message .= "</body></html>";
		$mail->IsHTML(true);
		$mail->Subject = "Enquiry for you ".$date."";  
		$mail->Body = $message;
		if(!$mail->Send()){
			$data = array("status"=> "error", "message"=>$mail->ErrorInfo());
			echo json_encode($data);
			exit;
			} else{
				$data = array("status"=> "sucess", "message"=>"Your feedback has been submitted successfully");
				echo json_encode($data);
			}
		} else {
			$data = array("status"=> "error", "message"=>"null");
			echo json_encode($data);
			exit;
		}
?>