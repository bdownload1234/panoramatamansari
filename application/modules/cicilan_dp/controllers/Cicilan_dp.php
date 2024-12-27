<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cicilan_dp extends CI_Controller {
  var $data_ref = array('uri_controllers' => 'cicilan_dp');
    
  public function __construct()
	{
		parent::__construct();
		$this->load->model('Cicilan_dp_model','cicilan_dp');
		// $this->load->model('Group/Group_model','group');

		check_login();
	}
	
	public function index()
	{
	    $data = $this->db->query("
	        SELECT b.nama_lengkap, c.kode_kavling, c.hrg_jual, c.harga_jual_ajb, a.*,
					(SELECT SUM(nilai_dp) FROM cicilan_dp_dt WHERE cicilan_dp_id = a.id) as total_dp,
					CASE WHEN d.id_hadir IS NOT NULL THEN d.id_hadir ELSE 'Tidak ada Nomor Akad' END as no_akad
	        FROM cicilan_dp a
	        LEFT JOIN customer b on a.id_customer = b.id_customer
	        LEFT JOIN kavling_peta c ON a.id_blok = c.id_kavling
					LEFT JOIN daftar_hadir d ON a.id_customer = d.id_customer
					ORDER BY a.created_at ASC
	    ")->result();
	    
		$user_data['data_ref'] = $this->data_ref;
		$user_data['data'] = $data;
		// $user_data['noCust'] = $this->no_cust();
		$this->load->view('template/header',$user_data);
		$this->load->view('index',$user_data);
      // $this->load->view('template/footer',$user_data);
	}
	
	public function ajax_select_customer()
	{
	   // $users = $this->db->from('customer')->get()->result_array();
	    $users = $this->db->query("SELECT * FROM customer WHERE id_customer NOT IN (SELECT id_customer FROM cicilan_dp)")->result_array();
	    echo json_encode($users);
	}
	
	public function ajax_change_customer()
	{
	    $id_customer = $_GET['id_customer'];
	    
	    $data_customer = $this->db->from('customer')->where('id_customer', $id_customer)->get()->row_array();
	    $data_kavling = $this->db->from('kavling_peta')->where('id_kavling', $data_customer['id_kavling'])->get()->row_array();
			$data_akad = $this->db->from('daftar_hadir')->where('id_customer', $id_customer)->get()->row_array();
	    
	    $response = [];
	    $response['data_customer'] = $data_customer;
	    $response['data_kavling'] = $data_kavling;
			$response['data_akad'] = $data_akad;
	    echo json_encode($response);
	}
	
	public function store(){
	    $post = $this->input->post();
	    $data = [];
			$this->db->trans_begin();
	    try{
	        $data['id_customer'] = $post['id_customer'];
	        $data['id_blok'] = $post['id_blok'];
	        $data['nominal_booking'] = str_replace(',', '', $post['nominal_booking']);
	        $data['harga_acc_bank'] = str_replace(',', '', $post['harga_acc_bank']);
	        $data['status'] = (str_replace(',', '', $post['kekurangan']) <= 0 ? 'Lunas' : 'Belum Lunas');
					$data['jenis_pembayaran'] = $post['jenis_pembayaran'];
	       // $data['created_by'] = $this->input->post('username');
	       
	        $check = $this->db->from('cicilan_dp')->where('id_customer', $post['id_customer'])->get()->row_array();
	        if($check){
	            $this->db->update('cicilan_dp', $data, ['id_customer' => $post['id_customer']]);
	        }else{
							$data['created_at'] = date('Y-m-d H:i:s');
	            $this->db->insert('cicilan_dp', $data);
	        }

					$id = $check["id"] ? $check["id"] : $this->db->insert_id();


					$this->db->delete('cicilan_dp_dt', ['cicilan_dp_id' => $id]);

					foreach($post['dp'] as $key => $value) {
							$data_detail = [];
							$data_detail['cicilan_dp_id'] = $id;
							$data_detail['tanggal_dp'] = $post['tanggal_dp'][$key];
							$data_detail['nilai_dp'] = str_replace(',', '', $value);
							$data_detail['created_at'] = date('Y-m-d H:i:s');

							$this->db->insert('cicilan_dp_dt', $data_detail);
					}
					
					$this->db->trans_commit();
	        
	        echo json_encode(array("status" => TRUE));
	    }catch(Exception $e){
					$this->db->trans_rollback();
	        var_dump($e->getMessage());
	        echo json_encode(array("status" => FALSE));
	    }
	}
	
	public function ajax_get_data()
	{
	    $id = $_GET['id'];
	    
	    $data['header'] = $this->db->query("
	        SELECT b.nama_lengkap, c.kode_kavling, c.hrg_jual, c.harga_jual_ajb, a.*
	        FROM cicilan_dp a
	        LEFT JOIN customer b on a.id_customer = b.id_customer
	        LEFT JOIN kavling_peta c ON a.id_blok = c.id_kavling
	        WHERE a.id = $id")->row_array();

			$data['detail'] = $this->db->query("
	        SELECT *
	        FROM cicilan_dp_dt
	        WHERE cicilan_dp_id = $id")->result();

	    
	    echo json_encode($data);
	}
	
	public function download()
    {
        $data = $this->db->query("
	        SELECT b.nama_lengkap, c.kode_kavling, c.hrg_jual, c.harga_jual_ajb, a.*,
					(SELECT SUM(nilai_dp) FROM cicilan_dp_dt WHERE cicilan_dp_id = a.id) as total_dp,
					CASE WHEN d.id_hadir IS NOT NULL THEN d.id_hadir ELSE 'Tidak ada Nomor Akad' END as no_akad
	        FROM cicilan_dp a
	        LEFT JOIN customer b on a.id_customer = b.id_customer
	        LEFT JOIN kavling_peta c ON a.id_blok = c.id_kavling
					LEFT JOIN daftar_hadir d ON a.id_customer = d.id_customer
	    ")->result();
		
        $data['data'] = $data;
		$this->load->view('download', $data);
    }

	function print($id)
	{
		$this->load->library('pdfgenerator');

		$data['detail'] = $this->db->query("
	        SELECT *
	        FROM cicilan_dp_dt
	        WHERE id = $id")->result();
		
		// Extract month and year from the selected date (example: '30-08-2024')
    $selected_date = date_create_from_format('Y-m-d', $data['detail'][0]->tanggal_dp);
    $selected_day = $selected_date->format('d'); // Get the day (e.g., 30)
    $selected_month = $selected_date->format('m'); // Get the month (e.g., 08)
    $selected_year = $selected_date->format('Y'); // Get the year (e.g., 2024)

    // Query to count transactions before the selected day within the same month and year
    // $no_cicilan = $this->db->query("
    //     SELECT count(*) as no_cicilan
    //     FROM cicilan_dp_dt
    //     WHERE MONTH(tanggal_dp) = ? 
    //     AND YEAR(tanggal_dp) = ?
    //     AND DAY(tanggal_dp) <= ?", 
    //     [$selected_month, $selected_year, $selected_day])->row()->no_cicilan;

		// $no_cicilan = $no_cicilan == 0 ? 1 : $no_cicilan; 

    // Format the transaction number, e.g., "002/PTP/VIII/2024"
    
		// $formatted_number = str_pad($no_cicilan, 3, '0', STR_PAD_LEFT) 
		// 			. "/PTP/" 
		// 			. convertToRoman($selected_month) 
		// 			. "/$selected_year";

		$data['header'] = $this->db->query("
	        SELECT b.nama_lengkap, c.kode_kavling, c.hrg_jual, a.*
	        FROM cicilan_dp a
	        LEFT JOIN customer b on a.id_customer = b.id_customer
	        LEFT JOIN kavling_peta c ON a.id_blok = c.id_kavling
	        WHERE a.id = ?", [$data['detail'][0]->cicilan_dp_id])->result();


		$row_number = $this->db->query("
			SELECT COUNT(*) as row_number
			FROM cicilan_dp
			WHERE created_at <= ?", [$data['header'][0]->created_at])->row()->row_number;
					
		$formatted_number = str_pad($row_number, 3, '0', STR_PAD_LEFT)
					. "/PTP/" 
					. convertToRoman($selected_month) 
					. "/$selected_year";

			

		$data['formatted_number'] = $formatted_number;
					

		$html = $this->load->view('print', $data, true);
		return $this->pdfgenerator->generate($html, 'print');			
	}
}