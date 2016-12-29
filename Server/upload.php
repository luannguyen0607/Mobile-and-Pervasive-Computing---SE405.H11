<?php
require_once ("connect.php");
function upload() {
	$database = new db();
	$user_id = check_token();
	$file_path = "uploads/songlist/";
    $file_path = $file_path . $user_id ."_". basename( $_FILES['uploaded_file']['name']);
    if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $file_path)) {
        echo result_mess('true', $user_id ."_". basename( $_FILES['uploaded_file']['name']), 'Upload success');
    } else{
        echo result_mess('false', [], 'Upload fail');
    }
}

function uploadmenu() {
	$database = new db();
	$user_id = check_token();
	$file_path = "uploads/menu/";
    $file_path = $file_path . $user_id ."_". basename( $_FILES['uploaded_file']['name']);
    if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $file_path)) {
        echo result_mess('true', $user_id ."_". basename( $_FILES['uploaded_file']['name']), 'Upload success');
    } else{
        echo result_mess('false', [], 'Upload fail');
    }
}
