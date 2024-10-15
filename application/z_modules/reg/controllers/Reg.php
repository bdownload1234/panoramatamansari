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


	public function ajax_add(){

        $this->_validate();
		$data = array(
			'nama_lengkap' 					=> $this->input->post('nama_lengkap'),
			'no_registrasi' 				=> $this->no_reg(),
			'tgl_registrasi' 				=> date('Y-m-d'),
			'nik' 							=> $this->input->post('nik'),
			'npwp' 							=> $this->input->post('npwp'),
			'kartu_keluarga' 				=> $this->input->post('kartu_keluarga'),
			'bpjs_tk' 						=> $this->input->post('bpjs_tk'),
			'booking_fee' 					=> str_replace('.', '', $this->input->post('booking_fee')),
			'nama_marketing' 				=> $this->input->post('nama_marketing'),
			'email' 						=> $this->input->post('email'),
			'no_telp' 						=> $this->input->post('no_telp'),
			'nama_perusahaan' 				=> $this->input->post('nama_perusahaan'),
			'telp_kantor' 					=> $this->input->post('telp_kantor'),
			'alamat_kantor' 				=> $this->input->post('alamat_kantor'),
			'nama_saudara' 					=> $this->input->post('nama_saudara'),
			'hubungan_saudara' 				=> $this->input->post('hubungan_saudara'),
			'alamat' 						=> $this->input->post('alamat'),
			'no_telp_saudara' 				=> $this->input->post('no_telp_saudara'),
			'lokasi_kavling' 				=> $this->input->post('lokasi_kavling'),
			'tipe_unit' 					=> $this->input->post('tipe_unit_2'),
			'pengalaman_interaksi' 			=> $this->input->post('pengalaman_interaksi'),
			'sumber_lain'       			=> $this->input->post('sumber_lain'),
			'persetujuan' 					=> $this->input->post('persetujuan'),
			'status_registrasi' 			=> '1'
		);

		$this->db->update('registrasi', $data, ['nik' => $this->input->post('nik')]);

        $useReg = $this->db->get_where('registrasi', ['nik' => $this->input->post('nik')])->row_array();
        $id = $useReg['id_registrasi'];

		// update peta kavling jadi terbooking
		$this->db->update('kavling_peta', ['stt_kavling'=> '3', 'nik' => $this->input->post('nik')], ['id_kavling' => $this->input->post('lokasi_kavling')]);

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
        $templatePesan = $this->db->get_where('template', ['jenis_pesan' => 'registrasi'])->row_array();
        $pesan = $templatePesan['isi_template'];
        $pesan = str_replace('[nama]', $nama, $pesan);

        date_default_timezone_set("Asia/Jakarta");
        $paramKirim = [
            'no_tujuan' 	   => $nowa, 
            'isi_pesan' 	   => $pesan, 
            'tgl_simpan' 	   => date('Y-m-d H:i:s'),
            'jenis_pesan' 	   => 'Registrasi', 
            'stt_pesan'        => '0'
        ];
        $this->db->insert('kirim', $paramKirim);
  
		// $data['nama'] = $this->input->post('nama_lengkap');
		// redirect('reg/berhasil/'.$id);
        echo json_encode(array("status" => TRUE));   
	}



	function do_upload_ktp($nik){

        sleep(2);

		$target_dir = "./lampiran_registrasi/";
        $target_file = $target_dir . basename($_FILES["foto_ktp"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png") {
            http_response_code(415); // Set HTTP response code to 415 (Unsupported Media Type)
            echo "Format file tidak didukung. Harap unggah file JPG atau PNG.";
            exit;
        }

 
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

        $namaFileUpload = $namaFile.'.jpg';
        $this->db->update('registrasi', ['foto_ktp' => $namaFileUpload], ['nik' => $nik]);
        sleep(2);
        
        return $namaFile.'.jpg';
  }


    function do_upload_npwp($nik){

		$target_dir = "./lampiran_registrasi/";
        $target_file = $target_dir . basename($_FILES["foto_npwp"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png") {
            http_response_code(415); // Set HTTP response code to 415 (Unsupported Media Type)
            echo "Format file tidak didukung. Harap unggah file JPG atau PNG.";
            exit;
        }

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

        $namaFileUpload = $namaFile.'.jpg';
        $this->db->update('registrasi', ['foto_npwp' => $namaFileUpload], ['nik' => $nik]);
        sleep(2);

        return $namaFile.'.jpg';
    }


  	function do_upload_kk($nik){

        

		$target_dir = "./lampiran_registrasi/";
        $target_file = $target_dir . basename($_FILES["foto_kk"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png") {
            http_response_code(415); // Set HTTP response code to 415 (Unsupported Media Type)
            echo "Format file tidak didukung. Harap unggah file JPG atau PNG.";
            exit;
        }

 
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

        $namaFileUpload = $namaFile.'.jpg';
        $this->db->update('registrasi', ['foto_kk' => $namaFileUpload], ['nik' => $nik]);
        sleep(2);

        return $namaFile.'.jpg';

	}

	function do_upload_bpjs($nik){

		$target_dir = "./lampiran_registrasi/";
        $target_file = $target_dir . basename($_FILES["foto_bpjs"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png") {
            http_response_code(415); // Set HTTP response code to 415 (Unsupported Media Type)
            echo "Format file tidak didukung. Harap unggah file JPG atau PNG.";
            exit;
        }

 
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

        $namaFileUpload = $namaFile.'.jpg';
        $this->db->update('registrasi', ['foto_bpjs' => $namaFileUpload], ['nik' => $nik]);
        sleep(2);
        
        return $namaFile.'.jpg';
	}


	function do_upload_ktp_istri($nik){

		$target_dir = "./lampiran_registrasi/";
        $target_file = $target_dir . basename($_FILES["foto_ktp_istri"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png") {
            http_response_code(415); // Set HTTP response code to 415 (Unsupported Media Type)
            echo "Format file tidak didukung. Harap unggah file JPG atau PNG.";
            exit;
        }

 
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

        $namaFileUpload = $namaFile.'.jpg';
        $this->db->update('registrasi', ['foto_ktp_istri' => $namaFileUpload], ['nik' => $nik]);
        sleep(2);
        
        return $namaFile.'.jpg';
	}


	function do_upload_calon_pemilik($nik){

		$target_dir = "./lampiran_registrasi/";
        $target_file = $target_dir . basename($_FILES["foto_calon_pemilik"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png") {
            http_response_code(415); // Set HTTP response code to 415 (Unsupported Media Type)
            echo "Format file tidak didukung. Harap unggah file JPG atau PNG.";
            exit;
        }

 
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

        $namaFileUpload = $namaFile.'.jpg';
        $this->db->update('registrasi', ['foto_calon_pemilik' => $namaFileUpload], ['nik' => $nik]);
        sleep(2);
        
        return $namaFile.'.jpg';
	}


	function do_upload_bukti_transfer($nik){

		$target_dir = "./lampiran_registrasi/";
        $target_file = $target_dir . basename($_FILES["bukti_transfer"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png") {
            http_response_code(415); // Set HTTP response code to 415 (Unsupported Media Type)
            echo "Format file tidak didukung. Harap unggah file JPG atau PNG.";
            exit;
        }

 
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

        $namaFileUpload = $namaFile.'.jpg';
        $this->db->update('registrasi', ['bukti_transfer' => $namaFileUpload], ['nik' => $nik]);
        sleep(2);
        
        return $namaFile.'.jpg';
  }



	public function berhasil($nik)
	{
        $query = "SELECT * FROM registrasi r 
        LEFT JOIN kavling_peta p ON r.lokasi_kavling = p.id_kavling 
        WHERE r.nik='$nik'";
        $cek = $this->db->query($query)->num_rows();
		
        if($cek){
            $regist = $this->db->query($query)->row_array();
            $data['nama'] = $regist['nama_lengkap'];
            $data['no_telp'] = $regist['no_telp'];
            $data['blok'] = $regist['kode_kavling'];
            $this->load->view('berhasil', $data);
        }else{
            $this->load->view('gagal');
        }
		
	}


	public function ajax_select_kavling(){
        $this->db->select('id_kavling,kode_kavling');
        $this->db->like('kode_kavling',$this->input->get('q'),'both');
		// $this->db->where('status != "0"');
        $this->db->limit(20);
        $items=$this->db->get_where('kavling_peta', ['stt_kavling'=> '1'])->result_array();
        //output to json format
        echo json_encode($items);
    }

	public function get($id){
		date_default_timezone_set("Asia/Jakarta");
		$sekarang = date('Y-m-d H:i:s');
        $item=$this->db->query("UPDATE kavling_peta k SET stt_kavling='1', tgl_booking='$sekarang' WHERE k.id_kavling ='$id' ");
        return $this->output->set_content_type('application/json')->set_output(json_encode($item));        
    }



	public function upload_image_method($nik) {


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

        $namaFileUpload = $namaFile.'.jpg';
        $this->db->update('registrasi', ['foto_ktp_suami' => $namaFileUpload], ['nik' => $nik]);
        sleep(2);
        
        return $namaFile.'.jpg';

	}


    public function simpan_nik($nik){
		date_default_timezone_set("Asia/Jakarta");
		$sekarang = date('Y-m-d H:i:s');
        $reg = $this->db->query("SELECT * FROM registrasi WHERE nik ='$nik'");
        if($reg->num_rows() > 0){
            // update data
        }else{
            // insert baru
            $param = [
                'nama_lengkap'  => '', 
                'nik'           => $nik
            ];
            $this->db->insert('registrasi', $param);
        }
        // return $this->output->set_content_type('application/json')->set_output(json_encode($item));     
        echo json_encode(array("status" => TRUE));   
    }


    public function ajax_kirim(){
		date_default_timezone_set("Asia/Jakarta");
		$sekarang = date('Y-m-d H:i:s');
        $reg = $this->db->query("SELECT * FROM kirim WHERE stt_pesan ='0'")->row_array();

        		$age = array(
            "api_key"     => 'GFD3CFOCP0TDKMZS', 
            "number_key"  => 'C2sZykYFKtW0GMiu', 
			"phone_no"    => $reg['no_tujuan'],
			"message"     => $reg['isi_pesan']
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

        // echo $response;

        // simpan respon server
        $param = [
            'tgl_kirim'     => date('Y-m-d H:i:s'), 
            'respon_server' => $response, 
            'stt_pesan'     => '1'
        ];
        $this->db->update('kirim', $param, ['no_tujuan' => $reg['no_tujuan'], 'jenis_pesan' => 'Registrasi']);
 
        echo json_encode(array("status" => TRUE));   
    }


    private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('nama_lengkap') == '')
		{
			$data['inputerror'][] = 'nama_lengkap';
			$data['error_string'][] = 'nama Lengkap harus diisi';
			$data['status'] = FALSE;
		}

		if($this->input->post('nik') == '')
		{
			$data['inputerror'][] = 'nik';
			$data['error_string'][] = 'nik harus diisi';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}


    


	public function no_reg()
	{
		//buat nomor registrasi
		$tahun = date('Y');
		$nomor = $this->db->query("SELECT MAX(no_registrasi) as besar FROM registrasi WHERE no_registrasi like '%$tahun'")->row_array();
		$noSekarangTRX = $nomor['besar'];
		$urutanTRX = (int) substr($noSekarangTRX, 0, 4);
		$urutanTRX++;
		$hurufTRX = "-BPT-$tahun";
		$noTraSekarang = sprintf("%04s", $urutanTRX).$hurufTRX;
		return $noTraSekarang;

	}
	
	
	public function get_rumah($id){

        $item=$this->db->query("SELECT * FROM kavling_peta WHERE id_kavling ='$id' ")->row_array();
        $item['hrg_jual'] = rupiah($item['hrg_jual']);

        return $this->output->set_content_type('application/json')->set_output(json_encode($item));        
    }


}
