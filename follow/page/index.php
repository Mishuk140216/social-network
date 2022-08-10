
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

if($requestMethod!="POST" && $requestMethod!="PUT"){
	$response_data = array("response"=>"Method not allwod");
} else {
	$input = json_decode(file_get_contents('php://input'), TRUE);
	//$input = file_get_contents('php://input');
	//var_dump($input);
	if($input['following_page_id']=='' || $input['follow_by_id']==''){
		$response_data = array("response"=>"All fields are mandatory");
	} else {
		include '../../db.php';
		$create_time = date('Y-m-d H:i:s');
		
		$sql = "SELECT * FROM `tbl_page` WHERE page_id = '".$input['following_page_id']."'";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			$row = $result->fetch_assoc();
			$follower_list = $row["followers_id"];
			$follower_list = $follower_list.$input['follow_by_id'].",";
			$sql_fby = "SELECT * FROM `tbl_user_info` WHERE id = '".$input['follow_by_id']."'";
			$result_fby = $conn->query($sql_fby);
			if ($result_fby->num_rows > 0) {
				$sql_update = "UPDATE `tbl_page` SET followers_id = '".$follower_list."' WHERE id = '".$input['following_page_id']."'";
				if ($conn->query($sql_update) === TRUE) {
					$response_data = array("response"=>"Success");
				} else {
					$response_data = array("response"=>"Somethings wrong, please retry");
				}
			} else {
				$response_data = array("response"=>"Invalid followed by user");
			}
		} else {
			$response_data = array("response"=>"The page you wants to follow, is invalid");
		}
		$conn->close();
	}
}
echo json_encode($response_data);