<?php
	header('Access-Control-Allow-Origin: *'); 
	header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
	header('Content-Type: application/json');
    require_once('includes/config.php');
	if(isset($_GET['category']) && ($_GET['brand'])){    
		  try{		  
		  $category_id = $_REQUEST['category'];
		  $brand_id = $_REQUEST['brand']; 
		  $sql = "SELECT JCCDT.CompanyID,JCCDT.CompanyName,JCCDT.BusinessDescription,
		  JCCDT.MemberType,JCCDT.Address,JCCLT.MembershipType,JCCDT.Email,JCCDT.City,JCCDT.State,JCCDT.PinCode,
		  JCCDT.Email2,JCCDT.Email3,  
		  JCCPT.Pricelist,JCCDT.ContactNo,JCCDT.ContactNo2,JCCDT.ContactNo3,  
		  JCCDT.Proprietor,JCCDT.Proprietor2,JCCDT.Proprietor3, JCCLT.CategoryID,JCCLT.BrandID, 
		  JCCDT.Website,JCCDT.Fax,JCCDT.Fax2,JCCDT.Fax3,JCCDT.Mobile,JCCDT.Mobile2,JCCDT.Mobile3,JCCDT.ProfileImage  
		  FROM justclick_company_details_tbl AS JCCDT  
		  LEFT JOIN justclick_pricelist_tbl AS JCCPT ON JCCPT.CompanyID = JCCDT.CompanyID 
		  AND JCCPT.CategoryID =:cat_id AND JCCPT.BrandID =:brand_id 
		  INNER JOIN justclick_company_listing_tbl AS JCCLT ON JCCDT.CompanyID = JCCLT.CompanyID WHERE
		  JCCLT.BrandID =:brand_id AND JCCLT.CategoryID =:cat_id  AND JCCDT.Status = '1' AND JCCLT.Status = '1' 
		  ORDER BY JCCLT.MembershipType DESC, JCCLT.SortOrder ASC"; 
		  $stmt = $DB->prepare($sql);
		  $stmt->bindValue(":brand_id", $brand_id);
		  $stmt->bindValue(":cat_id", $category_id); 
		  $stmt->execute();
		  $result = $stmt->fetchAll();
		  if($result){
			 $data = array("status" => "success", "listings"=>$result);    
			 echo json_encode($data);
		  } else {
			 $data = array("status" => "success", "listings"=>"0");    
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