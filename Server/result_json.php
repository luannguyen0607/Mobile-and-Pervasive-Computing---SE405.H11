<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class result_json {
	public $status = false;
	public $data = null;
	public $mess = 'No thing response';
	
	public function __construct($status, $data, $mess){
		if (isset($status)) {
			$this->status = $status;
		}
		
		if (isset($data)) {
			$this->data = $data;
		}
		if (isset($mess)) {
			$this->mess = $mess;
		}
	}
	
	public function get_json() {
		$result = array('status' => $this->status, 'data' => $this->data, 'mess' => $this->mess);
		return json_encode($result);
	}
}

function result_mess($status, $data, $mess) {
	$mess = new result_json($status, $data, $mess);
	return $mess->get_json();
}

function random_password( $length = 16 ) {
	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	$password = substr( str_shuffle( $chars ), 0, $length );
	return $password;
}

function get_base_url() {
	$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $domainName = $_SERVER['HTTP_HOST'].'/';
    return $protocol.$domainName;
}