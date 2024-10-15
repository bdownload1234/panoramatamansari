<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reg extends CI_Controller {

   var $data_ref = array('uri_controllers' => 'customer');

	public function __construct()
	{
		parent::__construct();
	}

	public function index(){
		$this->load->view('registrasi');
	}


	public function save(){
		$data = array(
			'nama_lengkap' 					=> $this->input->post('nama_lengkap'),
			'nik' 							=> $this->input->post('nik'),
			'npwp' 							=> $this->input->post('nama_lengkap'),
			'kartu_keluarga' 				=> $this->input->post('kartu_keluarga'),
			'bpjs_tk' 						=> $this->input->post('bpjs_tk'),
			'booking_fee' 					=> $this->input->post('booking_fee'),
			'nama_marketing' 				=> $this->input->post('nama_marketing'),
			'email' 						=> $this->input->post('email'),
			'no_telp' 						=> $this->input->post('no_telp'),
			'nama_saudara' 					=> $this->input->post('nama_saudara'),
			'alamat' 						=> $this->input->post('alamat'),
			'no_telp_saudara' 				=> $this->input->post('no_telp_saudara'),
			'lokasi_kavling' 				=> $this->input->post('lokasi_kavling'),
			'tipe_unit' 					=> $this->input->post('tipe_unit'),
			'pengalaman_interaksi' 			=> $this->input->post('pengalaman_interaksi'),
			'persetujuan' 					=> $this->input->post('persetujuan')
		);

		if(!empty($_FILES['foto_ktp']['name']))
		{
			$upload = $this->_do_upload_ktp();
			$data['foto_ktp'] = $upload;
		}

		if(!empty($_FILES['foto_npwp']['name']))
		{
			$upload = $this->_do_upload_npwp();
			$data['foto_npwp'] = $upload;
		}

		if(!empty($_FILES['foto_kk']['name']))
		{
			$upload = $this->_do_upload_kk();
			$data['foto_kk'] = $upload;
		}

		if(!empty($_FILES['foto_bpjs']['name']))
		{
			$upload = $this->_do_upload_bpjs();
			$data['foto_bpjs'] = $upload;
		}

		if(!empty($_FILES['foto_ktp_suami']['name']))
		{
			$upload = $this->_do_upload_ktp_suami();
			$data['foto_ktp_suami'] = $upload;
		}

		if(!empty($_FILES['foto_ktp_istri']['name']))
		{
			$upload = $this->_do_upload_ktp_istri();
			$data['foto_ktp_istri'] = $upload;
		}

		if(!empty($_FILES['foto_calon_pemilik']['name']))
		{
			$upload = $this->_do_upload_calon_pemilik();
			$data['foto_calon_pemilik'] = $upload;
		}

		if(!empty($_FILES['bukti_transfer']['name']))
		{
			$upload = $this->_do_upload_bukti_transfer();
			$data['bukti_transfer'] = $upload;
		}

		$this->db->insert('registrasi', $data);
		$id = $this->db->insert_id();

		// update peta kavling jadi terbooking
		$this->db->update('kavling_peta', ['stt_booking'=>'1'], ['id_kavling' => $this->input->post('lokasi_kavling')]);

		$wa = trim($this->input->post('no_telp'));
		$wa = str_replace(' ','',$wa);
		$wa = str_replace('-','',$wa);
		$belakang = substr($wa,1);
		$awal = substr($wa,0,1);
		if($awal == '0'){
			$nowa = '62'.$belakang;
		}else{
			$nowa = $wa;
		}

		$nama = strtoupper($this->input->post('nama_lengkap'));

		// Kirim pesan whatsapp
		// Punya GTALAWANGAN KALTENG ----
		$age = array(
			"api_key"     => 'A88F4KWX5JECQOO6', 
			"number_key"  => 'A0Kp0tTyOqUBEu5T', 
			"phone_no"    => $nowa,
			"message"     => '*Pesona Tamansari* 

Sistem kami telah menerima registrasi atas nama : 
*'.$nama.'* 
Kami akan segera memproses permohonan anda dan segera menghubungi anda kembali.

Terima Kasih
*Admin Pesona Tamansari*'
		);
  
		$json = json_encode($age);
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://api.watzap.id/v1/send_message',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS =>$json,
			CURLOPT_HTTPHEADER => array(
			'Content-Type: application/json'
			),
		));
		
		$response = curl_exec($curl);
		
		curl_close($curl);
		$data = json_decode($response, true);

		// echo json_encode(array("status" => TRUE));
		$data['nama'] = $this->input->post('nama_lengkap');
		redirect('reg/berhasil/'.$id);
	}


	private function _do_upload() {

        $target_dir = "./assets/foto_absen/";
        $target_file = $target_dir . basename($_FILES["foto_absen"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

 
        $source_image = $_FILES["foto_absen"]["tmp_name"];
        $namaFile = "compressed_" . uniqid();
        $destination_image = $target_dir . $namaFile . "." . $imageFileType;

        // Define the new dimensions
        $max_width = 800;
        $max_height = 600;

        list($width, $height) = getimagesize($source_image);
        $ratio = min($max_width / $width, $max_height / $height);

        // Resize the image
        $new_width = $width * $ratio;
        $new_height = $height * $ratio;
        $new_image = imagecreatetruecolor($new_width, $new_height);

        if ($imageFileType == "jpg" || $imageFileType == "jpeg") {
            $image = imagecreatefromjpeg($source_image);
        } else if ($imageFileType == "png") {
            $image = imagecreatefrompng($source_image);
        }

        imagecopyresampled($new_image, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
        
        // Save the compressed image
        if ($imageFileType == "jpg" || $imageFileType == "jpeg") {
            imagejpeg($new_image, $destination_image, 90);
        } else if ($imageFileType == "png") {
            imagepng($new_image, $destination_image, 9);
        }


        return $namaFile;
    }


	private function _do_upload_ktp(){

		$target_dir = "./lampiran_registrasi/";
        $target_file = $target_dir . basename($_FILES["foto_ktp"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

 
        $source_image = $_FILES["foto_ktp"]["tmp_name"];
        $namaFile = "compressed_" . uniqid();
        $destination_image = $target_dir . $namaFile . "." . $imageFileType;

        // Define the new dimensions
        $max_width = 800;
        $max_height = 600;

        list($width, $height) = getimagesize($source_image);
        $ratio = min($max_width / $width, $max_height / $height);

        // Resize the image
        $new_width = $width * $ratio;
        $new_height = $height * $ratio;
        $new_image = imagecreatetruecolor($new_width, $new_height);

        if ($imageFileType == "jpg" || $imageFileType == "jpeg") {
            $image = imagecreatefromjpeg($source_image);
        } else if ($imageFileType == "png") {
            $image = imagecreatefrompng($source_image);
        }

        imagecopyresampled($new_image, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
        
        // Save the compressed image
        if ($imageFileType == "jpg" || $imageFileType == "jpeg") {
            imagejpeg($new_image, $destination_image, 90);
        } else if ($imageFileType == "png") {
            imagepng($new_image, $destination_image, 9);
        }


        return $namaFile.'.jpg';
  }


  private function _do_upload_npwp(){

		// $config['upload_path']          = './lampiran_registrasi/';
		// $config['allowed_types']        = 'gif|jpg|png|pdf|jpeg|JPG|JPEG|PNG|GIF';
		// $config['max_size']             = 4500; //set max size allowed in Kilobyte
		// $config['max_width']            = 5000; // set max width image allowed
		// $config['max_height']           = 5000; // set max height allowed
		// $config['file_name']            = round(microtime(true) * 1000); //just milisecond timestamp fot unique name
   
		// $this->load->library('upload', $config);
		//    $this->upload->initialize($config);
		//   if(!$this->upload->do_upload('foto_npwp')) //upload and validate
		//   {
		// 	  $data['inputerror'][] = 'foto_npwp';
		// 	  $data['error_string'][] = 'Upload error: '.$this->upload->display_errors('',''); //show ajax error
		// 	  $data['status'] = FALSE;
		// 	  echo json_encode($data);
		// 	  exit();
		//   }
		//   return $this->upload->data('file_name');

		$target_dir = "./lampiran_registrasi/";
        $target_file = $target_dir . basename($_FILES["foto_npwp"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

 
        $source_image = $_FILES["foto_npwp"]["tmp_name"];
        $namaFile = "compressed_" . uniqid();
        $destination_image = $target_dir . $namaFile . "." . $imageFileType;

        // Define the new dimensions
        $max_width = 800;
        $max_height = 600;

        list($width, $height) = getimagesize($source_image);
        $ratio = min($max_width / $width, $max_height / $height);

        // Resize the image
        $new_width = $width * $ratio;
        $new_height = $height * $ratio;
        $new_image = imagecreatetruecolor($new_width, $new_height);

        if ($imageFileType == "jpg" || $imageFileType == "jpeg") {
            $image = imagecreatefromjpeg($source_image);
        } else if ($imageFileType == "png") {
            $image = imagecreatefrompng($source_image);
        }

        imagecopyresampled($new_image, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
        
        // Save the compressed image
        if ($imageFileType == "jpg" || $imageFileType == "jpeg") {
            imagejpeg($new_image, $destination_image, 90);
        } else if ($imageFileType == "png") {
            imagepng($new_image, $destination_image, 9);
        }
        return $namaFile.'.jpg';
  }


  	private function _do_upload_kk(){

		// $config['upload_path']          = './lampiran_registrasi/';
		// $config['allowed_types']        = 'gif|jpg|png|pdf|jpeg|JPG|JPEG|PNG|GIF';
		// $config['max_size']             = 4500; //set max size allowed in Kilobyte
		// $config['max_width']            = 5000; // set max width image allowed
		// $config['max_height']           = 5000; // set max height allowed
		// $config['file_name']            = round(microtime(true) * 1000); //just milisecond timestamp fot unique name

		// $this->load->library('upload', $config);
		// $this->upload->initialize($config);
		// if(!$this->upload->do_upload('foto_kk')) //upload and validate
		// {
		// 	$data['inputerror'][] = 'foto_kk';
		// 	$data['error_string'][] = 'Upload error: '.$this->upload->display_errors('',''); //show ajax error
		// 	$data['status'] = FALSE;
		// 	echo json_encode($data);
		// 	exit();
		// }
		// return $this->upload->data('file_name');

		$target_dir = "./lampiran_registrasi/";
        $target_file = $target_dir . basename($_FILES["foto_kk"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

 
        $source_image = $_FILES["foto_kk"]["tmp_name"];
        $namaFile = "compressed_" . uniqid();
        $destination_image = $target_dir . $namaFile . "." . $imageFileType;

        // Define the new dimensions
        $max_width = 800;
        $max_height = 600;

        list($width, $height) = getimagesize($source_image);
        $ratio = min($max_width / $width, $max_height / $height);

        // Resize the image
        $new_width = $width * $ratio;
        $new_height = $height * $ratio;
        $new_image = imagecreatetruecolor($new_width, $new_height);

        if ($imageFileType == "jpg" || $imageFileType == "jpeg") {
            $image = imagecreatefromjpeg($source_image);
        } else if ($imageFileType == "png") {
            $image = imagecreatefrompng($source_image);
        }

        imagecopyresampled($new_image, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
        
        // Save the compressed image
        if ($imageFileType == "jpg" || $imageFileType == "jpeg") {
            imagejpeg($new_image, $destination_image, 90);
        } else if ($imageFileType == "png") {
            imagepng($new_image, $destination_image, 9);
        }
        return $namaFile.'.jpg';

	}

	private function _do_upload_bpjs(){

		// $config['upload_path']          = './lampiran_registrasi/';
		// $config['allowed_types']        = 'gif|jpg|png|pdf|jpeg|JPG|JPEG|PNG|GIF';
		// $config['max_size']             = 4500; //set max size allowed in Kilobyte
		// $config['max_width']            = 5000; // set max width image allowed
		// $config['max_height']           = 5000; // set max height allowed
		// $config['file_name']            = round(microtime(true) * 1000); //just milisecond timestamp fot unique name

		// $this->load->library('upload', $config);
		// $this->upload->initialize($config);
		// if(!$this->upload->do_upload('foto_bpjs')) //upload and validate
		// {
		// 	$data['inputerror'][] = 'foto_bpjs';
		// 	$data['error_string'][] = 'Upload error: '.$this->upload->display_errors('',''); //show ajax error
		// 	$data['status'] = FALSE;
		// 	echo json_encode($data);
		// 	exit();
		// }
		// return $this->upload->data('file_name');

		$target_dir = "./lampiran_registrasi/";
        $target_file = $target_dir . basename($_FILES["foto_bpjs"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

 
        $source_image = $_FILES["foto_bpjs"]["tmp_name"];
        $namaFile = "compressed_" . uniqid();
        $destination_image = $target_dir . $namaFile . "." . $imageFileType;

        // Define the new dimensions
        $max_width = 800;
        $max_height = 600;

        list($width, $height) = getimagesize($source_image);
        $ratio = min($max_width / $width, $max_height / $height);

        // Resize the image
        $new_width = $width * $ratio;
        $new_height = $height * $ratio;
        $new_image = imagecreatetruecolor($new_width, $new_height);

        if ($imageFileType == "jpg" || $imageFileType == "jpeg") {
            $image = imagecreatefromjpeg($source_image);
        } else if ($imageFileType == "png") {
            $image = imagecreatefrompng($source_image);
        }

        imagecopyresampled($new_image, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
        
        // Save the compressed image
        if ($imageFileType == "jpg" || $imageFileType == "jpeg") {
            imagejpeg($new_image, $destination_image, 90);
        } else if ($imageFileType == "png") {
            imagepng($new_image, $destination_image, 9);
        }
        return $namaFile.'.jpg';
	}


	private function _do_upload_ktp_suami(){

		// $config['upload_path']          = './lampiran_registrasi/';
		// $config['allowed_types']        = 'gif|jpg|png|pdf|jpeg|JPG|JPEG|PNG|GIF';
		// $config['max_size']             = 4500; //set max size allowed in Kilobyte
		// $config['max_width']            = 5000; // set max width image allowed
		// $config['max_height']           = 5000; // set max height allowed
		// $config['file_name']            = round(microtime(true) * 1000); //just milisecond timestamp fot unique name

		// $this->load->library('upload', $config);
		// $this->upload->initialize($config);
		// if(!$this->upload->do_upload('foto_ktp_suami')) //upload and validate
		// {
		// 	$data['inputerror'][] = 'foto_ktp_suami';
		// 	$data['error_string'][] = 'Upload error: '.$this->upload->display_errors('',''); //show ajax error
		// 	$data['status'] = FALSE;
		// 	echo json_encode($data);
		// 	exit();
		// }
		// return $this->upload->data('file_name');

		$target_dir = "./lampiran_registrasi/";
        $target_file = $target_dir . basename($_FILES["foto_ktp_suami"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

 
        $source_image = $_FILES["foto_ktp_suami"]["tmp_name"];
        $namaFile = "compressed_" . uniqid();
        $destination_image = $target_dir . $namaFile . "." . $imageFileType;

        // Define the new dimensions
        $max_width = 800;
        $max_height = 600;

        list($width, $height) = getimagesize($source_image);
        $ratio = min($max_width / $width, $max_height / $height);

        // Resize the image
        $new_width = $width * $ratio;
        $new_height = $height * $ratio;
        $new_image = imagecreatetruecolor($new_width, $new_height);

        if ($imageFileType == "jpg" || $imageFileType == "jpeg") {
            $image = imagecreatefromjpeg($source_image);
        } else if ($imageFileType == "png") {
            $image = imagecreatefrompng($source_image);
        }

        imagecopyresampled($new_image, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
        
        // Save the compressed image
        if ($imageFileType == "jpg" || $imageFileType == "jpeg") {
            imagejpeg($new_image, $destination_image, 90);
        } else if ($imageFileType == "png") {
            imagepng($new_image, $destination_image, 9);
        }
        return $namaFile.'.jpg';
	}

	private function _do_upload_ktp_istri(){

		// $config['upload_path']          = './lampiran_registrasi/';
		// $config['allowed_types']        = 'gif|jpg|png|pdf|jpeg|JPG|JPEG|PNG|GIF';
		// $config['max_size']             = 4500; //set max size allowed in Kilobyte
		// $config['max_width']            = 5000; // set max width image allowed
		// $config['max_height']           = 5000; // set max height allowed
		// $config['file_name']            = round(microtime(true) * 1000); //just milisecond timestamp fot unique name

		// $this->load->library('upload', $config);
		// $this->upload->initialize($config);
		// if(!$this->upload->do_upload('foto_ktp_istri')) //upload and validate
		// {
		// 	$data['inputerror'][] = 'foto_ktp_istri';
		// 	$data['error_string'][] = 'Upload error: '.$this->upload->display_errors('',''); //show ajax error
		// 	$data['status'] = FALSE;
		// 	echo json_encode($data);
		// 	exit();
		// }
		// return $this->upload->data('file_name');

		$target_dir = "./lampiran_registrasi/";
        $target_file = $target_dir . basename($_FILES["foto_ktp_istri"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

 
        $source_image = $_FILES["foto_ktp_istri"]["tmp_name"];
        $namaFile = "compressed_" . uniqid();
        $destination_image = $target_dir . $namaFile . "." . $imageFileType;

        // Define the new dimensions
        $max_width = 800;
        $max_height = 600;

        list($width, $height) = getimagesize($source_image);
        $ratio = min($max_width / $width, $max_height / $height);

        // Resize the image
        $new_width = $width * $ratio;
        $new_height = $height * $ratio;
        $new_image = imagecreatetruecolor($new_width, $new_height);

        if ($imageFileType == "jpg" || $imageFileType == "jpeg") {
            $image = imagecreatefromjpeg($source_image);
        } else if ($imageFileType == "png") {
            $image = imagecreatefrompng($source_image);
        }

        imagecopyresampled($new_image, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
        
        // Save the compressed image
        if ($imageFileType == "jpg" || $imageFileType == "jpeg") {
            imagejpeg($new_image, $destination_image, 90);
        } else if ($imageFileType == "png") {
            imagepng($new_image, $destination_image, 9);
        }
        return $namaFile.'.jpg';
	}


	private function _do_upload_calon_pemilik(){

		// $config['upload_path']          = './lampiran_registrasi/';
		// $config['allowed_types']        = 'gif|jpg|png|pdf|jpeg|JPG|JPEG|PNG|GIF';
		// $config['max_size']             = 4500; //set max size allowed in Kilobyte
		// $config['max_width']            = 5000; // set max width image allowed
		// $config['max_height']           = 5000; // set max height allowed
		// $config['file_name']            = round(microtime(true) * 1000); //just milisecond timestamp fot unique name

		// $this->load->library('upload', $config);
		// $this->upload->initialize($config);
		// if(!$this->upload->do_upload('foto_calon_pemilik')) //upload and validate
		// {
		// 	$data['inputerror'][] = 'foto_calon_pemilik';
		// 	$data['error_string'][] = 'Upload error: '.$this->upload->display_errors('',''); //show ajax error
		// 	$data['status'] = FALSE;
		// 	echo json_encode($data);
		// 	exit();
		// }
		// return $this->upload->data('file_name');

		$target_dir = "./lampiran_registrasi/";
        $target_file = $target_dir . basename($_FILES["foto_calon_pemilik"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

 
        $source_image = $_FILES["foto_calon_pemilik"]["tmp_name"];
        $namaFile = "compressed_" . uniqid();
        $destination_image = $target_dir . $namaFile . "." . $imageFileType;

        // Define the new dimensions
        $max_width = 800;
        $max_height = 600;

        list($width, $height) = getimagesize($source_image);
        $ratio = min($max_width / $width, $max_height / $height);

        // Resize the image
        $new_width = $width * $ratio;
        $new_height = $height * $ratio;
        $new_image = imagecreatetruecolor($new_width, $new_height);

        if ($imageFileType == "jpg" || $imageFileType == "jpeg") {
            $image = imagecreatefromjpeg($source_image);
        } else if ($imageFileType == "png") {
            $image = imagecreatefrompng($source_image);
        }

        imagecopyresampled($new_image, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
        
        // Save the compressed image
        if ($imageFileType == "jpg" || $imageFileType == "jpeg") {
            imagejpeg($new_image, $destination_image, 90);
        } else if ($imageFileType == "png") {
            imagepng($new_image, $destination_image, 9);
        }
        return $namaFile.'.jpg';
	}


	private function _do_upload_bukti_transfer(){

		$target_dir = "./lampiran_registrasi/";
        $target_file = $target_dir . basename($_FILES["bukti_transfer"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

 
        $source_image = $_FILES["bukti_transfer"]["tmp_name"];
        $namaFile = "compressed_" . uniqid();
        $destination_image = $target_dir . $namaFile . "." . $imageFileType;

        // Define the new dimensions
        $max_width = 800;
        $max_height = 600;

        list($width, $height) = getimagesize($source_image);
        $ratio = min($max_width / $width, $max_height / $height);

        // Resize the image
        $new_width = $width * $ratio;
        $new_height = $height * $ratio;
        $new_image = imagecreatetruecolor($new_width, $new_height);

        if ($imageFileType == "jpg" || $imageFileType == "jpeg") {
            $image = imagecreatefromjpeg($source_image);
        } else if ($imageFileType == "png") {
            $image = imagecreatefrompng($source_image);
        }

        imagecopyresampled($new_image, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
        
        // Save the compressed image
        if ($imageFileType == "jpg" || $imageFileType == "jpeg") {
            imagejpeg($new_image, $destination_image, 90);
        } else if ($imageFileType == "png") {
            imagepng($new_image, $destination_image, 9);
        }


        return $namaFile.'.jpg';
  }



	public function berhasil($id)
	{
		$regist = $this->db->query("SELECT * FROM registrasi WHERE id_registrasi='$id'")->row_array();
		$data['nama'] = $regist['nama_lengkap'];
		$data['no_telp'] = $regist['no_telp'];
		$this->load->view('berhasil', $data);
	}


	public function ajax_select_kavling(){
        $this->db->select('id_kavling,kode_kavling');
        $this->db->like('kode_kavling',$this->input->get('q'),'both');
		// $this->db->where('status != "0"');
        $this->db->limit(20);
        $items=$this->db->get_where('kavling_peta', ['stt_booking'=> '0'])->result_array();
        //output to json format
        echo json_encode($items);
    }

	public function get($id){
		date_default_timezone_set("Asia/Jakarta");
		$sekarang = date('Y-m-d H:i:s');
        $item=$this->db->query("UPDATE kavling_peta k SET stt_booking='1', tgl_booking='$sekarang' WHERE k.id_kavling ='$id' ")->row_array();
        return $this->output->set_content_type('application/json')->set_output(json_encode($item));        
    }



	public function upload_image_method() {
		// $upload_path = "./lampiran_registrasi/";
		
		// if (!empty($_FILES['foto_ktp_suami'])) {
		// 	$config['upload_path'] = $upload_path;
		// 	$config['allowed_types'] = 'gif|jpg|jpeg|png';
		// 	$config['max_size'] = 5048; // in kilobytes
			
		// 	$this->load->library('upload', $config);
			
		// 	if ($this->upload->do_upload('foto_ktp_suami')) {
		// 		$upload_data = $this->upload->data();
		// 		echo json_encode(array('status' => 'success', 'message' => 'Image uploaded successfully.'));
		// 	} else {
		// 		echo json_encode(array('status' => 'error', 'message' => $this->upload->display_errors()));
		// 	}
		// } else {
		// 	echo json_encode(array('status' => 'error', 'message' => 'No image file received.'));
		// }

		$target_dir = "./lampiran_registrasi/";
        $target_file = $target_dir . basename($_FILES["foto_ktp_suami"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

 
        $source_image = $_FILES["foto_ktp_suami"]["tmp_name"];
        $namaFile = "compressed_" . uniqid();
        $destination_image = $target_dir . $namaFile . "." . $imageFileType;

        // Define the new dimensions
        $max_width = 800;
        $max_height = 600;

        list($width, $height) = getimagesize($source_image);
        $ratio = min($max_width / $width, $max_height / $height);

        // Resize the image
        $new_width = $width * $ratio;
        $new_height = $height * $ratio;
        $new_image = imagecreatetruecolor($new_width, $new_height);

        if ($imageFileType == "jpg" || $imageFileType == "jpeg") {
            $image = imagecreatefromjpeg($source_image);
        } else if ($imageFileType == "png") {
            $image = imagecreatefrompng($source_image);
        }

        imagecopyresampled($new_image, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
        
        // Save the compressed image
        if ($imageFileType == "jpg" || $imageFileType == "jpeg") {
            imagejpeg($new_image, $destination_image, 90);
        } else if ($imageFileType == "png") {
            imagepng($new_image, $destination_image, 9);
        }


        return $namaFile.'.jpg';

	}





}
