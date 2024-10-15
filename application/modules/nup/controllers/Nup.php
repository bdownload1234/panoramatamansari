<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nup extends CI_Controller {
    
    var $data_ref = array('uri_controllers' => 'nup');
    
    public function __construct()
	{
		parent::__construct();
		$this->load->model('Nup_model','nup');
		// $this->load->model('Group/Group_model','group');
		
		check_login();
	}
	
	public function index()
	{
		$user_data['data_ref'] = $this->data_ref;
		$user_data['title'] = 'NUP';
		$user_data['pengguna'] = $this->db->query("SELECT * FROM users")->result();

		$this->load->view('template/header');
		$this->load->view('view',$user_data);
	}
	
	public function ajax_list()
	{

		$list = $this->nup->get_datatables();
		$data = array();
		$no = $_POST['start'];

		foreach ($list as $post) {

			$link_edit = '<a class="btn btn-xs btn-warning" href="javascript:void(0)" onclick="edit('."'".$post->id."'".')"> Edit</a>';
			$link_jadi_spr = ' <a class="btn btn-xs btn-success" href="javascript:void(0)" onclick="buat_spr('."'".$post->id_registrasi."'".')">Jadikan SPR</a>';
			$link_hapus = ' <a class="btn btn-xs btn-danger" href="javascript:void(0)" title="Hapus" onclick="batal('."'".$post->id."'".')">Batalkan NUP</a>';
			$link_form = ' <a class="btn btn-xs btn-success" target="_blank" href="'.base_url('nup/cetak_form/'.$post->id).'">Cetak Form</a> ';
			
			$no++;
			$row = array();
         	$row[] = $no;
         	$row[] = $post->no_nup;
         	$row[] = $post->nama_lengkap;
         	$row[] = $post->kode_kavling;
         	if($post->status == 1){
         	    $status = 'NUP';
         	}else if($post->status == 0){
         	    $status = 'SPR';
         	}else if($post->status == 2){
         	    $status = 'Batal NUP';
         	}
			$row[] = $status;
			
			if($post->status == 1){
			    $row[] = $link_form.$link_jadi_spr.$link_hapus;
			}else{
			    $row[] = $link_form;
			}
			
			$data[] = $row;
		}
		$output = array(
					"draw" => $_POST['draw'],
					"recordsTotal" => $this->nup->count_all(),
					"recordsFiltered" => $this->nup->count_filtered(),
					"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	
	public function ajax_batal($id)
	{
	    $paramUpdate = [
	        'status' => 2,
        ];
		$this->nup->update(array('id' => $id), $paramUpdate);

        $data = $this->db->from('nup')->where('id', $id)->get()->row();
        $customer = $this->db->from('customer')->where('id_registrasi', $data->id_customer)->get()->row();
        $this->buat_spr($customer->id_customer);
		
		echo json_encode(array("status" => TRUE));
	}
	
	public function buat_spr($idCust ='')
	{
		date_default_timezone_set("Asia/Jakarta");
		$tanggal = date('Y-m-d');
		$jam = date('H:i:s');
		// membuat nomor spr
		$tahun = date('Y');
		$nomor = $this->db->query("SELECT MAX(nomor_spr) as besar FROM spr WHERE nomor_spr like '%$tahun'")->row_array();
		$noSekarangTRX = $nomor['besar'];
		$urutanTRX = (int) substr($noSekarangTRX, 0, 5);
		$urutanTRX++;
		$hurufTRX = "/SPR-PTS/$tahun";
		$noTraSekarang = sprintf("%05s", $urutanTRX).$hurufTRX;
		// enf nomor SPR
		// cari data Customer
		$cust = $this->db->query("SELECT * FROM customer WHERE id_registrasi = '$idCust'")->row_array();
		// Cari harga Rumah
		$lokasi = $cust['id_kavling'];
		$rumah = $this->db->query("SELECT * FROM kavling_peta WHERE id_kavling = '$lokasi'")->row_array();

		$param = array(
			'id_customer' 			=> $cust['id_customer'],
			'id_kavling' 			=> $cust['id_kavling'],
			'kode_kavling' 			=> $cust['lokasi_kavling'],
			'tipe_rumah' 			=> $cust['tipe_unit'],
			'luas_tanah' 			=> $rumah['luas_tanah'],
			'id_marketing' 			=> $cust['id_marketing'],
			'nama_marketing' 	    => $cust['nama_marketing'],
			'nama_lengkap' 			=> $cust['nama_lengkap'],
			'nik' 					=> $cust['nik'],
			'alamat_rumah' 			=> $cust['alamat'],
			'no_telp' 				=> $cust['no_telp'],
			'nama_keluarga' 		=> $cust['nama_saudara'],
			'hubungan_keluarga' 	=> $cust['hubungan_saudara'],
			'no_telp_keluarga' 		=> $cust['no_telp_saudara'],
			'no_hp_keluarga' 		=> $cust['no_telp_saudara'],
			'nama_perusahaan' 		=> $cust['nama_perusahaan'],
			'alamat_kantor' 		=> $cust['alamat_kantor'],
			'telp_kantor' 			=> $cust['telp_kantor'],
			'nomor_spr' 			=> $noTraSekarang,
			'tanggal_spr' 			=> $tanggal,
			'jam_spr' 				=> $jam,
			'harga_rumah' 			=> $rumah['harga_jual_ajb'],
			'harga_diskon' 			=> $rumah['harga_diskon'],
			'booking_fee_spr' 		=> $cust['booking_fee']
		);
		$this->db->insert('spr', $param);

		$this->db->update('customer', ['status_customer' => '2', 'nup_spr' => 1], ['id_customer' => $cust['id_customer']]);
		
		$paramUpdate = [
	        'status' => 0,
        ];
		$this->db->update('nup', ['status' => 0], ['id_customer' => $cust['id_customer']]);


		echo json_encode(array("status" => TRUE));
	}
	
	function cetak_form($id){
        // panggil library yang kita buat sebelumnya yang bernama pdfgenerator
        $this->load->library('pdfgenerator');
        
        
        $this->data['data'] = $this->db->query("SELECT a.no_nup, a.created_at, b.*, c.* 
        FROM nup a
        LEFT JOIN customer b ON a.id_customer = b.id_registrasi
        LEFT JOIN kavling_peta c ON a.id_kavling = c.id_kavling
        WHERE a.id = $id
        ")->result_array();
        
        $this->data['title_pdf'] = 'Form NUP';
        // var_dump($this->data);
        // exit;
        
        // filename dari pdf ketika didownload
        $file_pdf = 'Form NUP';
        // setting paper
        $paper = 'A4';
        //orientasi paper potrait / landscape
        $orientation = "portrait";
        
		$html = $this->load->view('form',$this->data, true);	    
        
        // run dompdf
        $this->pdfgenerator->generate($html, $file_pdf,$paper,$orientation);
    }
}