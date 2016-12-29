<?php

if (!defined('BASEPATH'))
exit('No direct script access allowed');
  
class Test extends CI_Controller {
  
    public function index($message = '') {
        echo $message;
    }
	
	public function test() {
        echo 'Test test';
    }
}