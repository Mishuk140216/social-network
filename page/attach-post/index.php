
<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );
//var_dump($uri);
$requestMethod = $_SERVER["REQUEST_METHOD"];

if($requestMethod!="POST"){
	$response_data = array("response"=>"Method not allwod");
} else {
	$input = json_decode(file_get_contents('php://input'), TRUE);
	//$input = file_get_contents('php://input');
	//var_dump($input);
	if($input['user_id']=='' || $input['page_id']=='' || $input['post_content']==''){
		$response_data = array("response"=>"All fields are mandatory");
	} else {
		include '../../db.php';
		$create_time = date('Y-m-d H:i:s');
		
		$sql = "SELECT * FROM `tbl_user_info` WHERE id = '".$input['user_id']."'";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			$sql_page = "SELECT * FROM `tbl_page` WHERE page_id = '".$input['page_id']."'";
			$result_page = $conn->query($sql_page);
			if ($result_page->num_rows > 0) {			
				$sql_insert = "INSERT INTO `tbl_post` (page_id,creator_id, content, create_date) VALUES ('".$input['page_id']."','".$input['user_id']."','".$input['post_content']."','".$create_time."')";
				if ($conn->query($sql_insert) === TRUE) {
					$response_data = array("response"=>"Success");
				} else {
					$response_data = array("response"=>"Somethings wrong, please retry");
				}
			} else {
				$response_data = array("response"=>"Invalid Page");
			}
		}  else {
			$response_data = array("response"=>"Invalid User");
		}
		
		$conn->close();
	}
}
echo json_encode($response_data);