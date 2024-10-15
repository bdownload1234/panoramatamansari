<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kavling extends CI_Controller {

   var $data_ref = array('uri_controllers' => 'kavling');

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Kavling_model','kavling');
		// $this->load->model('Group/Group_model','group');

		check_login();
	}

	public function index()
	{

      $user_data['data_ref'] = $this->data_ref;
      $user_data['title'] = 'Sekolah';
      $user_data['menu_active'] = 'Data Referensi';
      $user_data['sub_menu_active'] = 'Sekolah';
     	
      $this->load->view('template/header',$user_data);
		$this->load->view('view',$user_data);
      // $this->load->view('template/footer',$user_data);

	}

	public function ajax_list()
	{

		$list = $this->kavling->get_datatables();
		$data = array();
		$no = $_POST['start'];

		foreach ($list as $post) {
			$link_edit = '<a class="btn btn-xs btn-success" href="javascript:void(0)" title="Edit" onclick="edit('."'".$post->id_kavling."'".')"> Edit Kavling</a>';
			$no++;
			$row = array();
         	$row[] = $no;
         	$row[] = $post->kode_kavling;
         	$row[] = $post->luas_tanah.' meter';
         	$row[] = $post->tipe_bangunan;
			$row[] = rupiah($post->hrg_jual);
			$row[] = rupiah($post->harga_diskon);

			if($post->stt_kavling == '0'){
				$row[] = '<span class="btn btn-danger btn-xs">HOLD</span>';
			}elseif($post->stt_kavling == '1'){
				$row[] = '<span class="btn btn-warning btn-xs">AVAILABLE</span>';
			}elseif($post->stt_kavling == '2'){
				$row[] = '<span class="btn btn-primary btn-xs">NUP</span>';
			}elseif($post->stt_kavling == '3'){
				$row[] = '<span class="btn btn-info btn-xs">TERBOOKING</span>';
			}elseif($post->stt_kavling == '4'){
				$row[] = '<span class="btn btn-success btn-xs">SUDAH AKAD</span>';
			}elseif($post->stt_kavling == '5'){
				$row[] = '<span class="btn btn-warning btn-xs">STANDART</span>';
			}elseif($post->stt_kavling == '6'){
				$row[] = '<span class="btn btn-secondary btn-xs">KHUSUS</span>';
			}else{
				$row[] = '';
			}
			
			$row[] = $post->keterangan;

			//add html for action
			$row[] = $link_edit;

			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->kavling->count_all(),
						"recordsFiltered" => $this->kavling->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

		

	public function ajax_edit($id)
	{
		$data = $this->kavling->get_by_id($id);
		$data['hrg_jual'] = rupiah($data['hrg_jual']);
		$data['harga_diskon'] = rupiah($data['harga_diskon']);
		echo json_encode($data);
	}

	public function ajax_add()
	{

		// $this->_validate();
		$post_date = time();
		$post_date_format = date('Y-m-d h:i:s', $post_date);
      // $user = $this->ion_auth->user()->row();
		$data = array(
				'tanggal' 	=> date('Y-m-d'),
				'judul' 	=> $this->input->post('judul'),
				'isi_agenda' 	=> $this->input->post('judul'),
				'status' 	=> $this->input->post('status_agenda'),
				'stt_kavling' 	=> $this->input->post('stt_kavling'),
            	'is_trash' 	=> 0
		);

		
		$insert = $this->kavling->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		// if($this->input->post('status') == '0'){
		// 	$data = array(
		// 		'kode_kavling'		=> $this->input->post('kode_kavling'),
		// 		'tipe_bangunan'		=> $this->input->post('tipe_bangunan'),
		// 		'luas_tanah'		=> $this->input->post('luas_tanah'),
		// 		'hrg_jual'			=> str_replace('.','', $this->input->post('harga_jual')),
		// 		'stt_kavling' 			=> $this->input->post('stt_kavling'),
		// 		'keterangan' 			=> $this->input->post('keterangan')
		// 	);
		// }else{
			$data = array(
				'kode_kavling'		=> $this->input->post('kode_kavling'),
				'tipe_bangunan'		=> $this->input->post('tipe_bangunan'),
				'luas_tanah'		=> $this->input->post('luas_tanah'),
				'hrg_jual'			=> str_replace('.','', $this->input->post('harga_jual')),
				'harga_diskon'			=> str_replace('.','', $this->input->post('harga_diskon')),
				'stt_kavling' 			=> $this->input->post('stt_kavling'),
				'keterangan' 			=> $this->input->post('keterangan')
			);
		// }
		$this->db->update('kavling_peta', $data , array('id_kavling' => $this->input->post('id')));
		if($this->input->post('stt_kavling') == '4'){
		    $this->db->update('spr', ['status_spr' => '21'] , array('id_kavling' => $this->input->post('id')));
		}
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$this->kavling->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('judul') == '')
		{
			$data['inputerror'][] = 'judul';
			$data['error_string'][] = 'Judul harus diisi';
			$data['status'] = FALSE;
		}

		if($this->input->post('isi_konten') == '')
		{
			$data['inputerror'][] = 'isi_konten';
			$data['error_string'][] = 'Konten harus diisi';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}


	public function upload(){
		$user_data['kosong'] = "";
		$this->load->view('template/header',$user_data);
		$this->load->view('upload',$user_data);
	}


	public function proses_polygon(){
		$peta = $this->input->post('peta');

		//cari polygon
		$pecah = explode('<polygon', $peta);
		$jmlh =  count($pecah);
		// echo $jmlh-1;
		for($i = 1; $i < $jmlh; $i++){
			$awal = explode('transform="', $pecah[$i]);
			$awal2 = explode('">', @$awal[1]);
			$semi = explode('points="', $pecah[$i]);
			$poin = explode('"/>', $semi[1]);
			$kodeKavling = trim(strip_tags($poin[1]));
			
			$param = [
				'kode_kavling' 	=> $kodeKavling, 
				'jenis_map' 	=> 'polygon', 
				'map' 			=> @$poin[0], 
				'matrik' 		=> $awal2[0]
			];
			$this->db->insert('kavling_peta', $param);
   		}

		$pecahPath = explode('<path', $peta);
		$parth_2 =  count($pecahPath);
		for($j = 1; $j < $parth_2; $j++){
			  $awal_x = explode('transform="', $pecahPath[$j]);
			  $awal2_x = explode('">', @$awal_x[1]);
			  $semi_x = explode('d="', $pecahPath[$j]);
			  $pint_x = explode('"/>', $semi_x[1]);
			  $kodeKavlingPath = trim(strip_tags($pint_x[1]));

			
			$paramPath = [
				'kode_kavling' 	=> $kodeKavlingPath, 
				'jenis_map' 	=> 'path', 
				'map' 			=> @$pint_x[0], 
				'matrik' 		=> $awal2_x[0]
			];
			$this->db->insert('kavling_peta', $paramPath);
   		}

		redirect('kavling','refresh');
	}



}
