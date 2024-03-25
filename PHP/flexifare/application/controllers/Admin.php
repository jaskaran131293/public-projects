<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

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
			
			
			$data['username']=$this->input->post('username');
			$data['password']=$this->input->post('password');
					
				$this->load->model('LoginModel');
				$seller_m=$this->LoginModel->check_admin($data);
				
				if($seller_m==true)
				{
					//add flash data 
					$this->session->set_flashdata('suc_msg','Successful Login..!!');
					
				}else{
					//add flash data 
					$this->session->set_flashdata('suc_msg','Login Failed..!!');
				}
			}
		
		
		$this->load->view('templates/header-inner');
		$this->load->view('admin',$data);
		$this->load->view('templates/footer');
	}
	
}
