<?php

//session_start(); //we need to start session in order to access it through CI

Class User_Authentication extends CI_Controller {

	public function __construct() {
		parent::__construct();

		// Load form helper library
		$this->load->helper('form');

		// Load form validation library
		$this->load->library('form_validation');

		// Load session library
		$this->load->library('session');

		$this->load->database();
		// Load database
		$this->load->model('login_database');
		
		$this->load->model('setting_model');

		$this->load->helper('url');
	}

	// Show login page
	public function index() {
		$this->load->view('login_form');
	}

	// Show registration page
	public function user_registration_show() {
		$this->load->view('registration_form');
	}

	// Validate and store registration data in database
	public function new_user_registration() {

		// Check validation for user input in SignUp form
		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->load->view('registration_form');
		} else {
			$data = array(
				'username' => $this->input->post('username'),
				'email' => $this->input->post('email'),
				'password' => $this->input->post('password')
			);
			$result = $this->login_database->registration_insert($data);
			if ($result == TRUE) {
				$data['message_display'] = 'Registration Successfully !';
				$this->load->view('login_form', $data);
			} else {
				$data['message_display'] = 'Username already exist!';
				$this->load->view('registration_form', $data);
			}
		}
	}

	// Check for user login process
	public function user_login_process() {
		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');

		if ($this->form_validation->run() == FALSE) {
			if(isset($this->session->userdata['logged_in'])){
				$count_client =  $this->login_database->count_client();
				$count_song = $this->login_database->count_song();
				$user_song = $this->login_database->get_new_download();
				$this->load->view('admin');
			}else{
				$this->load->view('login_form');
			}
		} else {
			$data = array(
				'username' => $this->input->post('username'),
				'password' => $this->input->post('password')
			);
			$result = $this->login_database->login($data);
			if ($result == TRUE) {
				$username = $this->input->post('username');
				$result = $this->login_database->read_user_information($username);
				if ($result != false) {
					$session_data = array(
						'username' => $result[0]->username,
						'email' => $result[0]->email,
						'id' => $result[0]->id
						// 'token' => $result[0]->token,
						);
					// Add user data in session
					$this->session->set_userdata('logged_in', $session_data);
					$this->load->view('admin');
				}
			} else {
				$data = array(
					'error_message' => 'Invalid Username or Password'
				);
				$this->load->view('login_form', $data);
			}
		}
	}

	// Logout from admin page
	public function logout() {
		// Removing session data
		$sess_array = array(
			'username' => ''
		);
		$this->session->unset_userdata('logged_in', $sess_array);
		$data['message_display'] = 'Successfully Logout';
		$this->load->view('login_form', $data);
	}
	
	public function change_password() {
		// Check validation for user input in SignUp form
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('old_pass', 'Current password', 'required');
		$this->form_validation->set_rules('new_pass', 'New password', 'required');
		$this->form_validation->set_rules('re_pass', 'Confirm password', 'required');
		if ($this->form_validation->run() == FALSE) {
			$this->load->view('change_pass');
		} else {
			$username = $this->input->post('username');
			$oldpass = $this->input->post('old_pass');
			$newpass = $this->input->post('new_pass');
			$repass = $this->input->post('re_pass');
			if ($newpass != $repass) {
				$data['message_display'] = 'Confirm password not match!';
				$this->load->view('change_pass', $data);
			} else {
				$data = array(
						'username' => $username,
						'password' => $oldpass
				);
				$login = $this->login_database->login($data);
				if (!$login) {
					$data['message_display'] = 'Current password not match!';
					$this->load->view('change_pass', $data);
				} else {
					$result = $this->login_database->change_pass($username, $repass);
					if ($result == TRUE) {
						$data['message_display'] = 'Change password Successfully !';
						$this->load->view('change_pass', $data);
					} else {
						$data['message_display'] = 'Nothing change!';
						$this->load->view('change_pass', $data);
					}
				}
			}
		}			
	}
	
	function sendmail($email = "", $link = "") {
		$host = $this->setting_model->get_setting('smtp_type') == 1? 'ssl' : 'tls';
		$config = Array(
			'protocol' => "smtp",
			'smtp_host' => $host ."://" . $this->setting_model->get_setting('smtp_host'),
			'smtp_port' => $this->setting_model->get_setting('smtp_port'),
			'smtp_user' => $this->setting_model->get_setting('smtp_user'), // change it to yours
			'smtp_pass' => $this->setting_model->get_setting('smtp_pass'), // change it to yours
			'mailtype' => 'html',
			'charset' => 'utf8',
			'wordwrap' => TRUE
		);
		// print_r($config);
		$this->load->library('email');
		$this->email->initialize($config);
		
		$message = "Hi sir,<br>We received a request to reset your password Koong Media account: " . $email .". We're here to help!<br>Simple click <a href='". $link ."'>here</a> to reset your password on Koong Media.<br>Koong media,<br>";
		$this->email->set_newline("\r\n");
		$this->email->from('resetpass@koongmedia.com', 'Koong Media'); // change it to yours
		$this->email->to($email);// change it to yours
		$this->email->subject('Koong media reset password');
		$this->email->message($message);
		if($this->email->send())
		{
			// print_r($this->email->print_debugger());
			return true;
		}
		else
		{
			// print_r($this->email->print_debugger());
			return false;
			
		}

	}
	
	public function forgot_password() {
		$this->form_validation->set_rules('email', 'Email', 'required');
		if ($this->form_validation->run() == FALSE) {
			$this->load->view('login_form');
		} else {
			$email = $this->input->post('email');
			$code = mt_rand('5000', '200000');
			$user_id = $this->login_database->get_id($email);
			$link = base_url() . "user_authentication/reset_pass/". $user_id ."/". $code;
			$check_email = $this->login_database->forgot_pass($email, $code);
			
			if ($check_email) {
				$this->sendmail($email, $link);
				// $result = array('status' => true, 'mes' => 'Check email to resset your password');
				// echo json_encode($result);
				$data['message_display'] = 'Check email to resset your password!';
				$this->load->view('login_form', $data);
			} else {
				// $result = array('status' => false, 'mes' => 'Email not found!');
				// echo json_encode($result);
				$data['message_display'] = 'Email not found!';
				$this->load->view('login_form', $data);
			}
		}
	}
	
	public function reset_pass($user_id, $token) {
		if ($this->login_database->check_token($user_id, $token)){
			$data = array('user_id' => $user_id, 'token' => $token);
			$this->load->view('reset_pass', $data);
		} else {
			$data['message_display'] = 'Reset pasword error please try again!';
			$this->load->view('login_form', $data);
		}
	}
	
	public function reset_pass_action() {
		$this->form_validation->set_rules('user_id', 'User_id', 'required');
		$this->form_validation->set_rules('token', 'Token', 'required');
		$this->form_validation->set_rules('new_pass', 'New password', 'required');
		$this->form_validation->set_rules('re_pass', 'Comfirm password', 'required');
		if ($this->form_validation->run() == FALSE) {
			$this->load->view('login_form');
		} else {
			$user_id = $this->input->post('user_id');
			$token = $this->input->post('token');
			$new_pass = $this->input->post('new_pass');
			
			$result = $this->login_database->reset_pass($user_id, $token, $new_pass);
			if ($result) {
				$data['message_display'] = 'Reset pasword success!';
				$this->load->view('login_form', $data);
			} else {
				$data['message_display'] = 'Reset pasword error please try again!';
				$this->load->view('login_form', $data);
			}
		}
	}
	
}

?>