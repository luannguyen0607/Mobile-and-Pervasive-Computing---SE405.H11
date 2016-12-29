<?php

Class Admin_management extends CI_Controller {

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
		$this->load->model('admin_model');

		$this->load->helper('url');
		
		if ( ! $this->session->userdata['logged_in'])
        {
            redirect('user_authentication');
        }
	}

	// Show login page
	public function index() {
		// echo json_encode($data);
		$this->load->view('admin_management');
	}
	
	public function add_new_user() {
		$this->form_validation->set_rules('adminname', 'Username', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->load->view('add_admin');
		} else {
			$data = array(
				'username' => $this->input->post('adminname'),
				'email' => $this->input->post('email'),
				'password' => md5($this->input->post('password')),
				'name' => $this->input->post('name')
			);
			$result = $this->admin_model->add_new_user($data);
			if ($result == TRUE) {
				$data['message_display'] = 'Add user Successfully !';
				$this->load->view('admin_management', $data);
			} else {
				$data['message_display'] = 'Username or email already exist!';
				$this->load->view('add_admin', $data);
			}
		}
	}
	
	public function edit_user($id = "") {
		$this->form_validation->set_rules('adminname', 'Username', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required');
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$data = array('id' => $id);
		if ($this->form_validation->run() == FALSE) {
			$this->load->view('add_admin', $data);
		} else {
			$data['username'] = $this->input->post('adminname');
			$data['email'] = $this->input->post('email');
			$data['name'] = $this->input->post('name');
			if ($this->input->post('password')) {
				$data['password'] = md5($this->input->post('password'));
			}
			$result = $this->admin_model->update_user($id, $data);
			if ($result['status'] != 2) {
				if ($result['status'] == 1) {
					$data['message_display'] = 'Nothing update';
					$this->load->view('add_admin', $data);
				} else {
					$data['message_display'] = 'Update success';
					$this->load->view('add_admin', $data);
				}
			} else {
				$data['message_display'] = 'Edit user error! '. $result['mes'];
				$this->load->view('add_admin', $data);
			}
		}
	}
	
	public function delete_user() {
		$this->form_validation->set_rules('id', 'ID', 'required');
		if ($this->form_validation->run() == FALSE) {
			$this->load->view('admin_management');
		} else {
			$result = $this->admin_model->delete_user($this->input->post('id'));
			if ($result == TRUE) {
					$data['message_display'] = 'Delete user Successfully !';
					$this->load->view('admin_management', $data);
			} else {
				$data['message_display'] = "Detete user fail !" ;
				$this->load->view('admin_management', $data);
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