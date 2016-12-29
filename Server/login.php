<?php

require_once ("connect.php");
function login() {

	if (!isset($_REQUEST['username']) || !isset($_REQUEST['password'])) {
		echo result_mess('false', null, 'Some field missing');
		die();
	}

	$username = $_REQUEST['username'];
	$password = $_REQUEST['password'];

	$database = new db();

	$md5_pass = md5($password);

	$data = $database->select('client', '*', array('username' => $username, 'password' => $md5_pass));

	if (is_array($data) && count($data)) {
		$data = $data[0];
		
		if ($data['status'] == "deactive") {
			$mess = result_mess('false', null, 'Hi '. $username .', your account is inactive');
			echo($mess);
			die();
		}
		$mess = result_mess('true', $data, 'Login success');
		$token = random_password(8);
		$database->update('client', array('token' => $token), array('username' => $username));
		$data['token'] = $token;
			
		$mess = result_mess('true', $data, 'Hi '. $username .', Login success');
		
		echo($mess);
		die();
	}

	$mess = result_mess('false', null, 'Hi '. $username .', Login fail');
	echo($mess);
	die();
}
