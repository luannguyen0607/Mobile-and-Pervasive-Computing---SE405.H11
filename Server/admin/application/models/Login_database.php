<?php

Class Login_database extends CI_Model {

// Insert registration data in database
	public function registration_insert($data) {

		// Query to check whether username already exist or not
		$condition = "username =" . "'" . $data['username'] . "'";
		$this->db->select('*');
		$this->db->from('admin');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		if ($query->num_rows() == 0) {
			// Query to insert data in database
			$data['password'] = md5($data['password']);
			$this->db->insert('admin', $data);
			if ($this->db->affected_rows() > 0) {
				return true;
			}
		} else {
			return false;
		}
	}

	// Read data using username and password
	public function login($data) {
		$md5 = md5($data['password']);
		$condition = "username =" . "'" . $data['username'] . "' AND " . "password =" . "'" . $md5 . "'";
		$this->db->select('*');
		$this->db->from('admin');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();

		if ($query->num_rows() == 1) {
			// $this->db->set('token', '12345');
			// $this->db->where('username', $data['username']);
			// $this->db->update('admin');
			return true;
		} else {
			return false;
		}
	}

	// Read data from database to show data in admin page
	public function read_user_information($username) {
		$condition = "username =" . "'" . $username . "'";
		$this->db->select('*');
		$this->db->from('admin');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();

		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function count_client() {
		$this->db->select('count(*) as client_count');
		$this->db->from('client');
		$query = $this->db->get();
		if ($query->num_rows() == 1) {
			$result = $query->result()[0]->client_count;
		}
		return $result;
	}
	
	public function count_song() {
		$this->db->select('count(*) as song_count');
		$this->db->from('song');
		$query = $this->db->get();
		if ($query->num_rows() == 1) {
			$result = $query->result()[0]->song_count;
		}
		return $result;
	}
	
	public function get_new_download() {
		$this->db->select('u.username, s.song_name, us.*');
		$this->db->from('user_song us'); 
		$this->db->join('client u', 'us.user_id = u.id', 'INNER');
		$this->db->join('song s', 'us.song_id = s.id', 'INNER');
		$query = $this->db->get();
		// if($query->num_rows() != 0)
		// {
			return $query->result_array();
		// }
		// else
		// {
			// return false;
		// }
	}
	
	public function get_name($id) {
		$condition = "id =" . "'" . $id . "'";
		$this->db->select('name');
		$this->db->from('admin');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		if ($query->num_rows() == 1) {
			return $query->result()[0]->name;
		}
		return "N/A";
	}
	
	public function change_pass($username, $new_pass) {
		$this->db->where('username', $username);
		$data = array('password' => md5($new_pass));
        $query = $this->db->update('admin', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}	
	}
	
	public function forgot_pass($email, $code) {
		$this->db->where('email', $email);
		$data = array('forgot_pass' => $code, 'time_forgot' => date("Y-m-d H:i:s"));
		$query = $this->db->update('admin', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function check_token($user_id, $token) {
		$condition = "id =" . "'" . $user_id . "'";
		$this->db->select('*');
		$this->db->from('admin');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		if ($query->num_rows() == 1) {
			$pass = $query->result_array()[0]['forgot_pass'];
			$time = $query->result_array()[0]['time_forgot'];
			$today = strtotime(date('Y-m-d H:i:s'));
			$reset_date = strtotime($time);
			$timeToEnd = $today - $reset_date;
			if ($timeToEnd < 3600 && $pass == $token) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	public function reset_pass($user_id, $token, $new_pass) {
		$this->db->where("id =" . "'" . $user_id . "' and forgot_pass = '". $token ."'");
		$data = array('password' => md5($new_pass), 'time_forgot' => '2000-00-00 00:00:00');
        $query = $this->db->update('admin', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}	
	}
	
	public function get_id($email) {
		$condition = "email =" . "'" . $email . "'";
		$this->db->select('id');
		$this->db->from('admin');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		if ($query->num_rows() == 1) {
			return $query->result()[0]->id;
		}
		return "N/A";
	}

}

?>