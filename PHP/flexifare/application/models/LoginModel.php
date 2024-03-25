<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LoginModel extends CI_Model 
{
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
		$this->load->database();
		$this->load->helper('date');
		$this->load->library('session');
	}
	
	/*********************Seller Login Start**************************/
	Public function check_seller($data)
	{

		$this->db->select('*');

		$this->db->from('seller_register');

		$email = $data['email'];
		$seller_password =  $data['password'];

		$this->db->where("seller_email='$email'");

		$query = $this->db->get();
		
		if ( $query->num_rows() > 0 )
		{	
			$this->db->select('*');

			$this->db->from('seller_register');
			$where = "seller_email='$email' AND seller_password='$seller_password' ";
			$this->db->where($where);
			$query = $this->db->get();
			
			if ( $query->num_rows() > 0 )
			{	
				$error = 'recordmatch';
				return $error;
			}else{
				$error = 'wrongpass';
				return $error;
			}
		}else{
			$error = 'erroremail';
			return $error;
		}
	}
	
	// Read data from database to show data in admin page
	public function read_user_information($email) {

		$condition = "seller_email =" . "'" . $email . "'";
		$this->db->select('*');
		$this->db->from('seller_register');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();

		if ($query->num_rows() == 1) {
		return $query->result();
		} else {
		return false;
		}
	}
	/*********************Seller Login End**************************/
	
	/*********************Admin Login Start**************************/
	Public function check_admin($data)
	{

		$this->db->select('*');

		$this->db->from('admin_details');

		$username = $data['username'];
		$password =  $data['password'];

		$where = "username='$username' AND password='$password' ";

		$this->db->where($where);


		$query = $this->db->get();

		if ( $query->num_rows() > 0 )
		{
		$row = $query->row_array();
		return true;
		}
	}
	/*********************Admin Login End**************************/
	
	
}

