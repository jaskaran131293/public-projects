<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SellerDashboard extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	
	function __Construct(){
		parent::__Construct();
		
		$data=array();
		//$this->session->userdata['logged_in'] /****contain all values****/
		if($this->session->userdata('logged_in')){
	 		$data['session_data']=$this->session->userdata['logged_in']->seller_full_name;
	 		$data['session_image']=$this->session->userdata['logged_in']->seller_image;
		}else{
			redirect('Register');
		}
		
		$this->load->view('templates/header-seller',$data);
		
		$this->load->helper(array('form', 'url'));
		$this->load->library(array('session', 'form_validation', 'email')); 
		$this->load->database();
		
    } 
	
	public function index()
	{		
			$us_data = $this->session->userdata('logged_in');
			$this->load->model('SellerModel');
			$data['get_seller_data'] = $this->SellerModel->Get_seller_data($us_data);
		  			
		  	$this->load->view('seller-dashboard', $data);
		  	$this->load->view('templates/footer-seller');
	}


/*********************** Seller Profile Start**************************/

/* Get Seller Profile Data Start */
	public function SellerProfile()
	{		
			$us_data = $this->session->userdata('logged_in');
			$this->load->model('SellerModel');
			$data['get_seller_user_data'] = $this->SellerModel->Get_seller_profile($us_data);
		  		
		  	$this->load->view('seller-profile', $data);
		  	$this->load->view('templates/footer-seller');
	}
/* Get Seller Profile Data End */

/* Update Seller Profile Data Start */
	public function UpdateSellerProfile()
	{		
			$data = $_REQUEST;
			if($_FILES['seller_image_new']['error'] == 0){
				$config['upload_path'] 			= './uploads/'; 
				$config['allowed_types']        = 'gif|jpg|png';

				$this->load->library('upload', $config);

				if ( ! $this->upload->do_upload('seller_image_new')){
					$error = array('error' => $this->upload->display_errors());

					$this->session->set_flashdata('suc_msg',$error['error']);
		  			redirect('SellerDashboard/SellerProfile'); 
				} else{
					$upload_data = array('upload_data' => $this->upload->data());

					$data['seller_image'] = $upload_data['upload_data']['file_name'];

					$this->load->model('SellerModel');
					$data = $this->SellerModel->Update_seller_profile($data);
			  		
			  		if($data == true){
			  			$this->session->set_flashdata('suc_msg','Data Successfully Updated..!!');
			  			redirect('SellerDashboard/SellerProfile'); 
			  		}else{
			  			$this->session->set_flashdata('suc_msg','Data Not Update..!!');
			  			redirect('SellerDashboard/SellerProfile'); 
			  		}
				}
			}else{
				$data['seller_image'] = $data['seller_image'];
				$this->load->model('SellerModel');
				$data = $this->SellerModel->Update_seller_profile($data);
		  		
		  		if($data == true){
		  			$this->session->set_flashdata('suc_msg','Data Successfully Updated..!!');
		  			redirect('SellerDashboard/SellerProfile'); 
		  		}else{
		  			$this->session->set_flashdata('suc_msg','Data Not Update..!!');
		  			redirect('SellerDashboard/SellerProfile'); 
		  		}
			}


		  	
	}
/* Update Seller Profile Data End */

/* Add Seller Payment Data Start */

	public function UpdateSellerPayment()
	{	

		if(isset($_REQUEST['seller_id'])){

			$this->load->model('SellerModel');
			$update_data = $this->SellerModel->Update_seller_payment($_REQUEST);		
			if($update_data == true){
				$this->session->set_flashdata("suc_msg","Payment Successfully Added..!!!");
				redirect('SellerDashboard/UpdateSellerPayment'); 
			}else{
				$this->session->set_flashdata("suc_msg","Payment Not Added!!!");
				redirect('SellerDashboard/UpdateSellerPayment'); 
			}
			
		}

		if(isset($_REQUEST['update'])){


			$this->load->model('SellerModel');
			$update_data = $this->SellerModel->Update_seller_payment($_REQUEST);		
			if($update_data == true){
				$this->session->set_flashdata("suc_msg","Delete Record..!!!");
				redirect('SellerDashboard/UpdateSellerPayment'); 
			}else{
				$this->session->set_flashdata("suc_msg","Not Deleted!!!");
				redirect('SellerDashboard/UpdateSellerPayment'); 
			}
			
		}
				
		$us_data = $this->session->userdata('logged_in');
		$this->load->model('SellerModel');
		$data['get_seller_user_data'] = $this->SellerModel->Get_seller_profile($us_data);
	  		
		
		$this->load->view('seller-payment', $data);
		$this->load->view('templates/footer-seller');
		
	}
