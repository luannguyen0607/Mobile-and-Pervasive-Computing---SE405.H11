<?php

Class User_management extends CI_Controller {

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
		$this->load->model('client_model');
		
		$this->load->model('user_song_model');

		$this->load->helper('url');
		
		if ( ! $this->session->userdata['logged_in'])
        {
            redirect('user_authentication');
        }
	}

	// Show login page
	public function index() {
		// echo json_encode($data);
		$this->load->view('user_management');
	}
	
	public function add_new_user() {
		$this->form_validation->set_rules('client_name', 'Username', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('status', 'Status', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->load->view('add_user');
		} else {
			$data = array(
				'username' => $this->input->post('client_name'),
				'email' => $this->input->post('email'),
				'password' => md5($this->input->post('password')),
				'name' => $this->input->post('name'),
				'status' => $this->input->post('status'),
				'address' => $this->input->post('address'),
				'phone' => $this->input->post('phone')
			);
			$result = $this->client_model->add_new_user($data);
			if ($result == TRUE) {
				$config = array();
				$path = dirname(dirname(realpath(BASEPATH))) ."/uploads/menu";
				$new_name = $this->client_model->get_id($data['username']) . "_KTVMENU1.ini";
				$config['file_name'] = $new_name;
				$config['upload_path']   = $path;
				$config['allowed_types'] = '*';
				$this->load->library('upload', $config);
				if($this->upload->do_upload('menu'))
				{
					$config = array();
					$path = dirname(dirname(realpath(BASEPATH))) ."/uploads/songlist";
					$config['upload_path']   = $path;
					$new_name = $this->client_model->get_id($data['username']) . "_SONGLIST.txt";
					$config['file_name'] = $new_name;
					$config['allowed_types'] = '*';
					$this->upload->initialize($config);
					if($this->upload->do_upload('songlist'))
					{
						$data = $this->upload->data();
						$data['message_display'] = 'Add user Successfully !';
						$this->load->view('user_management', $data);
					}
					else
					{
						$error = $this->upload->display_errors();
						$data['message_display'] = 'Upload error! '. $error;
						$this->load->view('add_user', $data);
					}
				}
				else
				{
					$error = $this->upload->display_errors();
					$data['message_display'] = 'Upload error! '. $error;
					$this->load->view('add_user', $data);
				}
			} else {
				$data['message_display'] = 'Username or email already exist!';
				$this->load->view('add_user', $data);
			}
		}
	}
	
	public function edit_user($id = "") {
		$this->form_validation->set_rules('client_name', 'Username', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required');
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('status', 'Status', 'trim|required');
		$data = array('id' => $id);
		if ($this->form_validation->run() == FALSE) {
			$this->load->view('add_user', $data);
		} else {
			$data['username'] = $this->input->post('client_name');
			$data['email'] = $this->input->post('email');
			$data['name'] = $this->input->post('name');
			$data['status'] = $this->input->post('status');
			$data['address'] = $this->input->post('address');
			$data['phone'] = $this->input->post('phone');
			if ($this->input->post('password')) {
				$data['password'] = md5($this->input->post('password'));
			}
			$result = $this->client_model->update_user($id, $data);
			if ($result['status'] != 2) {
				$config = array();
				$path = dirname(dirname(realpath(BASEPATH))) ."/uploads/menu";
				$new_name = $id . "_KTVMENU1.ini";
				$config['file_name'] = $new_name;
				$config['upload_path']   = $path;
				$config['allowed_types'] = '*';
				$config['overwrite'] = TRUE;
				$this->load->library('upload', $config);
				if($_FILES['menu']['name'] != "") {
					if(!$this->upload->do_upload('menu')) {
						$error = $this->upload->display_errors();
						$data['message_display'] = 'Update file menu error! '. $error;
						$this->load->view('add_user', $data);
						return;
					}
				}
				
				if ($_FILES['songlist']['name'] != "") {
					$config = array();
					$path = dirname(dirname(realpath(BASEPATH))) ."/uploads/songlist";
					$config['upload_path']   = $path;
					$new_name = $id . "_SONGLIST.txt";
					$config['file_name'] = $new_name;
					$config['allowed_types'] = '*';
					$config['overwrite'] = TRUE;
					$this->upload->initialize($config);
					if(!$this->upload->do_upload('songlist')) {
						$error = $this->upload->display_errors();
						$data['message_display'] = 'Update file songlist error! '. $error;
						$this->load->view('add_user', $data);
						return;
					}
				}
				if ($_FILES['songlist']['name'] == "" && $_FILES['menu']['name'] == "" && $result['status'] == 1){
					$data['message_display'] = 'Nothing update!';
					$this->load->view('add_user', $data);
				} else {
					$data['message_display'] = 'Update success!';
					$this->load->view('add_user', $data);
				}
			} else {
				$data['message_display'] = 'Edit user error! '. $result['mes'];
				$this->load->view('add_user', $data);
			}
		}
	}
	
	public function delete_user() {
		$this->form_validation->set_rules('id', 'ID', 'required');
		if ($this->form_validation->run() == FALSE) {
			$this->load->view('user_management');
		} else {
			$result = $this->client_model->delete_user($this->input->post('id'));
			if ($result == TRUE) {
					$data['message_display'] = 'Delete user Successfully !';
					$this->load->view('user_management', $data);
			} else {
				$data['message_display'] = "Detete user fail !" ;
				$this->load->view('user_management', $data);
			}
		}
	}
	
	public function update_user_song($id = "") {
		if ($id) {
			$data = array('id' => $id);		
			$newlists = $this->input->post('user_songs');
			if (!is_array($newlists)) {
				$newlists = [];
			}
			$result = $this->user_song_model->update_song_user($id, $newlists);
			if ($result != 0) {
				$data['message_display'] = "Update user song fail !" ;
			} else {
				$data['message_display'] = "Update user song success !" ;
			}
			redirect('/user_management/edit_user/'. $id);
		} else {
			redirect('/user_management');
		}
		
	} 
}