<?php
header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Content-Type: application/json');
require('includes/constant.php');
require('includes/database.php');
if (!isset($_GET['keyword'])) { 
	die("");
}  
$keyword = $_GET['keyword'];
$data = serachForKeyword($keyword);
echo json_encode($data, JSON_HEX_APOS);