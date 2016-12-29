<?php

//session_start(); //we need to start session in order to access it through CI

Class Setting extends CI_Controller {

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
		$this->load->model('user_song_model');
		
		$this->load->model('login_database');
		
		$this->load->model('setting_model');

		$this->load->helper('url');
	}

	public function index() {
		$this->form_validation->set_rules('title', 'Title', 'required');
		if ($this->form_validation->run() == FALSE) {
			$this->load->view('setting');
		} else {
			$result = $this->setting_model->update_setting('title', $this->input->post('title'));
			$result1 = $this->setting_model->update_setting('email', $this->input->post('email'));
			$result2 = $this->setting_model->update_setting('address', $this->input->post('address'));
			$result3 = false;
			
			if($_FILES['logo']['name'] != "") {
				$config = array();
				$path = dirname(realpath(BASEPATH)) ."/assets/img/";
				$config['file_name'] = "logo.png";
				$config['overwrite'] = TRUE;
				$config['upload_path']   = $path;
				$config['allowed_types'] = '*';
				$this->load->library('upload', $config);
				if($this->upload->do_upload('logo')) {
					$result3 = true;
				}
			}
						
			if ($result || $result1 || $result2 || $result3) {
				$data['message_display'] = 'Update success! ';
				$this->load->view('setting', $data);
			} else {
				$data['message_display'] = 'No thing update! ';
				$this->load->view('setting', $data);
			}
		}
	}
	
	public function smtp() {
		$this->form_validation->set_rules('host', 'SMTP host', 'required');
		$this->form_validation->set_rules('type', 'SMTP type', 'required');
		$this->form_validation->set_rules('port', 'SMTP port', 'required');
		$this->form_validation->set_rules('user', 'SMTP user', 'required');
		if ($this->form_validation->run() == FALSE) {
			$this->load->view('setting_smtp');
		} else {
			$result = $this->setting_model->update_setting('smtp_host', $this->input->post('host'));
			$result1 = $this->setting_model->update_setting('smtp_type', $this->input->post('type'));
			$result2 = $this->setting_model->update_setting('smtp_port', $this->input->post('port'));
			$result3 = $this->setting_model->update_setting('smtp_user', $this->input->post('user'));
			$result4 = false;
			if ($this->input->post('pass')) {
				$result4 = $this->setting_model->update_setting('smtp_pass', $this->input->post('pass'));
			}
				
			if ($result || $result1 || $result2 || $result3 || $result4) {
				$data['message_display'] = 'Update success! ';
				$this->load->view('setting_smtp', $data);
			} else {
				$data['message_display'] = 'No thing update! ';
				$this->load->view('setting_smtp', $data);
			}
		}
	}
	
}