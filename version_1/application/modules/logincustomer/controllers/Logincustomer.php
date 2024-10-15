<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logincustomer extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('form_validation'));	
	}
	
	public function index()
	{
		$data=array();
		$csrf = array(
		        'name' => $this->security->get_csrf_token_name(),
		        'hash' => $this->security->get_csrf_hash()
		    );
		$data=array('csrf'=>$csrf);	
		// cek apakah sudah login
		if($this->session->userdata('email_customer') == '') {
			$this->load->view('login_customer');
		}else{
			redirect('dashboard_customer');
		}
		
	}



	public function login(){
		$this->load->library(array('auth'));	

		if($this->auth->loginByEmail($this->input->post('email'),$this->input->post('pass'))){

			redirect('dashboardcustomer','refresh');
		}else{
			// echo "salah";
			redirect('logincustomer');	
		}	

	}

	public function _validasiFormLogin(){
        $this->form_validation->set_rules('username', 'Username', 'required',
                array('required' => ' %s Harus Di isi.')
        );

        $this->form_validation->set_rules('password', 'Password', 'required',
                array('required' => ' %s Harus Di isi.')
        );
        if ($this->form_validation->run() == FALSE)
        {
                return false;
        }
        else
        {
                return true;
        }

	}

	function logout(){
		//$this->CI->userdb->updateLogout($this->CI->encryption->decrypt($this->CI->session->id));	

		session_unset(); 		
		$this->session->sess_destroy();		
		redirect('logincustomer');
	}


}