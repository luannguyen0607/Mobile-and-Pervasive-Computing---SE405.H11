<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_song_model extends CI_Model
{	

	public function get_user_song_by_user_id($id) {
		//SELECT a.*, b.song_name, b.singer_name FROM `user_song` a INNER JOIN `song` b on a.song_id = b.id WHERE a.user_id = 2
		$this->db->select('a.*, b.song_name, b.singer_name');
		$this->db->from('user_song a'); 
		$this->db->join('song b', 'a.song_id = b.id', 'INNER');
		$this->db->where("user_id = '". $id . "'");
		$query = $this->db->get();
		return $result = $query->result_array();
	}
	
	public function get_user_song_by_song_id($id) {
		//SELECT a.*, b.song_name, b.singer_name FROM `user_song` a INNER JOIN `song` b on a.song_id = b.id WHERE a.user_id = 2
		$this->db->select('a.*, b.username, b.name, b.email, b.address');
		$this->db->from('user_song a'); 
		$this->db->join('client b', 'a.user_id = b.id', 'INNER');
		$this->db->where("song_id = '". $id . "'");
		$query = $this->db->get();
		return $result = $query->result_array();
	}
	
	public function get_all_song() {
		$this->db->select('*');
		$this->db->from('song');
		$query = $this->db->get();
		return $result = $query->result_array();
	}
	
	public function get_song($id) {
		$this->db->select('*');
		$this->db->from('song');
		$this->db->where("id = '". $id . "'");
		$query = $this->db->get();

		if ($query->num_rows() == 1) {
			$result = $query->result_array()[0];
			return $result;
		} else {
			return "";
		}
	}
	
	public function count_user_song($song_id) {
		$this->db->select('count(*) as song_count');
		$this->db->from('user_song');
		$this->db->where("song_id = '". $song_id . "'");
		$query = $this->db->get();
		if ($query->num_rows() == 1) {
			$result = $query->result()[0]->song_count;
		}
		return $result;
	}
	
	public function add_new_song($data) {
		$this->db->insert('song', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function add_new_user_song($user_id, $song_id) {
		$data = array('user_id' => $user_id, 'song_id' => $song_id);
		$this->db->insert('user_song', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}			
	}
	
	public function update_song($id, $data) {
		$this->db->where('id', $id);
        $query = $this->db->update('song', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}	
	}
	
	public function delete_song($id) {
		$this->db->where('id', $id);
        $query = $this->db->delete('song');
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function delete_user_song($song_id, $user_id) {
		$this->db->where("song_id = '". $song_id ."' and user_id = '". $user_id . "'");
        $query = $this->db->delete('user_song');
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function get_language() {
		$this->db->select('*');
		$this->db->from('language');
		$query = $this->db->get();
		return $result = $query->result_array();
	}
	
	public function get_song_type() {
		$this->db->select('*');
		$this->db->from('song_type');
		$query = $this->db->get();
		return $result = $query->result_array();
	}
	
	public function get_singer_class() {
		$this->db->select('*');
		$this->db->from('singer_class');
		$query = $this->db->get();
		return $result = $query->result_array();
	}
	
	public function update_user_song($song_id, $new_lists) {
		$this->db->select('user_id');
		$this->db->from('user_song');
		$this->db->where('song_id', $song_id);
		$query = $this->db->get();
		$results = $query->result_array();
		$old_lists = array();
		foreach ($results as $result) {
			$old_lists[] = 	$result['user_id'];		
		}
		$deletes = array_diff($old_lists, $new_lists);
		$adds = array_diff($new_lists, $old_lists);
		// print_r($deletes);
		// print_r($adds);
		
		$re = 0;
		foreach ($deletes as $delete) {
			if (!$this->delete_user_song($song_id, $delete));
				$re = 1;
		}
		
		foreach ($adds as $add) {
			if (!$this->add_new_user_song($add, $song_id))
				$re = 2;
		}
		
		return $re;
	}
	
	public function update_song_user($user_id, $new_lists) {
		$this->db->select('song_id');
		$this->db->from('user_song');
		$this->db->where('user_id', $user_id);
		$query = $this->db->get();
		$results = $query->result_array();
		$old_lists = array();
		foreach ($results as $result) {
			$old_lists[] = 	$result['song_id'];		
		}
		$deletes = array_diff($old_lists, $new_lists);
		$adds = array_diff($new_lists, $old_lists);
		// print_r($deletes);
		// print_r($adds);
		$re = 0;
		foreach ($deletes as $delete) {
			if (!$this->delete_user_song($delete, $user_id));
				$re = 1;
		}
		
		foreach ($adds as $add) {
			if (!$this->add_new_user_song($user_id, $add))
				$re = 2;
		}
		
		return $re;
	}
}