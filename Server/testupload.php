<?php
  
    $file_path = "uploads/";
     
    $file_path = $file_path . basename( $_FILES['uploaded_file']['name']);
    if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $file_path)) {
		$test = [];
		$test["mess"] = "fuck you";
        echo json_encode($test);
    } else{
        echo "fail";
    }
 ?>