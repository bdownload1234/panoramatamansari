<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Password extends CI_Controller {
    var $data_ref = array('uri_controllers' => 'password');
    
    public function __construct()
	{
		parent::__construct();
		
		check_login();
	}
	
	public function index()
	{
		$user_data['data_ref'] = $this->data_ref;
		$user_data['title'] = 'Password';
		$id = $this->encryption->decrypt($this->session->userdata('id'));
		$user_data['pengguna'] = $this->db->query("SELECT * FROM users WHERE id=$id")->result_array();
// 		var_dump($user_data);
// 		exit();

		$this->load->view('template/header');
		$this->load->view('view',$user_data);
	}
	
	public function ubah()
	{
	    
	    $password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
	    $this->db->update('users', [
	        'password' => $password,
        ], array('id' => $this->input->post('id')));
        
        echo json_encode(array("status" => TRUE));
	}
}