<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Beranda extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		// cek apakah halaman depan diaktifkan
		if(konf()['front_page'] == '1'){
			$data=array();
			$data['konfig']	= $this->db->query("SELECT * FROM konfigurasi WHERE id='1'")->row_array();
			$data['jumbotron']	= $this->db->query("SELECT * FROM konten WHERE nama_section='jumbotron'")->row_array();
			$data['profil']	= $this->db->query("SELECT * FROM konten WHERE nama_section='profil'")->row_array();
			$data['fasilitas']	= $this->db->query("SELECT * FROM konten WHERE nama_section='fasilitas'")->row_array();
			$data['denah']	= $this->db->query("SELECT * FROM konten WHERE nama_section='denah'")->row_array();
			$data['marketing']	= $this->db->query("SELECT * FROM konten WHERE nama_section='marketing'")->row_array();
			$this->load->view('beranda',$data);
		}else{
			redirect('login');
		}
	}


	public function ajax_edit($id)
	{
		$data = $this->db->query("SELECT * FROM kavling_peta a 
			LEFT JOIN customer b ON a.id_customer = b.id_customer 
			LEFT JOIN marketing c ON a.id_marketing = c.id_marketing 
			LEFT JOIN transaksi_kavling d ON a.id_kavling = d.id_kavling 
			WHERE a.id_kavling = '$id' ")->row_array();
			$data['hrg_jual'] = rupiah($data['hrg_jual']);
			// $data['acc_bank'] = rupiah($data['acc_bank']);
		echo json_encode($data);
	}
	

}