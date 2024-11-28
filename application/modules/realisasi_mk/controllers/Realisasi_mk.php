<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Realisasi_mk extends CI_Controller {
    var $data_ref = array('uri_controllers' => 'realisasi_mk');
    
    public function __construct()
	{
		parent::__construct();
		$this->load->model('Realisasi_mk_model','realisasi_mk');
		// $this->load->model('Group/Group_model','group');

		check_login();
	}
	
	public function index()
	{
		$user_data['data_ref'] = '';

		// <option value="1">Progress Bangunan 1</option>
		// <option value="2">Progress Bangunan 2</option>
		// <option value="3">Sertifikat</option>
		// <option value="4">IMB</option>
		// <option value="5">Bestek</option>
		// <option value="6">Listrik</option>
		// <option value="7">PPJB</option>
		// <option value="8">BPHTB</option>
		// <option value="9">PBB</option>
		// <option value="10">Lain-lain</option>


		$data = $this->db->query("
		  SELECT 
					CASE 
							WHEN d.id_hadir IS NOT NULL THEN d.id_hadir 
							ELSE 'Tidak ada no Akad' 
					END AS no_akad,
					CASE 
							WHEN d.id_hadir IS NOT NULL THEN d.tanggal 
							ELSE 'Tidak ada tanggal Akad' 
					END AS tanggal_akad,
					e.nama_bank,
					(SELECT SUM(pencairan) FROM realisasi_mk_dt WHERE a.id = id_header) AS pencairan,  
					b.nama_lengkap, 
					c.kode_kavling,
					(SELECT SUM(pencairan) FROM realisasi_mk_dt WHERE a.id = id_header AND pencairan_id = 1) AS progress_bangunan_1,
					(SELECT SUM(pencairan) FROM realisasi_mk_dt WHERE a.id = id_header AND pencairan_id = 2) AS progress_bangunan_2,
					(SELECT SUM(pencairan) FROM realisasi_mk_dt WHERE a.id = id_header AND pencairan_id = 3) AS sertifikat,
					(SELECT SUM(pencairan) FROM realisasi_mk_dt WHERE a.id = id_header AND pencairan_id = 4) AS imb,
					(SELECT SUM(pencairan) FROM realisasi_mk_dt WHERE a.id = id_header AND pencairan_id = 5) AS bestek,
					(SELECT SUM(pencairan) FROM realisasi_mk_dt WHERE a.id = id_header AND pencairan_id = 6) AS listrik,
					(SELECT SUM(pencairan) FROM realisasi_mk_dt WHERE a.id = id_header AND pencairan_id = 7) AS ppjb,
					(SELECT SUM(pencairan) FROM realisasi_mk_dt WHERE a.id = id_header AND pencairan_id = 8) AS bphtb,
					(SELECT SUM(pencairan) FROM realisasi_mk_dt WHERE a.id = id_header AND pencairan_id = 9) AS pbb,
					(SELECT SUM(pencairan) FROM realisasi_mk_dt WHERE a.id = id_header AND pencairan_id = 10) AS lain_lain,   
					a.* 
			FROM realisasi_mk a
			LEFT JOIN customer b ON a.id_customer = b.id_customer
			LEFT JOIN kavling_peta c ON a.id_kavling = c.id_kavling
			LEFT JOIN daftar_hadir d ON a.id_customer = d.id_customer
			LEFT JOIN bank e ON a.bank_id = e.id_bank
			ORDER BY d.tanggal ASC
		")->result();

		$bank = $this->db->from('bank')->get()->result();

		$user_data['data'] = $data;
		$user_data['bank'] = $bank;
		// $user_data['noCust'] = $this->no_cust();
		$this->load->view('template/header',$user_data);
		$this->load->view('index',$user_data);
      // $this->load->view('template/footer',$user_data);
	}
	
	public function ajax_select_customer()
	{
	   // $users = $this->db->from('customer')->get()->result_array();
	   if($_GET['q'] == ''){
	    $users = $this->db->query("SELECT * FROM customer WHERE id_customer NOT IN (SELECT id_customer FROM realisasi_mk)")->result_array();
	   }else{
	    $users = $this->db->query("SELECT * FROM customer WHERE id_customer NOT IN (SELECT id_customer FROM realisasi_mk) AND nama_lengkap LIKE '%".$_GET['q']."%'")->result_array();
	   }
	    echo json_encode($users);
	}
	
	public function store(){
	    $post = $this->input->post();
	    $data = [];
	    try{
	        $data['id_customer'] = $post['id_customer'];
	        $data['id_kavling'] = $post['id_blok'];
	        $data['realisasi_mk'] = str_replace(',', '', $post['realisasi_mk']);
	        $data['dana_blokir_progress_bangunan_1'] = str_replace(',', '', $post['dana_blokir_progress_bangunan_1']);
	        $data['dana_blokir_progress_bangunan_2'] = str_replace(',', '', $post['dana_blokir_progress_bangunan_2']);
	        $data['dana_blokir_sertifikat'] = str_replace(',', '', $post['dana_blokir_sertifikat']);
	        $data['dana_blokir_imb'] = str_replace(',', '', $post['dana_blokir_imb']);
	        $data['dana_blokir_bestek'] = str_replace(',', '', $post['dana_blokir_bestek']);
	        $data['dana_blokir_listrik'] = str_replace(',', '', $post['dana_blokir_listrik']);
	        $data['dana_blokir_ppjb'] = str_replace(',', '', $post['dana_blokir_ppjb']);
	        $data['dana_blokir_bphtb'] = str_replace(',', '', $post['dana_blokir_bphtb']);
	        $data['dana_blokir_pbb'] = str_replace(',', '', $post['dana_blokir_pbb']);
	        $data['dana_dll'] = str_replace(',', '', $post['dana_dll']);
	        
	        
	       
	        $check = $this->db->from('realisasi_mk')->where('id_customer', $post['id_customer'])->get()->row_array();
	        if($check){
	            $this->db->update('realisasi_mk', $data, ['id_customer' => $post['id_customer']]);
	        }else{
	            $x = $this->db->insert('realisasi_mk', $data);
	            $check = $this->db->from('realisasi_mk')->where('id_customer', $post['id_customer'])->get()->row_array();
	            
	            unset($data);
    	        foreach($post['pencairan'] as $key => $cair){
    	            $data['id_header'] = $check['id'];
    	            $data['pencairan'] = str_replace(',', '', $cair);
    	            $date = date_create($post['tanggal_pencairan'][$key]);
    	            $data['tanggal_pencairan'] = date_format($date,"Y-m-d");
    	            $this->db->insert('realisasi_mk_dt', $data);
    	        }
    	        
	        }
	        
	        echo json_encode(array("status" => TRUE));
	    }catch(Exception $e){
	        var_dump($e->getMessage());
	        echo json_encode(array("status" => FALSE));
	    }
	}
	
	public function get_data(){
	    $id = $_GET['id'];
	    $data = $this->db->query("
		    SELECT 
					(
						SELECT 
							SUM(pencairan) 
						FROM 
							realisasi_mk_dt 
						WHERE 
							a.id = id_header
					) as pencairan, 
					d.tanggal as tanggal_akad, 
					b.nama_lengkap, 
					c.kode_kavling,
					(SELECT COALESCE(SUM(pencairan), 0) FROM realisasi_mk_dt WHERE a.id = id_header AND pencairan_id = 1) AS progress_bangunan_1,
					(SELECT COALESCE(SUM(pencairan), 0) FROM realisasi_mk_dt WHERE a.id = id_header AND pencairan_id = 2) AS progress_bangunan_2,
					(SELECT COALESCE(SUM(pencairan), 0) FROM realisasi_mk_dt WHERE a.id = id_header AND pencairan_id = 3) AS sertifikat,
					(SELECT COALESCE(SUM(pencairan), 0) FROM realisasi_mk_dt WHERE a.id = id_header AND pencairan_id = 4) AS imb,
					(SELECT COALESCE(SUM(pencairan), 0) FROM realisasi_mk_dt WHERE a.id = id_header AND pencairan_id = 5) AS bestek,
					(SELECT COALESCE(SUM(pencairan), 0) FROM realisasi_mk_dt WHERE a.id = id_header AND pencairan_id = 6) AS listrik,
					(SELECT COALESCE(SUM(pencairan), 0) FROM realisasi_mk_dt WHERE a.id = id_header AND pencairan_id = 7) AS ppjb,
					(SELECT COALESCE(SUM(pencairan), 0) FROM realisasi_mk_dt WHERE a.id = id_header AND pencairan_id = 8) AS bphtb,
					(SELECT COALESCE(SUM(pencairan), 0) FROM realisasi_mk_dt WHERE a.id = id_header AND pencairan_id = 9) AS pbb,
					(SELECT COALESCE(SUM(pencairan), 0) FROM realisasi_mk_dt WHERE a.id = id_header AND pencairan_id = 10) AS lain_lain,
					a.* 
				FROM 
					realisasi_mk a 
					LEFT JOIN customer b ON a.id_customer = b.id_customer 
					LEFT JOIN kavling_peta c ON a.id_kavling = c.id_kavling 
					LEFT JOIN daftar_hadir d ON d.id_customer = b.id_customer
		    WHERE a.id = '$id'
		")->result_array();
		
		$data_dt = $this->db->query("SELECT * FROM realisasi_mk_dt WHERE id_header = '$id'")->result();
		$response = [];
		$response['data'] = $data;
		$response['data_dt'] = $data_dt;
		
		echo json_encode($response);
	}
	
	public function update(){
	    $post = $this->input->post();
	    $data = [];
	    try{
	        $data['realisasi_mk'] = str_replace(',', '', $post['realisasi_mk']);
					$data['bank_id'] = $post['bank_edit'];
	        $data['dana_blokir_progress_bangunan_1'] = str_replace(',', '', $post['dana_blokir_progress_bangunan_1']);
	        $data['dana_blokir_progress_bangunan_2'] = str_replace(',', '', $post['dana_blokir_progress_bangunan_2']);
	        $data['dana_blokir_sertifikat'] = str_replace(',', '', $post['dana_blokir_sertifikat']);
	        $data['dana_blokir_imb'] = str_replace(',', '', $post['dana_blokir_imb']);
	        $data['dana_blokir_bestek'] = str_replace(',', '', $post['dana_blokir_bestek']);
	        $data['dana_blokir_listrik'] = str_replace(',', '', $post['dana_blokir_listrik']);
	        $data['dana_blokir_ppjb'] = str_replace(',', '', $post['dana_blokir_ppjb']);
	        $data['dana_blokir_bphtb'] = str_replace(',', '', $post['dana_blokir_bphtb']);
	        $data['dana_blokir_pbb'] = str_replace(',', '', $post['dana_blokir_pbb']);
	        $data['dana_dll'] = str_replace(',', '', $post['dana_dll']);
	        
	       
	        $check = $this->db->from('realisasi_mk')->where('id', $post['id'])->get()->row_array();
	       // if($check){
	            $this->db->update('realisasi_mk', $data, ['id' => $post['id']]);
	       // }else{
	            $this->db->from('realisasi_mk_dt')->where('id_header', $post['id'])->delete();
	            
	            unset($data);
    	        foreach($post['pencairan_edit'] as $key => $cair){
    	            $data['id_header'] = $post['id'];
    	            $data['pencairan'] = str_replace(',', '', $cair);
    	            $data['tanggal_pencairan'] = $post['tanggal_pencairan'][$key];
									$data['pencairan_id'] = $post['jenis_pencairan'][$key];
									$data['pencairan_lain'] = $post['jenis_pencairan_lain'][$key];
    	           // $date = date_create($post['tanggal_pencairan'][$key]);
    	           // $data['tanggal_pencairan'] = date_format($date,"Y-m-d");
    	            $this->db->insert('realisasi_mk_dt', $data);
    	        }
    	        
	       // }
	        
	        echo json_encode(array("status" => TRUE));
	    }catch(Exception $e){
	        var_dump($e->getMessage());
	        echo json_encode(array("status" => FALSE));
	    }
	}
	
	function excel()
    {
				$date = $_GET['range'];
				$range = explode(' - ', $date);
				$range = "WHERE f.tanggal BETWEEN '".$range[0]."' AND '".$range[1]."'";
        $data = $this->db->query("
					SELECT DISTINCT (SELECT SUM(pencairan) FROM realisasi_mk_dt WHERE a.id = id_header) as total_pencairan,
					CASE 
							WHEN f.id_hadir IS NOT NULL THEN f.id_hadir 
							ELSE 'Tidak ada no Akad' 
					END AS no_akad,
					CASE 
							WHEN f.id_hadir IS NOT NULL THEN f.tanggal 
							ELSE 'Tidak ada tanggal Akad' 
					END AS tanggal_akad,
					b.nama_lengkap,
					c.kode_kavling, 
					e.nama_bank,
					a.*
					FROM realisasi_mk a
					LEFT JOIN customer b ON a.id_customer = b.id_customer
					LEFT JOIN kavling_peta c ON a.id_kavling = c.id_kavling
					LEFT JOIN bank e ON a.bank_id = e.id_bank
					LEFT JOIN daftar_hadir f ON a.id_customer = f.id_customer
					$range
					ORDER BY f.tanggal ASC
				")->result();
		$user_data['data'] = $data;
        $this->load->view('excel', $user_data);
    }
}