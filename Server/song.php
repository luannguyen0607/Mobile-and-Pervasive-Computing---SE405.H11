<?php

require_once ("connect.php");
function get_song() {
	$database = new db();
	$user_id = check_token();
	
	$sql = "SELECT b.*, a.* FROM `user_song` a INNER JOIN `song` b on a.song_id = b.id where a.user_id = ". $user_id ." and a.status = 0";
	
	$data = $database->query($sql);
	
	

	if ($data) {
		$mess = result_mess('true', $data, 'Get song success');
		
		echo($mess);
		die();
	}

	$mess = result_mess('true', array(), 'No avaiable download song');
	echo($mess);
	die();
}

function download() {
	$database = new db();
	$user_id = check_token();
	
	if (!isset($_REQUEST['id'])) {
		echo result_mess('false', null, 'Some field missing');
		die();
	}
	$usersong_id = $_REQUEST['id'];
	
	if( ! ini_get('date.timezone') )
	{
		date_default_timezone_set('GMT');
	}
	$date = date('Y-m-d H:i:s');
	$data = $database->update('user_song', array('status' => 1, 'down_date' => $date), array('id' => $usersong_id));
	
	$mess = result_mess('true', $data, 'Get song success');
	
	echo($mess);
	die();
}