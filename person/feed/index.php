
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

if($requestMethod!="GET"){
	$response_data = array("response"=>"Method not allwod");
} else {
	$input = json_decode(file_get_contents('php://input'), TRUE);
	if($input['user_id']==''){
		$response_data = array("response"=>"All fields are mandatory");
	} else {
		include '../../db.php';
		
		$sql = "SELECT * FROM `tbl_feed` WHERE user_id = '".$input['user_id']."'";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			$response_data = array();
			while($row = $result->fetch_assoc()){
				$feed_id = $row["id"];
				$feed_description = $row["feed_description"];
				$feed_create_date = $row["create_date"];
				$temp_response_data = array("feed_id"=>$feed_id,"feed_description"=>$feed_description,"feed_create_date"=>$feed_create_date);
				array_push($response_data,$temp_response_data);
			}
		}  else {
			$response_data = array("response"=>"No feed found");
		}
		
		$conn->close();
	}
}
echo json_encode($response_data);