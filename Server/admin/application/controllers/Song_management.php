<?php

//session_start(); //we need to start session in order to access it through CI

Class Song_management extends CI_Controller {

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
		
		$this->load->model('client_model');
		
		$this->load->model('login_database');

		$this->load->helper('url');
	}

	// Show login page
	public function index() {
		$this->load->view('song_management');
	}
	
	public function add_new_song() {
		$this->form_validation->set_rules('url', 'Song url', 'required');
		$this->form_validation->set_rules('song_name', 'Song name', 'required');
		$this->form_validation->set_rules('lang_code', 'Song language', 'trim|required');
		$this->form_validation->set_rules('singer_class', 'Singer class', 'trim|required');
		$this->form_validation->set_rules('song_type', 'Song type', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			// echo validation_errors();
			$this->load->view('add_song');
		} else {
			$data = array(
				'url' => $this->input->post('url'),
				'song_name' => $this->input->post('song_name'),
				'song_position' => $this->input->post('song_position'),
				'singer_name' => $this->input->post('singer_name'),
				'name_count' => $this->input->post('name_count'),
				'lang_code' => $this->input->post('lang_code'),
				'song_volume' => $this->input->post('song_volume'),
				'name_spell' => $this->input->post('name_spell'),
				'singer_spell' => $this->input->post('singer_spell'),
				'singer_class' => $this->input->post('singer_class'),
				'song_type' => $this->input->post('song_type'),
				'album_name' => $this->input->post('album_name'),
				'album_spell' => $this->input->post('album_spell'),
				'singer_photo' => $this->input->post('singer_photo'),
				'song_lyric' => $this->input->post('song_lyric'),
				'owner_id' => $this->session->userdata['logged_in']['id'],
			);
			$result = $this->user_song_model->add_new_song($data);
			if ($result == TRUE) {
				$data['message_display'] = 'Add song Successfully !';
				$this->load->view('song_management', $data);
			} else {
				$data['message_display'] = "Can't add song !";
				$this->load->view('add_song', $data);
			}
		}
	}

	public function edit_song($id = "") {
		$this->form_validation->set_rules('url', 'Song url', 'required');
		$this->form_validation->set_rules('song_name', 'Song name', 'required');
		$this->form_validation->set_rules('lang_code', 'Song language', 'trim|required');
		$this->form_validation->set_rules('singer_class', 'Singer class', 'trim|required');
		$this->form_validation->set_rules('song_type', 'Song type', 'trim|required');
		$data = array('id' => $id);
		if ($this->form_validation->run() == FALSE) {
			$this->load->view('add_song', $data);
		} else {
			$data['url'] = $this->input->post('url');
			$data['song_name'] = $this->input->post('song_name');
			$data['song_position'] = $this->input->post('song_position');
			$data['singer_name'] = $this->input->post('singer_name');
			$data['name_count'] = $this->input->post('name_count');
			$data['lang_code'] = $this->input->post('lang_code');
			$data['song_volume'] = $this->input->post('song_volume');
			$data['name_spell'] = $this->input->post('name_spell');
			$data['singer_spell'] = $this->input->post('singer_spell');
			$data['singer_class'] = $this->input->post('singer_class');
			$data['song_type'] = $this->input->post('song_type');
			$data['album_name'] = $this->input->post('album_name');
			$data['album_spell'] = $this->input->post('album_spell');
			$data['singer_photo'] = $this->input->post('singer_photo');
			$data['song_lyric'] = $this->input->post('song_lyric');
			$result = $this->user_song_model->update_song($id, $data);
			if ($result) {
				$data['message_display'] = 'Upload success! ';
				$this->load->view('add_song', $data);
			} else {
				$data['message_display'] = 'Nothing update! ';
				$this->load->view('add_song', $data);
			}
		}
	}
	
	public function delete_song() {
		$this->form_validation->set_rules('id', 'ID', 'required');
		if ($this->form_validation->run() == FALSE) {
			$this->load->view('song_management');
		} else {
			$result = $this->user_song_model->delete_song($this->input->post('id'));
			if ($result == TRUE) {
					$data['message_display'] = 'Delete song Successfully !';
					$this->load->view('song_management', $data);
			} else {
				$data['message_display'] = "Detete user fail !" ;
				$this->load->view('song_management', $data);
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
			$result = $this->user_song_model->update_user_song($id, $newlists);
			if ($result != 0) {
				$data['message_display'] = "Update user song fail !" ;
			} else {
				$data['message_display'] = "Update user song success !" ;
			}
			redirect('/song_management/edit_song/'. $id);
		} else {
			redirect('/song_management');
		}
		
	}	
}

?>