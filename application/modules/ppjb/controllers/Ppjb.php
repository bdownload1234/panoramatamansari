<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ppjb extends CI_Controller {

   var $data_ref = array('uri_controllers' => 'ppjb');

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Ppjb_model','ppjb');
		check_login();
	}

	public function index()
	{
		$user_data['data_ref'] = $this->data_ref;
		//buat nomor_transaksi

		$this->load->view('template/header',$user_data);
		$this->load->view('view',$user_data);
	}


	public function ajax_list()
	{

		$list = $this->ppjb->get_datatables();
		$data = array();
		$no = $_POST['start'];

		foreach ($list as $post) {

			$link_upload = '<a class="btn btn-xs btn-warning" href="javascript:void(0)" onclick="edit('."'".$post->id_spr."'".')"> Upload PPJB</a>';

			$cetak_spr = '<a href="'.base_url('spr/cetak/'.$post->id_spr).'" target="_blank"> '.$post->nomor_spr.'</a>';
			$cetak_akad = '<a href="'.base_url('lampiran_akad/'.$post->file_ppjb).'" target="_blank"> '.$post->nomor_ppjb.'</a>';

			$no++;
			$row = array();
         	$row[] = $no;
         	$row[] = $cetak_spr;
         	$row[] = $post->nama_lengkap.'<br>'.$post->no_telp;;
         	$row[] = $post->kode_kavling;
			$row[] = $post->nomor_ppjb;
			$row[] = $cetak_akad;

            // if($post->status_spr == '0'){
			// 	$row[] = '<span class="badge badge-pill badge-info">SPR</span>';
			// }else if($post->status_spr == '11'){
			// 	$row[] = '<span class="badge badge-pill badge-success">Pindah Kavling</span>';
			// }else if($post->status_spr == '12'){
			// 	$row[] = '<span class="badge badge-pill badge-warning">Ganti Nama</span>';
			// }else if($post->status_spr == '21'){
			// 	$row[] = '<span class="badge badge-pill badge-primary">AKAD</span>';
			// }else{
			// 	$row[] = '<span class="badge badge-pill badge-secondary">HOLD</span>';
			// }
			
			$row[] = $link_upload;
			$data[] = $row;

		}

		$output = array(
					"draw" => $_POST['draw'],
					"recordsTotal" => $this->ppjb->count_all(),
					"recordsFiltered" => $this->ppjb->count_filtered(),
					"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}


	public function ajax_edit($id)
	{
		$data = $this->db->join('customer', 'customer.id_customer = spr.id_customer', 'left')
		->join('kavling_peta', 'kavling_peta.id_kavling = spr.id_kavling', 'left')
		->get_where('spr', ['id_spr' => $id])->row();
		$data->harga_rumah = rupiah($data->harga_rumah);
		$data->booking_fee_spr = rupiah($data->booking_fee_spr);
		echo json_encode($data);
	}


	public function ajax_update()
	{
		$param = array(
			'tanggal_ppjb' 			=> $this->input->post('tanggal_ppjb'),
			'nomor_ppjb' 			=> $this->input->post('nomor_ppjb'),
			'catatan_ppjb' 			=> $this->input->post('catatan_ppjb')
		);

		if(!empty($_FILES['file_ppjb']['name']))
		{
			$upload = $this->_do_upload();
			$param['file_ppjb'] = $upload;
		}

		$this->ppjb->update(array('id_spr' => $this->input->post('id')), $param);

		echo json_encode(array("status" => TRUE));
	}


	public function ajax_delete($id)
	{
		// cari id customer
		$cus = $this->db->query("SELECT * FROM spr WHERE id_spr='$id'")->row_array();
		$this->db->delete('spr',array('id_spr'=>$id));

		// normalkan status customer menjadi 1
		$this->db->update('customer', ['status_customer' => '1'], ['id_customer' => $cus['id_customer']]);
		echo json_encode(array("status" => TRUE));
	}



	private function _do_upload(){

		$config['upload_path']          = './lampiran_akad/';
		$config['allowed_types']        = 'gif|jpg|png|pdf';
		$config['max_size']             = 2000; //set max size allowed in Kilobyte
		// $config['max_width']            = 3000; // set max width image allowed
		// $config['max_height']           = 3000; // set max height allowed
		$config['file_name']            = round(microtime(true) * 1000); //just milisecond timestamp fot unique name
   
		$this->load->library('upload', $config);
		   $this->upload->initialize($config);
		  if(!$this->upload->do_upload('file_ppjb')) //upload and validate
		  {
			  $data['inputerror'][] = 'file_ppjb';
			  $data['error_string'][] = 'Upload error: '.$this->upload->display_errors('',''); //show ajax error
			  $data['status'] = FALSE;
			  echo json_encode($data);
			  exit();
		  }
		  return $this->upload->data('file_name');
  }



}
