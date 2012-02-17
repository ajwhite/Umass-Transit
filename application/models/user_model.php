<?php

class User_model extends CI_Model
{
	function __construct(){
		parent::__construct();
	}
	
	
	// do a quick login, no auth for the proto
	function login($userID){
		$this->db->where('userID', $userID);
		$query = $this->db->get('User');
		$row = null;
		if ($query->num_rows() > 0){
			$result = $query->result();
			$row = $result[0];
			$this->session->set_userdata(array(
				'id'   => $row->userID,
				'name' => $row->name
			));
			return true;
		}
		return false;
	}
	
	function loggedIn(){
		$userID = $this->session->userdata('id');
		return (strlen($userID)>0) ? true : false;
	}
}
