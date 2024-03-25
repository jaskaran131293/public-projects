<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SellerModel extends CI_Model 
{
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
		$this->load->database();
		$this->load->helper('date');
		$this->load->library('session');
		$this->load->library('upload');
	}
	

/*********************** Seller Profile Start**************************/
	
/* Get Seller/User Data Start */
	Public function Get_seller_profile($data)
	{
		$this->db->select('*');

		$this->db->from('seller_register');

		$seller_id = $data->seller_id;

		$this->db->where("seller_id='$seller_id'");

		$query = $this->db->get();

		if ( $query->num_rows() > 0 )
		{	
			return $query->result_array();
		}
	}
/* Get Seller/User Data Start */

/* Update Seller/User Data Start */
	Public function Update_seller_profile($data)
	{	
		if(!empty($data['seller_password_new'])){
			$newpassword = $data['seller_password_new'];
		}else{
			$newpassword = $data['seller_password'];
		}


		if(!empty($data['seller_image_new'])){
			$seller_image = $data['seller_image_new'];
		}elseif ($data['seller_image']) {
			$seller_image = $data['seller_image'];
		}

		$update_data_query = array(
			'seller_full_name' => $data['seller_full_name'],
			'seller_email' => $data['seller_email'],
			'seller_phone' => $data['seller_phone'],
			'seller_country' => $data['seller_country'],
			'seller_password' => $newpassword,
			'seller_image' => $seller_image,
		);
		//echo '<pre>'; print_r($data); echo '</pre>';die("sellerdashboardAddSellerData");
		$this->db->where('seller_id', $data['seller_id']);
		$updatesellerdata = $this->db->update('seller_register',$update_data_query);

		return true;
	}
/* Update Seller/User Data Start */

/* Add Seller Payment Data Start */
	Public function Update_seller_payment($data){
		
		if(!empty($data['card_number'])){
			$card_detail = $data['card_number'].', '.$data['card_holdername'].', '.$data['card_name'].', '.$data['selectMonth'].'-'.$data['selectYear'].', '.$data['card_cvv'];
		}else{
			$card_detail = '';
		}
		if(!empty($data['paypal_address'])){
			$paypal_address = $data['paypal_address'];
		}else{
			$paypal_address = '';
		}


		if(isset($data['update']) && $data['update'] == 'delete_paypal'){
			$update_data_query = array(
				'seller_paypal_address' => null,
			);

			$this->db->where('seller_id', $data['seller_id']);
			$updatesellerdata = $this->db->update('seller_register',$update_data_query);

			return true;
		}elseif(isset($data['update']) && $data['update'] == 'delete_card'){
			$update_data_query = array(
				'seller_card_details' => null,
			);

			$this->db->where('seller_id', $data['seller_id']);
			$updatesellerdata = $this->db->update('seller_register',$update_data_query);

			return true;
		}

		$update_data_query = array(
			'seller_card_details' => $card_detail,
			'seller_paypal_address' => $paypal_address,
		);

		$this->db->where('seller_id', $data['seller_id']);
		$updatesellerdata = $this->db->update('seller_register',$update_data_query);

		return true;
	}
/* Add Seller Payment Data Start */


/*********************** Seller Profile End**************************/


/* Add Seller Plan list Data Start */
	Public function Add_seller_data($data)
	{	
				
		$plan_date = $data['plan_date'];
		$plan_place = $data['plan_place'];
		$plan_website = $data['plan_website'];
		
		$i=min(array_keys($plan_date));
		foreach($plan_place as $k=>$val)
		{
			if(array_key_exists($k,$plan_date))
			{
			$plan_date[$k].=', '.$val;
			}

		}
		
		$i=min(array_keys($plan_date));
		foreach($plan_website as $k=>$val)
		{
			if(array_key_exists($k,$plan_date))
			{
			$plan_date[$k].=', '.$val;
			}

		}
			
		$serialized_plan_details = base64_encode(serialize($plan_date)); 
		
		$add_data_query = array(
			'plan_name' => $data['seller_plan_name'],
			'seller_id' => $data['seller_id'],
			'plan_summary' => $data['plan_summary'],
			'plan_image' => $data['plan_image'],
			'plan_details' => $serialized_plan_details,
		);
		
		$addsellerdata = $this->db->insert('add_seller_detail',$add_data_query);

		return true;
	}
/* Add Seller Plan list Data End */
	
/* Update Seller Plan list Data Start */
	Public function Update_seller_data($data)
	{	
		
	
		$plan_date = $data['plan_date'];
		$plan_place = $data['plan_place'];
		$plan_website = $data['plan_website'];
		
		$i=min(array_keys($plan_date));
		foreach($plan_place as $k=>$val)
		{
			if(array_key_exists($k,$plan_date))
			{
			$plan_date[$k].=', '.$val;
			}

		}
		
		$i=min(array_keys($plan_date));
		foreach($plan_website as $k=>$val)
		{
			if(array_key_exists($k,$plan_date))
			{
			$plan_date[$k].=', '.$val;
			}

		}
			
		$serialized_plan_details = base64_encode(serialize($plan_date)); 
		
		$update_data_query = array(
			'plan_name' => $data['seller_plan_name'],
			'seller_id' => $data['seller_id'],
			'plan_summary' => $data['plan_summary'],
			'plan_image' => $data['plan_image'],
			'plan_details' => $serialized_plan_details,
		);
		//echo '<pre>'; print_r($data); echo '</pre>';die("sellerdashboardAddSellerData");
		$this->db->where('seller_plan_id', $data['seller_plan_id']);
		$updatesellerdata = $this->db->update('add_seller_detail',$update_data_query);

		return true;
	}
/* Update Seller Plan list Data End */
	
/* Get Seller Plan list Data Start */
	Public function Get_seller_data($us_data) {
		
		$this->db->select('*');

		$this->db->from('add_seller_detail');

		$this->db->where("seller_id='$us_data->seller_id'");

		$query = $this->db->get();
				
		return($query->num_rows() > 0) ? $query->result(): NULL;
    }
/* Get Seller Plan list Data End */

/* Get Seller Plan list Data By id Start */
	Public function Get_seller_list_by_id($data) {
		
		$this->db->select('*');

		$this->db->from('add_seller_detail');

		$this->db->where("seller_plan_id='$data'");

		$query = $this->db->get();
				
		return($query->num_rows() > 0) ? $query->result(): NULL;
    }
/* Get Seller Plan list Data By id End */

/* Delete Seller Plan list Data By id Start */
	Public function Del_seller_list_by_id($data) {
		
		$this->db->where('seller_plan_id', $data);
		$this->db->delete('add_seller_detail');
		
		return true;
    }	
/* Delete Seller Plan list Data By id En */
}

