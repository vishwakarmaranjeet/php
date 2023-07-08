<?php
	header('Access-Control-Allow-Origin: *'); 
	header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
	header('Content-Type: application/json');
	date_default_timezone_set('Asia/Kolkata');
	function get_client_ip() {
			$ipaddress = '';
			if (getenv('HTTP_CLIENT_IP'))
				$ipaddress = getenv('HTTP_CLIENT_IP');
			else if(getenv('HTTP_X_FORWARDED_FOR'))
				$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
			else if(getenv('HTTP_X_FORWARDED'))
				$ipaddress = getenv('HTTP_X_FORWARDED');
			else if(getenv('HTTP_FORWARDED_FOR'))
				$ipaddress = getenv('HTTP_FORWARDED_FOR');
			else if(getenv('HTTP_FORWARDED'))
			   $ipaddress = getenv('HTTP_FORWARDED');
			else if(getenv('REMOTE_ADDR'))
				$ipaddress = getenv('REMOTE_ADDR');
			else
				$ipaddress = 'UNKNOWN';
			return $ipaddress;
	}
	require_once('includes/config.php'); 
	if(isset($_POST['email']) || isset($_POST['password'])){ 
		$email = trim($_POST['email']);
		$password = trim($_POST['password']);
		$device = "Mobile Application";
		$ip = get_client_ip(); 
		$date = date("Y-m-d H:i:s");   
		try{
			$status = 1;  
			$sql = "SELECT * from company_details_tbl WHERE Username =:email AND Password =:password AND Status =:status LIMIT 0,1"; 
			$stmt = $DB->prepare($sql);
			$stmt->bindValue(":email", $email);
			$stmt->bindValue(":password", $password);
			$stmt->bindValue(":status", $status);     
			$stmt->execute();
			$result = $stmt->fetchAll();   
			if(!$result){
				$data = array("status" => "error", "message"=>"Invalid Login Credentials");
				echo json_encode($data);
			}else {
				$data = array("status" => "success", "userdetails" =>$result);     
				echo json_encode ($data);  
			    $sql = "INSERT INTO `user_logs_tbl`(`UserName`, `Device`, `IPaddress`, `Date`)
			    VALUES "."(:user, :device, :ipaddress, :date)";
			    $stmt = $DB->prepare($sql);
			    $stmt->bindValue(":user", $email);
			    $stmt->bindValue(":device", $device); 
			    $stmt->bindValue(":ipaddress", $ip);
			    $stmt->bindValue(":date", $date);
			    $stmt->execute();
			}
		} catch(Exception $ex){
			echo $ex->getMessage();
		}
	} else{
		$data = array("status" => "error", "message"=>"null");  
		echo json_encode($data);
	}
?>