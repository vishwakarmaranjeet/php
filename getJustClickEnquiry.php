<?php
		header('Access-Control-Allow-Origin: *'); 
		header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
		header('Content-Type: application/json'); 
	    date_default_timezone_set("Asia/Kolkata");
	    if(isset($_POST['name']) || isset($_POST['email']) || isset($_POST['contact']) || isset($_POST['message'])){  
		 require_once("vendor/class.phpmailer.php"); 
		try{
			$mail = new PHPMailer();
			$mail->IsSMTP();
			$mail->Host = "";	
			$mail->SMTPAuth = true;
			$mail->Port = 587;
			$mail->Username = ""; 
			$mail->Password = "";
			$mail->From = "";
			$mail->FromName = "";  
			$name = trim($_POST['name']); // name
			$cname = trim($_POST['cname']); // cname 
			$to =  trim($_POST['receipt']); // receipt 
			$email = trim($_POST['email']); // email
			$phone = trim($_POST['contact']); // contact no
			$enquiry = trim($_POST['message']); // query
			$date = date("l, F j, Y, g:i a") ; // date & time 
			$mail->AddBcc(""); 
			$mail->AddAddress($to);
			// sms integration code
			$authKey = "";
			$mobileNumber = trim($_POST['mobilesms']); 
			$senderId = "102234"; 
			$text = ""; 
			$msg = "$text $name $email $phone";  
			$message = urlencode($msg);
			$route = "default";
			//Prepare you post parameters
			$postData = array(
				'authkey' => $authKey,
				'mobiles' => $mobileNumber,
				'message' => $message,
				'sender' => $senderId,
				'route' => $route
			);
			//API URL
			$url="";
			// init the resource
			$ch = curl_init();
			curl_setopt_array($ch, array(
				CURLOPT_URL => $url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_POST => true,
				CURLOPT_POSTFIELDS => $postData
			  ));
			//Ignore SSL certificate verification
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			//get response
			$output = curl_exec($ch);
			$message = '<html><body>';
			$message .= '<table rules="all" style="border-color: #666;" cellpadding="10" width="100%">';
			$message .= "<tr><td colspan='2'><img src='' alt='The Electric Merchant associaion'></td></tr>";
			$message .= "<tr><td colspan='2' style='background-color:#eee;'><strong> Lead Details </strong></td></tr>";
			$message .= "<tr><td><strong> Caller Name:</strong> </td><td>".$name."</td></tr>";
			$message .= "<tr><td><strong> Company Name:</strong> </td><td>".$cname."</td></tr>";
			$message .= "<tr><td><strong> Caller Email:</strong> </td><td> ".$email." </td></tr>";
			$message .= "<tr><td><strong> Caller Contact No. :</strong> </td><td> ".$phone." </td></tr>";
			$message .= "<tr><td><strong> Caller Requirement :</strong> </td><td> ".$enquiry." </td></tr>";
			$message .= "<tr><td><strong> Date & Time  :</strong> </td><td>" .$date."</td></tr>";
			$message .= "</table>";
			$message .= "<p>Thank you for your continued support to build a strong relationship 
			with you to provide best-in-class service to our members.</p></br>";
			$message .= "<p>EMA is the best market place for you to generate leads 
			for your business from Google through Listing on our website with a common purpose.</p>";
			$message .= "<p><strong>FOR ADVERTISEMENT ON</strong> 
			<a href='' target='_blank'></a></p>";
			$message .= "<p>Please feel free to EMA for any queries / clarifications from your end. 
			EMA Office on Tel No. 022 - 22060625 / 22088141 or send an email to emamub@gmail.com 
			</p></br>";
			$message .= "<p><strong>Warm Regards,<br/>The Electric Merchant's Association – Website Committee</strong></p>";
			$message .= "</body></html>";  
			$mail->IsHTML(true);
			$mail->Subject = "EMA Enquiry From App";   
			$mail->Body = $message;
			if($mail->Send()){
				$data = array("status"=> "success", "message"=>"Your feedback has been submitted successfully");
				echo json_encode($data);  
			}
			//$mail->send();
		    curl_close($ch);
			die;
		} catch(phpmailerException $e){ 
			echo $e->errorMessage();
			if(curl_errno($ch)){
			   echo 'error:' . curl_error($ch);
			}
		} 
	}
?>