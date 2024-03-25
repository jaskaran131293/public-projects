<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

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
		$this->load->helper(array('form', 'url'));
		$this->load->library(array('session', 'form_validation', 'email')); 
		$this->load->database();
		$this->load->model('LoginModel');
    } 
	
	public function index()
	{
		
		$this->load->helper('form');
		$data=array();
		
		if($this->input->post('login_seller')=='login_seller')
		{
			
			
			$data['email']=$this->input->post('email');
			$data['password']=$this->input->post('password');
					
				$this->load->model('LoginModel');
				$seller_m=$this->LoginModel->check_seller($data);
						
				if($seller_m == 'recordmatch')
				{	
					$email = $this->input->post('email');
					$result = $this->LoginModel->read_user_information($email);
						
					if ($result != false) 
					{
						$session_data = $result[0];
						// Add user data in session
						$this->session->set_userdata('logged_in', $session_data);
					    //$this->session->set_flashdata('logged_in',$session_data);
						redirect('/SellerDashboard');
					}
					
					
				}elseif($seller_m == 'erroremail' ){
					//add flash data 
					$this->session->set_flashdata('suc_msg','Email Not Exsist..!!');
					$this->load->view('templates/header-inner');
					$this->load->view('register',$data);
					$this->load->view('templates/footer');
				}elseif($seller_m == 'wrongpass'){
					//add flash data 
					$this->session->set_flashdata('suc_msg','Wrong Password..!!');
					$this->load->view('templates/header-inner');
					$this->load->view('register',$data);
					$this->load->view('templates/footer');
				}
		}
		else
		{
		
		    $this->load->view('templates/header-inner');
			$this->load->view('register',$data);
			$this->load->view('templates/footer');
		}
	}
	
	
	

	
}
