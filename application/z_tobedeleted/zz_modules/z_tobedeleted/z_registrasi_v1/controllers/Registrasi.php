<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registrasi extends CI_Controller {

   var $data_ref = array('uri_controllers' => 'registrasi');

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Registrasi_model','registrasi');
		// $this->load->model('Group/Group_model','group');
		check_login();
	}

	public function index()
	{

		$user_data['data_ref'] = $this->data_ref;
		$user_data['title'] = 'Menu';
		$this->load->view('template/header');
		$this->load->view('view',$user_data);
	}

	public function ajax_list()
	{

		$list = $this->registrasi->get_datatables();
		$data = array();
		$no = $_POST['start'];


		foreach ($list as $post) {

			$link_detail = '<a class="btn btn-xs btn-warning" href="'.base_url('registrasi/detail/'.$post->id_registrasi).'" > Detail</a>';
			$link_edit = '<a class="btn btn-xs btn-primary" href="'.base_url('registrasi/verifikasi/'.$post->id_registrasi).'" > Verifkasi</a>';
			$link_hapus = ' <a class="btn btn-xs btn-danger" href="javascript:void(0)" title="Hapus" onclick="hapus('."'".$post->id_registrasi."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';

			$no++;
			$row = array();
         	$row[] = $no;
         	$row[] = $post->nama_lengkap.'<br>'.$post->nik;
         	$row[] = $post->nama_marketing;
         	$row[] = $post->email;
         	$row[] = $post->no_telp;
         	$row[] = $post->kode_kavling;
			if($post->status_registrasi == '0'){
				$row[] = '<span class="badge badge-pill badge-danger">Registrasi</span>';
			}else if($post->status_registrasi == '1'){
				$row[] = '<span class="badge badge-pill badge-success">Verifikasi</span>';
			}
         	
			//add html for action
			if($post->status_registrasi == '0'){
				$row[] = $link_edit.$link_hapus;
			}else{
				$row[] = $link_detail.$link_hapus;
			}
			
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->registrasi->count_all(),
						"recordsFiltered" => $this->registrasi->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->registrasi->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_add()
	{
		aktifitas('Login','Melakukan Penambahan registrasi');
		$data = array(
				'nama_agen' 		=> $this->input->post('nama_agen'),
				'nama_singkat' 		=> $this->input->post('nama_singkat'),
				'nama_kepala' 		=> $this->input->post('nama_kepala'),
				'npwp' 			=> $this->input->post('npwp'),
            	'email' 		=> $this->input->post('email'),
            	'no_wa' 		=> $this->input->post('no_wa'),
            	'alamat' 		=> $this->input->post('alamat'),
				'username' 		=> $this->input->post('username'),
            	'password' 		=> password_hash($this->input->post('password'), PASSWORD_DEFAULT)
		);

		$insert = $this->registrasi->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function proses_registrasi()
	{
		aktifitas('Verifikasi Registrasi','Melakukan simpan perubahan data registrasi');

		// cek apakah verifikasi setujui atau pending
		if($this->input->post('verifikasi') == '1'){
			$paramCust = [
				'id_registrasi' 				=> $this->input->post('id_registrasi'),
				'nama_lengkap' 					=> $this->input->post('nama_lengkap'),
				'nik' 							=> $this->input->post('nik'),
				'npwp' 							=> $this->input->post('nama_lengkap'),
				'kartu_keluarga' 				=> $this->input->post('kartu_keluarga'),
				'bpjs_tk' 						=> $this->input->post('bpjs_tk'),
				'booking_fee' 					=> $this->input->post('booking_fee'),
				'nama_marketing' 				=> $this->input->post('nama_marketing'),
				'email' 						=> $this->input->post('email'),
				'no_telp' 						=> $this->input->post('no_telp'),
				'nama_perusahaan' 				=> $this->input->post('nama_perusahaan'),
				'alamat_kantor' 				=> $this->input->post('alamat_kantor'),
				'telp_kantor' 					=> $this->input->post('telp_kantor'),
				'nama_saudara' 					=> $this->input->post('nama_saudara'),
				'alamat' 						=> $this->input->post('alamat'),
				'no_telp_saudara' 				=> $this->input->post('no_telp_saudara'),
				'lokasi_kavling' 				=> $this->input->post('lokasi_kavling_id'),
				'tipe_unit' 					=> $this->input->post('tipe_unit'),
				'pengalaman_interaksi' 			=> $this->input->post('pengalaman_interaksi'),
				'password'			 			=> password_hash($this->input->post('pass_registrasi'), PASSWORD_DEFAULT),
				'foto_ktp' 						=> $this->input->post('foto_ktp'),
				'foto_npwp' 					=> $this->input->post('foto_npwp'),
				'foto_kk' 						=> $this->input->post('foto_kk'),
				'foto_bpjs' 					=> $this->input->post('foto_bpjs'),
				'foto_ktp_suami' 					=> $this->input->post('foto_ktp_suami'),
				'foto_ktp_istri' 					=> $this->input->post('foto_ktp_istri'),
				'foto_calon_pemilik' 				=> $this->input->post('foto_calon_pemilik'), 
				'bukti_transfer' 					=> $this->input->post('bukti_transfer')
			];
			// cek apakah data sudah ada
			$idREG = $this->input->post('id_registrasi');
			$cek = $this->db->get_where('customer', ['id_registrasi' => $idREG])->num_rows();
			if($cek){
				// Jika data sudah ada di tabel cistomer tinggal update saja
				$this->db->update('customer', $paramCust, ['id_registrasi' => $idREG]);
			}else{
				// masukkan ke dalam data Customer
				$this->db->insert('customer', $paramCust);
				$idCust = $this->db->insert_id();
				// Buat SPR sesuai data registrasi
				$this->buat_spr($idCust);
			}

			// cari data customer
			$cust = $this->db->query("SELECT * FROM customer WHERE id_registrasi='$idREG'")->row_array();

			// update peta kavling
			$param = array(
				'id_customer' 		=> $cust['id_customer'], 
				'stt_kavling' 		=> $this->input->post('status_kavling')
			);
			$this->db->update('kavling_peta', $param, ['id_kavling' => $this->input->post('lokasi_kavling_id')]);


			// Update status registrasi
			$data = array(
				'status_registrasi' 			=> '1', 
				'pass_registrasi' 			=> $this->input->post('pass_registrasi')
			);
			$this->registrasi->update(array('id_registrasi' => $this->input->post('id_registrasi')), $data);

			
			
		}else{
			
			// Simpan tanpa membuat SPR
			$paramCust = [
				'id_registrasi' 				=> $this->input->post('id_registrasi'),
				'nama_lengkap' 					=> $this->input->post('nama_lengkap'),
				'nik' 							=> $this->input->post('nik'),
				'npwp' 							=> $this->input->post('nama_lengkap'),
				'kartu_keluarga' 				=> $this->input->post('kartu_keluarga'),
				'bpjs_tk' 						=> $this->input->post('bpjs_tk'),
				'booking_fee' 					=> $this->input->post('booking_fee'),
				'nama_marketing' 				=> $this->input->post('nama_marketing'),
				'email' 						=> $this->input->post('email'),
				'no_telp' 						=> $this->input->post('no_telp'),
				'nama_perusahaan' 				=> $this->input->post('nama_perusahaan'),
				'alamat_kantor' 				=> $this->input->post('alamat_kantor'),
				'telp_kantor' 					=> $this->input->post('telp_kantor'),
				'nama_saudara' 					=> $this->input->post('nama_saudara'),
				'alamat' 						=> $this->input->post('alamat'),
				'no_telp_saudara' 				=> $this->input->post('no_telp_saudara'),
				'lokasi_kavling' 				=> $this->input->post('lokasi_kavling_id'),
				'tipe_unit' 					=> $this->input->post('tipe_unit'),
				'pengalaman_interaksi' 			=> $this->input->post('pengalaman_interaksi'),
				'password'			 			=> password_hash($this->input->post('pass_registrasi'), PASSWORD_DEFAULT),
				'foto_ktp' 						=> $this->input->post('foto_ktp'),
				'foto_npwp' 					=> $this->input->post('foto_npwp'),
				'foto_kk' 						=> $this->input->post('foto_kk'),
				'foto_bpjs' 					=> $this->input->post('foto_bpjs'),
				'foto_ktp_suami' 					=> $this->input->post('foto_ktp_suami'),
				'foto_ktp_istri' 					=> $this->input->post('foto_ktp_istri'),
				'foto_calon_pemilik' 				=> $this->input->post('foto_calon_pemilik'), 
				'bukti_transfer' 					=> $this->input->post('bukti_transfer')
			];
			// cek apakah data sudah ada
			$idREG = $this->input->post('id_registrasi');
			$cek = $this->db->get_where('customer', ['id_registrasi' => $idREG])->num_rows();
			if($cek){
				// Jika data sudah ada di tabel cistomer tinggal update saja
				$this->db->update('customer', $paramCust, ['id_registrasi' => $idREG]);
			}else{
				// masukkan ke dalam data Customer
				$this->db->insert('customer', $paramCust);
				$idCust = $this->db->insert_id();
			}

			// update peta kavling
			$param = array(
				'id_customer' 		=> $cust['id_customer'], 
				'stt_kavling' 		=> $this->input->post('status_kavling')
			);
			$this->db->update('kavling_peta', $param, ['id_kavling' => $this->input->post('lokasi_kavling_id')]);

		}

		


		//cari nomor penerima
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
          
$penerima = $nowa;

$link = base_url('logincustomer');

$templatePesan = $this->db->get_where('template', ['jenis_pesan' => 'verifikasi'])->row_array();
$pesan = $templatePesan['isi_template'];
$pesan = str_replace('[nama]', $nama, $pesan);
$pesan = str_replace('[link_login]', $link, $pesan);
$pesan = str_replace('[username]', $this->input->post('email'), $pesan);
$pesan = str_replace('[password]', $this->input->post('pass_registrasi'), $pesan);

			
		// Menggunakan WATZAP
		$age = array(
			"api_key"     => 'GFD3CFOCP0TDKMZS', 
            "number_key"  => 'C2sZykYFKtW0GMiu', 
			"phone_no"    => $penerima,
			"message"     => $pesan
		);

		// jika verifikasi disetujui
		if($this->input->post('kirim_pesan') == '1'){
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
		}
			
		
		redirect('registrasi');
	}

	public function verifikasi($id)
	{
		aktifitas('Verifikasi Registrasi',"Membuka Data registrasi dengan ID : ".$id);
		$user_data['reg'] = $this->db->join('kavling_peta', 'kavling_peta.id_kavling = registrasi.lokasi_kavling', 'left')
		->join('marketing', 'marketing.id_marketing = registrasi.nama_marketing', 'left')
		->get_where('registrasi', ['id_registrasi' => $id])->row_array();
		// jika sudah di setujui

		if($user_data['reg']['status_registrasi'] == '1'){
			$user_data['password'] = $user_data['reg']['pass_registrasi'];
		}else{
			$user_data['password'] = $this->generateRandomPassword();
		}
		
		$this->load->view('template/header');
		$this->load->view('verifikasi',$user_data);
	}


	public function detail($id)
	{
		// aktifitas('Login','Melakukan Hapus Data registrasi');
		$user_data['reg'] = $this->db->join('kavling_peta', 'kavling_peta.id_kavling = registrasi.lokasi_kavling', 'left')
		->get_where('registrasi', ['id_registrasi' => $id])->row_array();
		// jika sudah di setujui

		if($user_data['reg']['status_registrasi'] == '1'){
			$user_data['password'] = $user_data['reg']['pass_registrasi'];
		}else{
			$user_data['password'] = $this->generateRandomPassword();
		}
		
		
		$this->load->view('template/header');
		$this->load->view('detail',$user_data);
	}

	function generateRandomPassword($length = 12) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$password = '';
	
		for ($i = 0; $i < $length; $i++) {
			$randomIndex = mt_rand(0, strlen($characters) - 1);
			$password .= $characters[$randomIndex];
		}
	
		return $password;
	}


	
	public function ajax_delete($id)
	{
		$this->registrasi->delete_by_id($id);

		aktifitas('Hapus Data','Melakukan Hapus Data registrasi');
		$username = $this->encryption->decrypt($this->session->userdata('username'));
		$pesan = 'User *'.$username.'* Telah mengapus data registrasi dengan ID : '.$id;
		// kirim pesan ke user terdaftar
		$user = $this->db->get_where('users', ['kirim_notif'=> '1'])->result();
		foreach($user as $us){

			//cari nomor penerima
			$wa = $us->no_wa;
			$wa = str_replace(' ','',$wa);
			$wa = str_replace('-','',$wa);
			$belakang = substr($wa,1);
			$awal = substr($wa,0,1);
			
			if($awal == '0'){
			$nowa = '62'.$belakang;
			}else{
			$nowa = $wa;
			}
			$penerima = $nowa;

			// Menggunakan WATZAP
			$age = array(
				"api_key"     => 'GFD3CFOCP0TDKMZS', 
                "number_key"  => 'C2sZykYFKtW0GMiu', 
				"phone_no"    => $penerima,
				"message"     => $pesan
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

		}
		echo json_encode(array("status" => TRUE));
	}


	public function buat_spr($idCustomer ='')
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
		$cust = $this->db->query("SELECT * FROM customer WHERE id_customer = '$idCustomer'")->row_array();
		// Cari harga Rumah
		$lokasi = $cust['lokasi_kavling'];
		$rumah = $this->db->query("SELECT * FROM kavling_peta WHERE id_kavling = '$lokasi'")->row_array();

		$param = array(
			'id_customer' 			=> $cust['id_customer'],
			'nomor_spr' 			=> $noTraSekarang,
			'id_kavling' 			=> $cust['lokasi_kavling'],
			'tanggal_spr' 			=> $tanggal,
			'jam_spr' 				=> $jam,
			'harga_rumah' 			=> $rumah['hrg_jual'],
			'booking_fee_spr' 		=> $cust['booking_fee'],
			'catatan' 				=> '',
			'status_spr' 			=> '0'
		);
		$this->db->insert('spr', $param);

		$this->db->update('customer', ['status_customer' => '2'], ['id_customer' => $this->input->post('nama_lengkap')]);

		echo json_encode(array("status" => TRUE));
	}
	

}
