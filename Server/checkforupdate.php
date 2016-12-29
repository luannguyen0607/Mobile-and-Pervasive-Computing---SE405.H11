<?php
require_once ("connect.php");
function checkforupdate() {
	$database = new db();
	
	$client_version = $_REQUEST["version"];
	$sql = "SELECT * FROM `version`";
	$data = $database->query($sql);
	
	$server_version = $data[0]['version'];
	
	$check = $server_version - $client_version;
	if ($check > 0) {
		$basename = basename($_SERVER['HTTP_HOST']);
		$filename = 'http://'.$basename ."/koong/update/".$data[0]['filename'];
		
		echo json_encode(array("status"=>true, "mess"=>$server_version, "data"=>$filename));
		die();
	}
	
	echo json_encode(array("status"=>false, "mess"=>"Your app version is up to date", "data"=>""));
}
