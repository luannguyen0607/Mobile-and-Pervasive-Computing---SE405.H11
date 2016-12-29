<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setting_model extends CI_Model
{	

	public function get_all_setting() {
		$this->db->select('*');
		$this->db->from('setting'); 
		$query = $this->db->get();
		return $result = $query->result_array();
	}
	
	public function get_setting($key = "") {
		$this->db->select('*');
		$this->db->from('setting');
		$this->db->where('setting_key', $key);
		$query = $this->db->get();
		if ($query->num_rows() == 1) {
			return $result = $query->result_array()[0]['value'];
		}
		return "";
	}
	
	public function update_setting($key, $value) {
		$this->db->where('setting_key', $key);
        $query = $this->db->update('setting', array('value' => $value));
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}	
	}
}