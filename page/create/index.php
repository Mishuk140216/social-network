
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
	if($input['user_id']=='' || $input['page_name']==''){
		$response_data = array("response"=>"User ID or Page Name cant be empty");
	} else {
		include '../../db.php';
		$page_id =date('Y-m-d H:i:s');
		$page_id = strtotime($page_id);
		$page_id = $input['user_id']."_".$page_id;
		$create_time = date('Y-m-d H:i:s');
		$sql = "INSERT INTO `tbl_page` (page_id,page_name,page_info,creator_id,create_date) VALUES ('".$page_id."','".$input['page_name']."','".$input['page_info']."','".$input['user_id']."','".$create_time."')";
		if ($conn->query($sql) === TRUE) {
			$response_data = array("response"=>"Page Create success","page_id"=>$page_id);
		} else {
			$response_data = array("response"=>"Somethings wrong, please retry");
		}
		$conn->close();
	}
}
echo json_encode($response_data);