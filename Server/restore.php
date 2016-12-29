<?php
require_once ("connect.php");
function restore() {
	$database = new db();
	$user_id = check_token();
	$basename = get_base_url();
	$data['menu'] = $basename ."koong/uploads/menu/". $user_id ."_KTVMENU1.ini";
	$data['songlist'] = $basename ."koong/uploads/songlist/". $user_id. "_SONGLIST.txt";
	echo result_mess('true', $data, 'Restore success');
}