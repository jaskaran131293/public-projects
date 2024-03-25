<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

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
		$this->load->model('RegisterModel');
    } 
	
	public function index()
	{
		
		$this->load->helper('form');
		$data=array();
		
		if($this->input->post('register_seller')=='register_seller')
		{
			
			$data['full_name']=$this->input->post('full_name');
			$data['email']=$this->input->post('email');
			$data['password']=$this->input->post('password');
			$data['phone_number']=$this->input->post('phone_number');
			$data['country']=$this->input->post('country');
			
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[seller_register.seller_email]');
			if($this->form_validation->run()== FALSE){
				//add flash data 
         		$this->session->set_flashdata('success_msg','Email Already Exsist..!!!'); 
			}else{
				$this->load->model('RegisterModel');
				$seller_m=$this->RegisterModel->insert_seller($data);

				if($seller_m==true)
				{
					//add flash data 
					$this->session->set_flashdata('success_msg','Your account is details are sent for the approvel to admin.When Admin approved then you can able to login!!');
										
					$this->email->from('your@example.com', 'Your Name');
					$this->email->to('jaskaran.geektech@gmail.com');

					$this->email->subject('Email Test');
					$this->email->message('Testing the email class.');
					
					//Send mail 
					if($this->email->send()) 
					$this->session->set_flashdata("email_sent","Email sent successfully."); 
					else 
					show_error($this->email->print_debugger());
					//$this->session->set_flashdata("email_sent","Error in sending Email."); 
									
				}
			}
			
			
						
		}
				
		$this->load->view('templates/header-inner');
		$this->load->view('register',$data);
		$this->load->view('templates/footer');
	}
	
	// Logout from seller page

	
}
