
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
	if($input['email']=='' || $input['password']==''){
		$response_data = array("response"=>"Email or password cant be empty");
	} else {
		include '../../db.php';
		$sql = "SELECT * FROM `tbl_user_info` WHERE user_email = '".$input['email']."' AND user_pass = '".$input['password']."'";
		$result = $conn->query($sql);
		
		if ($result->num_rows > 0) {
			//$row = $result->fetch_assoc();
			//echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
			$token = openssl_random_pseudo_bytes(16);
			$token = bin2hex($token);
			$exp_time = date('Y-m-d H:i:s');
			$exp_time = date('Y-m-d H:i:s', strtotime('+1 hour'));
			$sql2 = "INSERT INTO `tbl_login_info` (email,token,expire_time) VALUES ('".$input['email']."','".$token."','".$exp_time."')";
			if ($conn->query($sql2) === TRUE) {
				$response_data = array("response"=>"Login success","token"=>$token, "expire_in"=>$exp_time);
			} else {
				$response_data = array("response"=>"Somethings wrong, please retry");
			}
		} else {
			$response_data = array("response"=>"Invalid email or password");
		}
		$conn->close();
	}
}
echo json_encode($response_data);