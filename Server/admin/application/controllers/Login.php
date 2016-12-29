<?php

if (!defined('BASEPATH'))
exit('No direct script access allowed');
  
class Login extends CI_Controller {
	
	function __construct() {
        // Gọi đến hàm khởi tạo của cha
        parent::__construct();
		$this->load->database();
		$this->load->library("session");
		$this->load->helper('form');
        $this->load->helper('url');
		$this->load->model('client_model');
    }
  
    public function index($username = '', $password = '') {
		$data = array(
            'username' => $username,
            'password' => $password
        );
  
        // Load view và truyền data qua view
        $this->load->view('login_view', $data);
    }
	
	public function test() {
		$data = array(
            "username" => "Kaito",
            "email" => "codephp2013@gmail.com",
            "website" => "freetuts.net",
            "gender" => "Male",
        );
        $this->session->set_userdata($data);
		echo base_url();
        redirect(base_url()."index.php/login/test1");
    }
	
	public function test1() {
        $data = $this->session->all_userdata();
        echo "<pre>";
        print_r($data);
        echo "</pre>";   
    }
	
	public function test2(){
         $this->session->sess_destroy();
		 redirect(base_url()."index.php/login/test1");
         echo "Huy session thanh cong.";
    }
	
	public function data() {
		$query = $this->db->query("select * from client");
		$data = $query->result_array();
		echo "<pre>";
		print_r($data);
		echo "</pre>";
	}
	
	public function test3() {
		echo $this->client_model->count_user_song(1);
	}
}