/* Add Seller Payment Data Start */
/*********************** Seller Profile End**************************/



/*********************** Seller List Data Start**************************/
/* Get Seller Plan List Data by Id Start */
	public function AddSellerPlan() 
	{	
		if(isset($_REQUEST['seller_plan_id'])){
			
			$this->load->model('SellerModel');
			$data['Get_seller_list_by_id'] = $this->SellerModel->Get_seller_list_by_id($_REQUEST['seller_plan_id']);
			
			$this->load->view('seller-add-plan', $data);
			$this->load->view('templates/footer-seller');
		}else{		 
			$this->load->view('seller-add-plan');
			$this->load->view('templates/footer-seller');
		}
	}
/* Get Seller Plan List Data by Id End */

/* Delete Seller Plan List Data Start */
	public function DeleteSellerPlan()
	{	
			$this->load->model('SellerModel');
			$data = $this->SellerModel->Del_seller_list_by_id($_REQUEST['seller_plan_id']);
			 
			redirect('SellerDashboard'); 
	}
/* Delete Seller Plan List Data End */

/* Add Seller Plan List Data Start */
	public function AddSellerData()
	{
	 	$data = $_REQUEST;
				
		$config['upload_path'] 			= './uploads/'; 
		$config['allowed_types']        = 'gif|jpg|png';
		
		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('plan_image')){
			$error = array('error' => $this->upload->display_errors());
			$this->load->view('seller-add-plan', $error); 
		} else{
			$upload_data = array('upload_data' => $this->upload->data());
			
			$data['plan_image'] = $upload_data['upload_data']['file_name'];
			
			$this->load->model('SellerModel');
			$add_seller_data = $this->SellerModel->Add_seller_data($data);

			if($add_seller_data == true){
				redirect('SellerDashboard'); 
			}
		}
				
	  	
	}
/* Add Seller Plan List Data End */
	
/* Update Seller Plan List Data Start */
	public function UpdateSellerData()
	{
	 	$data = $_REQUEST;
		
		if($_FILES['plan_image']['error'] == 0){
			$config['upload_path'] 			= './uploads/'; 
			$config['allowed_types']        = 'gif|jpg|png';

			$this->load->library('upload', $config);

			if ( ! $this->upload->do_upload('plan_image')){
				$error = array('error' => $this->upload->display_errors());
				$this->load->view('seller-add-plan', $error); 
			} else{
				$upload_data = array('upload_data' => $this->upload->data());

				$data['plan_image'] = $upload_data['upload_data']['file_name'];

				$this->load->model('SellerModel');
				$add_seller_data = $this->SellerModel->Update_seller_data($data);

				if($add_seller_data == true){
					redirect('SellerDashboard'); 
				}
			}
		}else{
			$data['plan_image'] = $data['hiden_plan_image'];
			//echo '<pre>'; print_r($data); echo '</pre>';die("sellerdashboardAddSellerData");
			$this->load->model('SellerModel');
			$add_seller_data = $this->SellerModel->Update_seller_data($data);

			if($add_seller_data == true){
				redirect('SellerDashboard'); 
			}
		}
	}
/* Update Seller Plan List Data Start */

/*********************** Seller List Data End**************************/

/* Logout Seller/User Start */
	public function logout() 
	{

		$sess_array = array('username' => '');
		$this->session->unset_userdata('logged_in', $sess_array);
		$this->session->set_flashdata("suc_msg","Successfully Logout");
		redirect('Register');
	}
/* Logout Seller/User End */
	
	
	
}
