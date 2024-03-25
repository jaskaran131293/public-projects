<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RegisterModel extends CI_Model 
{
   function __construct()
   {
        // Call the Model constructor
        parent::__construct();
	    $this->load->database();
	    $this->load->helper('date');
	 	$this->load->library('session');
   }
   Public function insert_seller($data)
   {
	  $active=1;
	  $sql = "INSERT INTO seller_register (seller_id, seller_full_name, seller_email, seller_password, seller_phone, seller_country, seller_status) VALUES ('',".$this->db->escape($data['full_name']).", ".$this->db->escape($data['email']).",".$this->db->escape($data['password']).",".$this->db->escape($data['phone_number']).",".$this->db->escape($data['country']).",".$active.")";
	  $this->db->query($sql);  
	   return true;
   }
}

