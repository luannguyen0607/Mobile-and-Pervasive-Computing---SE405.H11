<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Client_model extends CI_Model
{	
	// Read data from database to show data in admin page
	public function get_list_user() {
		$this->db->select('*');
		$this->db->from('client');
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			// foreach ($result as $re) {
				// $re = json_decode(json_encode($re), True);
				// echo json_encode($re);
				// $re->createProperty('song_count', 'something');
				// $re = (object)(array)$reơ'song_count' => '1234' ) );
				// $re['song_count'] = $this->count_user_song($re['id']);
			// }
			// echo json_encode($result);
			return $result;
		} else {
			return false;
		}
	}
	
	public function get_user($id) {
		$this->db->select('*');
		$this->db->from('client');
		$this->db->where("id = '". $id . "'");
		$query = $this->db->get();

		if ($query->num_rows() == 1) {
			$result = $query->result_array()[0];
			return $result;
		} else {
			return "";
		}
	}
	
	public function count_user_song($user_id) {
		$this->db->select('count(*) as song_count');
		$this->db->from('user_song');
		$this->db->where("user_id = '". $user_id . "'");
		$query = $this->db->get();
		if ($query->num_rows() == 1) {
			$result = $query->result()[0]->song_count;
		}
		return $result;
	}
	
	public function add_new_user($data) {
		$condition = "username ='" . $data['username'] . "' or email='" . $data['email'] . "'";
		$this->db->select('*');
		$this->db->from('client');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		if ($query->num_rows() == 0) {
			// Query to insert data in database
			$this->db->insert('client', $data);
			if ($this->db->affected_rows() > 0) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}		
	}
	
	public function update_user($id, $data) {
		$result = array('status' => 0, 'mes' => 'Update complete');
		
		if (!$this->check_dup($id, $data['username'], $data['email'])) {
			$result['status'] = 2;
			$result['mes'] = 'Email already exist!';
			return $result;
		}
		$this->db->trans_start();
		$this->db->where('id', $id);
        $query = $this->db->update('client', $data);
		$affected_rows =  $this->db->affected_rows();
		$this->db->trans_complete();
		if ($affected_rows <= 0) {
			if ($this->db->trans_status() === FALSE) {
				$result['status'] = 2;
				$error = $this->db->error();
				$result['mes'] = $error['message'];
			} else {
				$result['status'] = 1;
				$result['mes'] = "No row update!";
			}
		}
		return $result;
	}
	
	public function check_dup($id, $username, $email) {
		$condition = "(username ='" . $username . "' or email='" . $email . "') and id <> '" .$id ."'";
		$this->db->select('*');
		$this->db->from('client');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		// echo $this->db->last_query();
		if ($query->num_rows() == 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function delete_user($id) {
		$this->db->where('id', $id);
        $query = $this->db->delete('client');
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}	
	}
	
	public function get_id($username) {
		$this->db->select('id');
		$this->db->from('client');
		$this->db->where("username = '". $username . "'");
		$query = $this->db->get();

		if ($query->num_rows() == 1) {
			$result = $query->result_array()[0]['id'];
			return $result;
		} else {
			return "";
		}
	}
}