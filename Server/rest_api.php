<?php

require_once ("connect.php");
require_once ("login.php");
require_once ("song.php");
require_once ("upload.php");
require_once ("restore.php");
require_once ("checkforupdate.php");

// if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	// echo result_mess('false', null, 'This API not support get method');
	// die();
// }

if (!isset($_REQUEST['action']) || !$_REQUEST['action']) {
	echo result_mess('false', null, 'Some field missing');
	die();
}
$action = $_REQUEST['action'];
call_user_func($action);

function check_token() {
	if (!isset($_REQUEST['username']) || !isset($_REQUEST['token'])) {
		echo result_mess('false', null, 'Some field missing');
		die();
	}

	$username = $_REQUEST['username'];
	$token = $_REQUEST['token'];

	$database = new db();
	
	$data = $database->select('client', '*', array('username' => $username, 'token' => $token));
	
	if (is_array($data) && count($data)) {
		return $data[0]['id'];
	} else {
		echo result_mess('false', null, 'Token or username error');
		die();
	}
}
