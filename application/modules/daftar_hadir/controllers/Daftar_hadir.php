<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Daftar_hadir extends CI_Controller {

   var $data_ref = array('uri_controllers' => 'daftar_hadir');

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Daftar_hadir_model','daftar_hadir');
		check_login();
	}

	public function index()
	{
		$user_data['data_ref'] = $this->data_ref;
		$this->load->view('template/header',$user_data);
		$this->load->view('view',$user_data);
	}


	public function edit($idCustomer)
	{

		$user_data['data_ref'] = $this->data_ref;
		$user_data['cust'] = $this->db->select('*, customer.nik as ktp')
		->join('kavling_peta', 'kavling_peta.id_kavling = customer.lokasi_kavling', 'left')
		->get_where('customer', ['customer.id_customer' => $idCustomer])->row_array();
			
		$this->load->view('template/header',$user_data);
		$this->load->view('detail',$user_data);

	}


	public function ajax_list()
	{

		$list = $this->daftar_hadir->get_datatables();
		$data = array();
		$no = $_POST['start'];

		foreach ($list as $post) {

			$link_edit = ' <a class="btn btn-xs btn-primary" href="javascript:void(0)" title="Edit" onclick="edit(' . "'" . $post->id_hadir . "'" . ')"> Edit</a>';
			$link_hapus = ' <a class="btn btn-xs btn-danger" href="javascript:void(0)" title="Hapus" onclick="hapus('."'".$post->id_hadir."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
			$link_kirim_pesan = ' <a class="btn btn-xs btn-warning" href="javascript:void(0)" title="Kirim Pesan" onclick="kirim_pesan('."'".$post->id_hadir."'".')">Kirim Pesan</a>';
			
// 			$cek_nomor_spr = $this->db->query("SELECT GROUP_CONCAT(nomor_spr) as xnomor_spr FROM spr WHERE id_customer = '".$post->id_customer."'")->row_array();

			$no++;
			$row = array();
			$row[] = $post->id_hadir;
			
			$a = '';
			$histori = $this->db->query("SELECT * FROM spr WHERE id_customer ='$post->id_customer'")->result();
			foreach($histori as $hs){
				$a .= $hs->nomor_spr.'<br>'.' <a class="btn btn-xs btn-success" target="_blank" href="'.base_url('spr/cetak_bintang/'.$hs->id_spr).'">Cetak SPR</a><br>';
			}
			$row[] = $a;
			
			$row[] = $post->tempat;
			$row[] = $post->tanggal;
			$row[] = $post->jam;
			$row[] = $post->lokasi_kavling;
			$row[] = $post->nama_lengkap;
			$row[] = rupiah((int)$post->hrg_ajb);
			$row[] = $post->jenis_pembelian == 0 ? 'CASH' : 'KPR';
			$row[] = $post->jenis_akad;
			$row[] = $post->nama_notaris;
			$row[] = $post->nama_bank.'<br>'.$post->no_rekening;
			$row[] = $post->ket;

			$row[] = $link_kirim_pesan.$link_edit.$link_hapus;

			$data[] = $row;
		}

		$output = array(
					"draw" => $_POST['draw'],
					"recordsTotal" => $this->daftar_hadir->count_all(),
					"recordsFiltered" => $this->daftar_hadir->count_filtered(),
					"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
    {
        $data = $this->daftar_hadir->get_by_id($id);
        echo json_encode($data);
    }

	public function ajax_update()
    {

        $data = array(
			'tempat' 			=> $this->input->post('tempat'),
			'tanggal' 			=> $this->input->post('tanggal_kehadiran'),
			'jam' 			=> $this->input->post('jam_kehadiran'),
			'id_kavling' 		=> $this->input->post('id_kavling'), 
			'lokasi_kavling' 	=> $this->input->post('lokasi_kavling'),
			'jenis_pembelian' 		=> $this->input->post('jenis_pembelian'),
			'id_notaris' 		=> $this->input->post('notaris'),
			'id_bank' 		=> $this->input->post('bank'),
			'no_rekening' 		=> $this->input->post('no_rekening'),
			'keterangan' 		=> $this->input->post('keterangan'),
			'harga_jual_ajb' 		=> str_replace('.', '', $this->input->post('harga_jual_ajb')),
		);

        $this->daftar_hadir->update(['id_hadir' => $this->input->post('id')], $data);
        echo json_encode(['status' => true]);
    }



	public function ajax_add()
	{
		$data = array(
		    'tempat' 			=> $this->input->post('tempat'),
			'tanggal' 			=> $this->input->post('tanggal_kehadiran'),
			'jam' 			=> $this->input->post('jam_kehadiran'),
			'id_kavling' 		=> $this->input->post('id_kavling'), 
			'lokasi_kavling' 	=> $this->input->post('lokasi_kavling'),
			'jenis_pembelian' 	=> $this->input->post('jenis_pembelian'),
			'jenis_akad' 		=> $this->input->post('jenis_akad'),
			'id_notaris' 		=> $this->input->post('notaris'),
			'id_bank' 		    => $this->input->post('bank'),
			'id_customer' 		=> $this->input->post('nama_customer'),
			'no_rekening' 		=> $this->input->post('no_rekening'),
			'keterangan' 		=> $this->input->post('keterangan'),
			'harga_jual_ajb' 		=> str_replace('.', '', $this->input->post('harga_jual_ajb')),
		);

		$this->db->insert('daftar_hadir', $data);
		

		// cek apakah AJB / PPJB
		// cari SPR yang terakhir untuk ID customer yang sama
		$idCust = $this->input->post('nama_customer');
		$cek = $this->db->query("SELECT * FROM spr WHERE id_customer = '$idCust' ORDER BY id_spr DESC LIMIT 0,1")->row_array();
		if($this->input->post('jenis_akad') == 'AJB'){
			$this->db->update('spr', ['stt_akad' => '1', 'status_spr' => '21'], ['id_spr' => $cek['id_spr']]);
		}else{
			$this->db->update('spr', ['stt_akad' => '2', 'status_spr' => '21'], ['id_spr' => $cek['id_spr']]);
		}
		
		$check_customer = $this->db->from('customer')->where('id_customer', $idCust)->get()->row();
		if($this->input->post('jenis_pembelian') <> $check_customer->jenis_bayar){
		    $this->buat_spr($idCust, 1);
		}
		
		$this->db->update('customer', ['status_customer' => '4'], ['id_customer' => $this->input->post('nama_customer')]);
		
		$db_notaris = $this->db->select('*')->from('notaris')->where('id_notaris', $this->input->post('notaris'))->get()->row_array();
		$jumlah_akad = $db_notaris['jumlah_akad']+1;
		$this->db->update('notaris', ['jumlah_akad' => $jumlah_akad], ['id_notaris' => $this->input->post('notaris')]);
		
		$this->db->update('kavling_peta', ['stt_kavling' => 4], ['id_kavling' => $this->input->post('id_kavling')]);
		
		echo json_encode(array("status" => TRUE));
	}



	public function ajax_delete($id)
	{
		$this->db->delete('daftar_hadir',array('id_hadir'=>$id));
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



	// download Lampiran

	function lampiran($nama_file){

        $config=array('orientation'=>'P','size'=>'A4');
        $this->load->library('MyPDF',$config);
        $this->mypdf->SetFont('Arial','B',10);
        $this->mypdf->SetLeftMargin(10);
        $this->mypdf->addPage();
        $this->mypdf->setTitle('Lampiran');
        $this->mypdf->SetFont('Arial','B',14);

		// $this->mypdf->Cell(190,10, 'Lapiran KTP',0,1,'C');
		$this->mypdf->Image(base_url().'lampiran_registrasi/'.$nama_file, 65, 20, 80);
		
        $this->mypdf->Output();
    }


    public function download()
		{
			$this->db->select('daftar_hadir.*, customer.nama_lengkap, notaris.nama_notaris, bank.nama_bank, spr.nomor_spr');
			$this->db->from('daftar_hadir');
			$this->db->join('customer', 'daftar_hadir.id_customer = customer.id_customer', 'left');
			$this->db->join('notaris', 'daftar_hadir.id_notaris = notaris.id_notaris', 'left');
			$this->db->join('bank', 'daftar_hadir.id_bank = bank.id_bank', 'left');
			$this->db->join('spr', 'customer.id_customer = spr.id_customer', 'left');
			
			$data['downData'] = $this->db->get()->result();
			$this->load->view('download', $data);
		}
		
	function kirim_pesan($id)
	{
	    $this->pesan_marketing($id);
	    $this->pesan_notaris($id);
	    $this->pesan_customer($id);
		
        echo json_encode(['status' => true]);
	}
	
	public function pesan_marketing($id)
	{
	    $this->db->select('daftar_hadir.*, customer.no_telp, customer.nama_lengkap, customer.nama_marketing, kavling_peta.model_rumah, kavling_peta.tipe_bangunan, kavling_peta.kode_kavling, kavling_peta.luas_tanah, keuangan_booking.nominal, customer.jenis_bayar');
	    $this->db->from('daftar_hadir');
	    $this->db->join('customer', 'daftar_hadir.id_customer = customer.id_customer', 'left');
	    $this->db->join('kavling_peta', 'customer.lokasi_kavling = kavling_peta.kode_kavling', 'left');
	    $this->db->join('keuangan_booking', 'customer.id_registrasi = keuangan_booking.id_registrasi', 'left');
	    $this->db->where('daftar_hadir.id_hadir', $id);
	    $daftar_hadir = $this->db->get()->row();
	    
	    $templatePesan = $this->db->get_where('template', ['nama_template' => 'pesan_marketing'])->row_array();
        $pesan = $templatePesan['isi_template'];
        $pesan = str_replace('[nama_marketing]', $daftar_hadir->nama_marketing, $pesan);
        $pesan = str_replace('[nama_lengkap]', $daftar_hadir->nama_lengkap, $pesan);
        $pesan = str_replace('[tanggal]', $daftar_hadir->tanggal, $pesan);
        $pesan = str_replace('[nominal]', rupiah($daftar_hadir->nominal), $pesan);
        $pesan = str_replace('[model_rumah]', $daftar_hadir->model_rumah, $pesan);
        $pesan = str_replace('[tipe_bangunan]', $daftar_hadir->tipe_bangunan, $pesan);
        $pesan = str_replace('[kode_kavling]', $daftar_hadir->kode_kavling, $pesan);
        $pesan = str_replace('[luas_tanah]', $daftar_hadir->luas_tanah, $pesan);
        $pesan = str_replace('[no_telp]', $daftar_hadir->no_telp, $pesan);
        if($daftar_hadir->jenis_bayar == 0){
            $jenis_bayar = 'KPR';
        }else{
            $jenis_bayar = 'CASH';
        }
        $pesan = str_replace('[jenis_bayar]', $jenis_bayar, $pesan);
			
		// Menggunakan WATZAP
		$age = array(
			"api_key"     => 'GB9LVQKMLM4U9MSR', 
            "number_key"  => 'lVVooZIudPClVqPo', 
			"phone_no"    => $daftar_hadir->no_telp_marketing,
			"message"     => $pesan
		);

		// jika verifikasi disetujui
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
		
		return true;
	}
	
	public function pesan_notaris($id)
	{
	    $this->db->select('daftar_hadir.*, bank.nama_bank, notaris.jumlah_akad, notaris.nama_notaris as notaris_nama_notaris, notaris.no_telp as no_telp_notaris, customer.no_telp, customer.nama_lengkap, customer.nama_marketing, kavling_peta.model_rumah, kavling_peta.tipe_bangunan, kavling_peta.kode_kavling, kavling_peta.luas_tanah, keuangan_booking.nominal, customer.jenis_bayar');
	    $this->db->from('daftar_hadir');
	    $this->db->join('customer', 'daftar_hadir.id_customer = customer.id_customer', 'left');
	    $this->db->join('kavling_peta', 'customer.lokasi_kavling = kavling_peta.kode_kavling', 'left');
	    $this->db->join('keuangan_booking', 'customer.id_registrasi = keuangan_booking.id_registrasi', 'left');
	    $this->db->join('notaris', 'notaris.id_notaris = daftar_hadir.id_notaris', 'left');
	    $this->db->join('bank', 'bank.id_bank = daftar_hadir.id_bank', 'left');
	    $this->db->where('daftar_hadir.id_hadir', $id);
	    $daftar_hadir = $this->db->get()->row();
	    
	    $templatePesan = $this->db->get_where('template', ['nama_template' => 'pesan_notaris'])->row_array();
        $pesan = $templatePesan['isi_template'];
        $pesan = str_replace('[nama_notaris]', $daftar_hadir->notaris_nama_notaris, $pesan);
        $pesan = str_replace('[jumlah_konsumen]', $daftar_hadir->jumlah_akad, $pesan);
        $pesan = str_replace('[bank]', $daftar_hadir->nama_bank, $pesan);
        $pesan = str_replace('[tanggal]', $daftar_hadir->tanggal, $pesan);
        $pesan = str_replace('[waktu]', $daftar_hadir->jam, $pesan);
        $pesan = str_replace('[harga_ajb]', rupiah($daftar_hadir->harga_jual_ajb), $pesan);
        $pesan = str_replace('[model_rumah]', $daftar_hadir->model_rumah, $pesan);
        $pesan = str_replace('[tipe_bangunan]', $daftar_hadir->tipe_bangunan, $pesan);
        $pesan = str_replace('[kode_kavling]', $daftar_hadir->kode_kavling, $pesan);
        $pesan = str_replace('[luas_tanah]', $daftar_hadir->luas_tanah, $pesan);
        if($daftar_hadir->jenis_bayar == 0){
            $jenis_bayar = 'KPR';
        }else{
            $jenis_bayar = 'CASH';
        }
        $pesan = str_replace('[jenis_bayar]', $jenis_bayar, $pesan);
			
		// Menggunakan WATZAP
		$age = array(
			"api_key"     => 'GB9LVQKMLM4U9MSR', 
            "number_key"  => 'lVVooZIudPClVqPo', 
			"phone_no"    => $daftar_hadir->no_telp_notaris,
			"message"     => $pesan
		);

		// jika verifikasi disetujui
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
		
		return true;
	}
	
	public function pesan_customer($id)
	{
	    $this->db->select('daftar_hadir.*, customer.no_telp, customer.nama_lengkap, customer.nama_marketing, kavling_peta.model_rumah, kavling_peta.tipe_bangunan, kavling_peta.kode_kavling, kavling_peta.luas_tanah, keuangan_booking.nominal, customer.jenis_bayar, bank.*');
	    $this->db->from('daftar_hadir');
	    $this->db->join('customer', 'daftar_hadir.id_customer = customer.id_customer', 'left');
	    $this->db->join('kavling_peta', 'customer.lokasi_kavling = kavling_peta.kode_kavling', 'left');
	    $this->db->join('keuangan_booking', 'customer.id_registrasi = keuangan_booking.id_registrasi', 'left');
	    $this->db->join('bank', 'bank.id_bank = daftar_hadir.id_bank', 'left');
	    $this->db->where('daftar_hadir.id_hadir', $id);
	    $daftar_hadir = $this->db->get()->row();
	    
	    $templatePesan = $this->db->get_where('template', ['nama_template' => 'pesan_customer'])->row_array();
        $pesan = $templatePesan['isi_template'];
        $pesan = str_replace('[nama_marketing]', $daftar_hadir->nama_marketing, $pesan);
        $pesan = str_replace('[nama_lengkap]', $daftar_hadir->nama_lengkap, $pesan);
        $pesan = str_replace('[tanggal]', $daftar_hadir->tanggal, $pesan);
        $pesan = str_replace('[nominal]', rupiah($daftar_hadir->nominal), $pesan);
        $pesan = str_replace('[model_rumah]', $daftar_hadir->model_rumah, $pesan);
        $pesan = str_replace('[tipe_bangunan]', $daftar_hadir->tipe_bangunan, $pesan);
        $pesan = str_replace('[kode_kavling]', $daftar_hadir->kode_kavling, $pesan);
        $pesan = str_replace('[luas_tanah]', $daftar_hadir->luas_tanah, $pesan);
        $pesan = str_replace('[no_telp]', $daftar_hadir->no_telp, $pesan);
        if($daftar_hadir->jenis_bayar == 0){
            $jenis_bayar = 'KPR';
        }else{
            $jenis_bayar = 'CASH';
        }
        $pesan = str_replace('[jenis_bayar]', $jenis_bayar, $pesan);
        
        
        $this->load->library('pdfgenerator');
        $data['title'] = "Undangan Akad Customer";
        $paper = 'A4';
        $orientation = "potrait";
        $file_pdf = 'Undangan Akad Konsumen '.$daftar_hadir->nama_lengkap;
        $html = $this->load->view('undangan', $daftar_hadir, true);
        // return $this->load->view('undangan', $daftar_hadir);
        $path = './assets/undangan_akad/'.$file_pdf;
        $this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation, $path, false);
        
	    // Menggunakan WATZAP
		$age = array(
			"api_key"     => 'GB9LVQKMLM4U9MSR', 
            "number_key"  => 'lVVooZIudPClVqPo', 
			"phone_no"    => $daftar_hadir->no_telp,
			"message"     => $pesan,
		);
		

		// jika verifikasi disetujui
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
		
		// Menggunakan WATZAP
		$age = array(
			"api_key"     => 'GB9LVQKMLM4U9MSR', 
            "number_key"  => 'lVVooZIudPClVqPo', 
			"phone_no"    => $daftar_hadir->no_telp,
			"url"           => 'https://app.panoramatamansari.com/assets/undangan_akad/'.$file_pdf.".pdf",
		);
		

		// jika verifikasi disetujui
		$json = json_encode($age);
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://api.watzap.id/v1/send_file_url',
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
		
		return true;
	}
	
	public function buat_spr($idCustomer ='', $sttSPR)
	{
		// echo $idCustomer;
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
		$lokasi = $cust['id_kavling'];
		$rumah = $this->db->query("SELECT * FROM kavling_peta WHERE id_kavling = '$lokasi'")->row_array();

		$param = array(
			'id_customer' 			=> $cust['id_customer'],
			'id_kavling' 			=> $cust['id_kavling'],
			'kode_kavling' 			=> $cust['lokasi_kavling'],
			'tipe_rumah' 			=> $cust['tipe_unit'],
			'id_marketing' 			=> $cust['id_marketing'],
			'nama_marketing' 		=> $cust['nama_marketing'],
			'luas_tanah' 			=> $rumah['luas_tanah'],
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
			'harga_rumah' 			=> $rumah['hrg_jual'],
			'harga_diskon' 			=> $rumah['harga_diskon'],
			'booking_fee_spr' 		=> $cust['booking_fee'],
			'status_spr'			=> $sttSPR
		);
		$this->db->insert('spr', $param);

	}
	
	public function ajax_select_customer(){
	
        // $items = $this->db->query("SELECT b.id_customer, b.nama_lengkap FROM spr a LEFT JOIN customer b ON a.id_customer = b.id_customer WHERE b.nama_lengkap LIKE '%".$this->input->get('q')."%' AND a.status_spr IN (0, 11, 12) GROUP BY b.id_customer, b.nama_lengkap")->result_array();
				$items = $this->db->query("SELECT b.id_customer, b.nama_lengkap FROM spr a 
				LEFT JOIN customer b ON a.id_customer = b.id_customer 
				JOIN cicilan_dp c ON a.id_customer = c.id_customer
				WHERE b.nama_lengkap LIKE '%".$this->input->get('q')."%' AND a.status_spr IN (0, 11, 12) AND c.status = 'Lunas' 
				GROUP BY b.id_customer, b.nama_lengkap")->result_array();

        //output to json format
        echo json_encode($items);
    }
}
