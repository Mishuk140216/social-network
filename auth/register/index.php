
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
	if($input['first_name']=='' || $input['email']=='' || $input['password']==''){
		$response_data = array("response"=>"Mandatory fields are First name, Email and password. Those are cant be empty");
	} else {
		include '../../db.php';
		$sql = "INSERT INTO `tbl_user_info` (first_name,middle_name,last_name,user_email,user_pass) VALUES ('".$input['first_name']."','".$input['middle_name']."','".$input['last_name']."','".$input['email']."','".$input['password']."')";
		if ($conn->query($sql) === TRUE) {
			$response_data = array("response"=>"New user created successfully");
		} else {
			$response_data = array("response"=>"Somethings wrong, please retry");
		}

		$conn->close();
	}
}
echo json_encode($response_data);