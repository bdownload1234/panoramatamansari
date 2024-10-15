<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Controller {

   var $data_ref = array('uri_controllers' => 'customer');

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Customer_model','customer');
		// $this->load->model('Group/Group_model','group');

		check_login();
	}

	public function index()
	{

		$user_data['data_ref'] = $this->data_ref;
		$user_data['noCust'] = $this->no_cust();
			
		$this->load->view('template/header',$user_data);
		$this->load->view('view',$user_data);
      // $this->load->view('template/footer',$user_data);

	}

	public function ajax_list()
	{

		$list = $this->customer->get_datatables();
		$data = array();
		$no = $_POST['start'];

		foreach ($list as $post) {

			$link_edit = '<a class="btn btn-xs btn-primary" href="javascript:void(0)" title="Edit" onclick="edit('."'".$post->id_customer."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>';
			$link_hapus = ' <a class="btn btn-xs btn-danger" href="javascript:void(0)" title="Hapus" onclick="hapus('."'".$post->id_customer."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';

			$no++;
			$row = array();
         	$row[] = $no;
         	$row[] = $post->nama_lengkap;
         	$row[] = $post->nik;
			$row[] = $post->alamat;
			$row[] = $post->no_telp;
			$row[] = $post->kode_kavling;

			//add html for action
			$row[] = $link_edit.$link_hapus;

			$data[] = $row;
		}

		$output = array(
					"draw" => $_POST['draw'],
					"recordsTotal" => $this->customer->count_all(),
					"recordsFiltered" => $this->customer->count_filtered(),
					"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	private function _do_upload(){

	      $config['upload_path']          = './assets/lampiran_customer/';
	      $config['allowed_types']        = 'gif|jpg|png|pdf';
	      $config['max_size']             = 1000; //set max size allowed in Kilobyte
	      $config['max_width']            = 3000; // set max width image allowed
	      $config['max_height']           = 3000; // set max height allowed
	      $config['file_name']            = round(microtime(true) * 1000); //just milisecond timestamp fot unique name
	 
	      $this->load->library('upload', $config);
	 		$this->upload->initialize($config);
	        if(!$this->upload->do_upload('ktp')) //upload and validate
	        {
	            $data['inputerror'][] = 'ktp';
	            $data['error_string'][] = 'Upload error: '.$this->upload->display_errors('',''); //show ajax error
	            $data['status'] = FALSE;
	            echo json_encode($data);
	            exit();
	        }
	        return $this->upload->data('file_name');
	}


	private function _do_upload_kk(){

	      $config['upload_path']          = './assets/lampiran_customer/';
	      $config['allowed_types']        = 'gif|jpg|png|pdf';
	      $config['max_size']             = 1000; //set max size allowed in Kilobyte
	      $config['max_width']            = 3000; // set max width image allowed
	      $config['max_height']           = 3000; // set max height allowed
	      $config['file_name']            = round(microtime(true) * 1000); //just milisecond timestamp fot unique name
	 
	      $this->load->library('upload', $config);
	 		$this->upload->initialize($config);
	        if(!$this->upload->do_upload('kk')) //upload and validate
	        {
	            $data['inputerror'][] = 'kk';
	            $data['error_string'][] = 'Upload error: '.$this->upload->display_errors('',''); //show ajax error
	            $data['status'] = FALSE;
	            echo json_encode($data);
	            exit();
	        }
	        return $this->upload->data('file_name');
	}

	public function ajax_edit($id)
	{
		$data = $this->customer->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$data = array(
			'kode_customer' 		=> $this->no_cust(),
			'id_marketing' 			=> $this->input->post('marketing'),
			'nama_lengkap' 			=> $this->input->post('nama_lengkap'),
			'no_ktp' 				=> $this->input->post('no_ktp'),
			'tempat_lahir' 			=> $this->input->post('tempat_lahir'),
			'tgl_lahir' 			=> $this->input->post('tgl_lahir'),
			'jenis_kelamin' 		=> $this->input->post('jenis_kelamin'),
			'tempat_lahir' 			=> $this->input->post('tempat_lahir'),
			'tgl_lahir' 			=> $this->input->post('tgl_lahir'),
			'alamat' 				=> $this->input->post('alamat'),
			'alamat_domisili' 		=> $this->input->post('alamat_domisili'),
			'alamat_tidak_serumah' 	=> $this->input->post('alamat_tidak_serumah'),
			'no_telp' 				=> $this->input->post('no_telp'),
			'no_wa' 				=> $this->input->post('no_wa'),
			'no_hp_tidak_serumah' 	=> $this->input->post('no_hp_tidak_serumah')
		);

		if(!empty($_FILES['ktp']['name']))
		{
			$upload = $this->_do_upload();
			$data['ktp'] = $upload;
		}


		if(!empty($_FILES['kk']['name']))
		{
			$upload = $this->_do_upload_kk();
			$data['kk'] = $upload;
		}

		$this->customer->save($data);
		$idCustomer = $this->db->insert_id();
		$param = [
			'id_customer' 	=> $idCustomer,
			'kategori' 		=> $this->input->post('nama_lengkap')
		];
		$this->db->insert('kategori', $param);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		// $this->_validate();
		$post_date = time();
		$post_date_format = date('Y-m-d h:i:s', $post_date);
		$data = array(
			'kode_customer' 		=> $this->input->post('kode_customer'),
			'id_marketing' 			=> $this->input->post('marketing'),
			'nama_lengkap' 			=> strtoupper($this->input->post('nama_lengkap')),
			'no_ktp' 				=> $this->input->post('no_ktp'),
			'tempat_lahir' 			=> $this->input->post('tempat_lahir'),
			'tgl_lahir' 			=> $this->input->post('tgl_lahir'),
			'jenis_kelamin' 		=> $this->input->post('jenis_kelamin'),
			'tempat_lahir' 			=> $this->input->post('tempat_lahir'),
			'tgl_lahir' 			=> $this->input->post('tgl_lahir'),
			'alamat' 				=> $this->input->post('alamat'),
			'alamat_domisili' 		=> $this->input->post('alamat_domisili'),
			'alamat_tidak_serumah' 	=> $this->input->post('alamat_tidak_serumah'),
			'no_telp' 				=> $this->input->post('no_telp'),
			'no_wa' 				=> $this->input->post('no_wa'),
			'no_hp_tidak_serumah' 	=> $this->input->post('no_hp_tidak_serumah')
		);


		// if($this->input->post('ktp')) // if remove photo checked
  //     {
  //        if(file_exists('./assets/lampiran_customer/'.$this->input->post('ktp')) && $this->input->post('ktp'))
  //           unlink('./assets/lampiran_customer/'.$this->input->post('ktp'));
  //        $data['ktp'] = '';
  //     }
 
      if(!empty($_FILES['ktp']['name']))
      {
         $upload = $this->_do_upload();
             
         //delete file
         $customer = $this->customer->get_by_id($this->input->post('id'));
         // var_dump($berita);
         if(file_exists('./assets/lampiran_customer/'.$customer->ktp) && $customer->ktp)
             unlink('./assets/lampiran_customer/'.$customer->ktp);
 
         $data['ktp'] = $upload;
      }


      if(!empty($_FILES['kk']['name']))
      {
         $upload = $this->_do_upload_kk();
             
         //delete file
         $customer = $this->customer->get_by_id($this->input->post('id'));
         // var_dump($berita);
         if(file_exists('./assets/lampiran_customer/'.$customer->kk) && $customer->kk)
             unlink('./assets/lampiran_customer/'.$customer->kk);
 
         $data['kk'] = $upload;
      }

		$this->customer->update(array('id_customer' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$this->db->delete('customer',array('id_customer'=>$id));
		echo json_encode(array("status" => TRUE));
	}


	public function no_cust()
	{
		$nomor = $this->db->query("SELECT MAX(kode_customer) as besar FROM customer")->row_array();
		$noCustRX = $nomor['besar'];

		$urutanTRX = (int) substr($noCustRX, 2, 3);
		$urutanTRX++;
		$hurufTRX = "C-";
		$noCust = $hurufTRX.sprintf("%03s", $urutanTRX);
		return $noCust;
	}




}
