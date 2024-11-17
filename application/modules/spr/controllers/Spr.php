<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Spr extends CI_Controller {

   var $data_ref = array('uri_controllers' => 'spr');

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Spr_model','spr');
		// $this->load->model('Group/Group_model','group');

		check_login();
	}

	public function index()
	{
		$user_data['data_ref'] = $this->data_ref;
		//buat nomor_transaksi
		$tahun = date('Y');
		$nomor = $this->db->query("SELECT MAX(nomor_spr) as besar FROM spr WHERE nomor_spr like '%$tahun'")->row_array();
		$noSekarangTRX = $nomor['besar'];
		$urutanTRX = (int) substr($noSekarangTRX, 0, 5);
		$urutanTRX++;
		$hurufTRX = "/SPR-PTS/$tahun";
		$noTraSekarang = sprintf("%05s", $urutanTRX).$hurufTRX;
		$user_data['notrx'] = $noTraSekarang;

		$this->load->view('template/header',$user_data);
		$this->load->view('view',$user_data);
	}


	public function ajax_list()
	{

		$list = $this->spr->get_datatables();
		$data = array();
		$no = $_POST['start'];

		foreach ($list as $post) {

			$link_edit = '<a class="btn btn-xs btn-warning" href="javascript:void(0)" onclick="edit('."'".$post->id_spr."'".')"> Edit SPR</a>';
			$link_cetak = ' <a class="btn btn-xs btn-success" target="_blank" href="'.base_url('spr/cetak/'.$post->id_spr).'">Cetak SPR</a>';
			
			if($post->status_customer == 2){
			    $link_pindah = '';
			}else{
			    $link_pindah = ' <a class="btn btn-xs btn-info" href="javascript:void(0)" onclick="pindah('."'".$post->id_spr."'".')"> Pindah Kavling</a>';
			}
			
			$link_ganti = ' <a class="btn btn-xs btn-info" href="javascript:void(0)" onclick="ganti('."'".$post->id_spr."'".')"> Ganti Nama</a>';

			$link_hapus = ' <a class="btn btn-xs btn-danger" href="javascript:void(0)" title="Hapus" onclick="hapus('."'".$post->id_spr."'".')">Batalkan</a>';

			$no++;
			$row = array();
         	$row[] = $no;
         	$row[] = $post->nomor_spr.'<br>'.$link_cetak;
         	$row[] = $post->nama_lengkap.'<br>'.$post->no_telp;;
         	$row[] = $post->kode_kavling;
			$row[] = $post->nomor_va;
// 			$row[] = $post->status_spr;

            if($post->status_spr == '0'){
				$row[] = '<span class="badge badge-pill badge-info">SPR</span>';
			}else if($post->status_spr == '11'){
				$row[] = '<span class="badge badge-pill badge-success">Pindah Kavling</span>';
			}else if($post->status_spr == '12'){
				$row[] = '<span class="badge badge-pill badge-warning">Ganti Nama</span>';
			}else if($post->status_spr == '21'){
				$row[] = '<span class="badge badge-pill badge-primary">AKAD</span>';
			}else{
				$row[] = '<span class="badge badge-pill badge-secondary">HOLD</span>';
			}
			
			$row[] = $link_edit.$link_pindah.$link_ganti.$link_hapus;
			$data[] = $row;
		}
		$output = array(
					"draw" => $_POST['draw'],
					"recordsTotal" => $this->spr->count_all(),
					"recordsFiltered" => $this->spr->count_filtered(),
					"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}



	public function ajax_edit($id)
	{
		$data = $this->db->get_where('spr', ['id_spr' => $id])->row();
		$data->harga_rumah = rupiah($data->harga_rumah);
		$data->booking_fee_spr = rupiah($data->booking_fee_spr);

		if($data->nomor_va == ''){
			$data->nomor_va  = $this->virtual();
		}else{
			$data->nomor_va = $data->nomor_va;
		}
		echo json_encode($data);
	}


	public function ajax_pindah_tampil($id)
	{
		$data = $this->db->join('customer', 'customer.id_customer = spr.id_customer', 'left')
		->join('kavling_peta', 'kavling_peta.id_kavling = spr.id_kavling', 'left')
		->get_where('spr', ['id_spr' => $id])->row();
		// $data->harga_rumah = rupiah($data->harga_rumah);
		$data->harga_rumah = rupiah($data->hrg_jual);
		$data->booking_fee_spr = rupiah($data->booking_fee_spr);
		echo json_encode($data);
	}


	public function ajax_ganti_nama($id)
	{
		$data = $this->db->join('customer', 'customer.id_customer = spr.id_customer', 'left')
		->join('kavling_peta', 'kavling_peta.id_kavling = spr.id_kavling', 'left')
		->get_where('spr', ['id_spr' => $id])->row();
		$data->harga_rumah = rupiah($data->harga_rumah);
		$data->booking_fee_spr = rupiah($data->booking_fee_spr);
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$jam = date('H:i:s');
		$param = array(
			'id_customer' 			=> $this->input->post('nama_lengkap'),
			'nomor_spr' 			=> $this->input->post('nomor_spr'),
			'id_kavling' 			=> $this->input->post('id_kavling'),
			'tanggal_spr' 			=> $this->input->post('tanggal_spr'),
			'jam_spr' 				=> $jam,
			'harga_rumah' 			=> $this->input->post('harga_rumah'),
			'nomor_va' 			=> $this->input->post('nomor_va'),
			'booking_fee_spr' 		=> $this->input->post('nominal_booking'),
			'catatan' 				=> $this->input->post('catatan'),
			'status_spr' 			=> '0'
		);
		$this->db->insert('spr', $param);

		$this->db->update('customer', ['status_customer' => '2'], ['id_customer' => $this->input->post('nama_lengkap')]);

		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$booking = str_replace('.', '', $this->input->post('nominal_booking'));
		$hargaRumah = str_replace('.', '', $this->input->post('harga_rumah'));
		$param = array(
			'tanggal_spr' 			=> $this->input->post('tanggal_spr'),
			'harga_rumah' 			=> $hargaRumah,
			'nomor_va' 			=> $this->input->post('nomor_va'),
			'booking_fee_spr' 		=> $booking,
			'catatan' 				=> $this->input->post('catatan')
		);
		$this->spr->update(array('id_spr' => $this->input->post('id')), $param);

		echo json_encode(array("status" => TRUE));
	}


	// proses pindah kavling
	public function ajax_pindah()
	{
		date_default_timezone_set("Asia/Jakarta");	
		$tgl = date('Y-m-d');
		$jam = date('H:i:s');
		$param = array(
			'tgl_pindah'		=> $tgl,
			'jam_pindah'		=> $jam,
			'no_spr_lama'		=> $this->input->post('no_spr_lama'),
			'no_spr_baru'		=> $this->input->post('nomor_spr'),
			'id_customer'		=> $this->input->post('id_customer'),
			'lokasi_lama'		=> $this->input->post('id_kavling'),
			'lokasi_baru'		=> $this->input->post('kode_kavling_baru'),
			'harga_lama'		=> str_replace('.', '', $this->input->post('harga_rumah_pindah')),
			'harga_baru'		=> str_replace('.', '', $this->input->post('harga_rumah_baru')),
			'biaya_pindah'		=> str_replace('.', '', $this->input->post('biaya_pindah')),
			'catatan_pindah'	=> $this->input->post('catatan_pindah')
		);
		$this->db->insert('pindah_kavling', $param);

		// Proses Kavling_peta dari lokasi lama ke lokasi baru ------------ start>
		$paramKAV = [
			'stt_kavling' 	=> '0',
			'id_customer'	=> '0'
		];
		// proses kavling menjadi available
		$this->db->update('kavling_peta', $paramKAV, ['id_kavling' => $this->input->post('id_kavling')]);
		// Proses kavling Baru ============>
		$paramKAVBaru = [
			'stt_kavling' 		=> '3',
			'id_customer'	=> $this->input->post('id_customer')
		];
		$this->db->update('kavling_peta', $paramKAVBaru, ['id_kavling' => $this->input->post('kode_kavling_baru')]);

		// Update data customer 
		$idKavBaru = $this->input->post('kode_kavling_baru');
		$kav = $this->db->query("SELECT * FROM kavling_peta WHERE id_kavling = '$idKavBaru'")->row_array();
		$paramCust = [
			'id_kavling' 		=> $idKavBaru,
			'lokasi_kavling' 	=> $kav['kode_kavling'],
			'tipe_unit' 		=> $kav['tipe_bangunan']
		];
		$this->db->update('customer', $paramCust, ['id_customer' => $this->input->post('id_customer')]);


		// Buat SPR Baru
		$this->buat_spr($this->input->post('id_customer'), $sttSPR='12');
		// kode 11 untuk SPR LAMA pindah - tidak ditampilkan
		$this->db->update('spr', ['status_spr' => '11'], ['nomor_spr' => $this->input->post('no_spr_lama')]);
		// $this->db->update('customer', ['status_customer' => '2'], ['id_customer' => $this->input->post('nama_lengkap')]);
		
		
		echo json_encode(array("status" => TRUE));
	}
	
	
	public function ajax_ganti()
	{
        try{
    		// Pindah data customer lama
    		$id_customer = $this->input->post('id_customer');
    		$this->db->query("INSERT INTO customer_diganti 
    		SELECT
    		id_customer, 
    		id_kavling, 
    		lokasi_kavling, 
    		tipe_unit, 
    		id_registrasi, 
    		nama_lengkap, 
    		nik, 
    		alamat, 
    		foto_ktp, 
    		npwp, 
    		foto_npwp, 
    		kartu_keluarga, 
    		foto_kk, 
    		bpjs_tk, 
    		foto_bpjs, 
    		foto_ktp_suami, 
    		foto_ktp_istri, 
    		foto_calon_pemilik, 
    		nama_perusahaan, 
    		alamat_kantor, 
    		telp_kantor, 
    		booking_fee, 
    		nama_marketing, 
    		email, 
    		password, 
    		no_telp, 
    		nama_saudara, 
    		hubungan_saudara, 
    		no_telp_saudara, 
    		pengalaman_interaksi, 
    		persetujuan, 
    		status_registrasi, 
    		pass_registrasi, 
    		bukti_transfer, 
    		status_customer, 
    		is_trash
    		FROM customer WHERE id_customer = '$id_customer'");
    
    		// Update data customer Baru
    		$data = array(
    			'nama_lengkap' 					=> $this->input->post('nama_lengkap_pengganti'),
    			'no_telp' 						=> $this->input->post('no_telp_pengganti'),
    			'nik' 							=> $this->input->post('nik_pengganti'),
    			'alamat' 						=> $this->input->post('alamat_pengganti'),
    			'nama_perusahaan' 				=> $this->input->post('nama_perusahaan_pengganti'),
    			'telp_kantor' 					=> $this->input->post('telp_kantor_pengganti'),
    			'alamat_kantor' 				=> $this->input->post('alamat_kantor_pengganti'),
    			'email' 						=> $this->input->post('email_pengganti'),
    			'nama_saudara' 					=> $this->input->post('nama_saudara_pengganti'),
    			'no_telp_saudara' 				=> $this->input->post('no_telp_saudara_pengganti')
    		);
    		$this->db->update('customer', $data, ['id_customer' => $id_customer]);
    
    		// simpanperubahan ke tabel ganti nama
    		$param = array(
    			'tgl_ganti'		    => $this->input->post('tanggal_ganti'),
    			'id_customer'	    => $this->input->post('id_customer'),
    			'id_spr'		    => $this->input->post('no_spr'),
    			'biaya'		        => str_replace('.', '', $this->input->post('biaya')), 
    			'nama_legalitas'	=> $this->input->post('nama_lengkap_pengganti'),
    			'nama_baru'		    => $this->input->post('nama_lengkap_pengganti')
    		);
    		$this->db->insert('ganti_nama', $param);
    
    		// Buat spr baru ganti nama
    		$this->buat_spr($id_customer, '14');
    		$this->db->update('spr', ['status_spr' => '11'], ['nomor_spr' => $this->input->post('no_spr')]);
    		
    
    		// $id_spr = $this->input->post('no_spr');
    		// $cus = $this->db->query("UPDATE spr SET status_spr='14' WHERE id_spr='$id_spr'");
        }catch(\Exception $e){
            echo $e->getMessage();
        }

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


	public function ajax_select(){
		$q =$this->input->get('q');
        $items = $this->db->query("SELECT * FROM customer 
		WHERE (nama_lengkap like '%$q%' AND status_customer < 2)")->result_array();
        //output to json format
        echo json_encode($items);
    }

	public function ajax_select_cicilan_dp(){
		$q =$this->input->get('q');
        $items = $this->db->query("SELECT * FROM customer 
		WHERE (nama_lengkap like '%$q%' AND status_customer < 2) AND jenis_bayar = '1'")->result_array();
        //output to json format
        echo json_encode($items);
    }

	public function ajax_select_pembatalan(){
		$q =$this->input->get('q');
        $items = $this->db->query("SELECT * FROM customer 
		WHERE (nama_lengkap like '%$q%' AND status_customer < 3)")->result_array();
        //output to json format
        echo json_encode($items);
    }

	public function get_select($idCust){
		date_default_timezone_set("Asia/Jakarta");	
        $item=$this->db->query("SELECT * FROM customer c  
		LEFT JOIN kavling_peta p ON p.kode_kavling = c.lokasi_kavling 
		WHERE c.id_customer ='$idCust' ")->row_array();
		$item['booking_fee'] = rupiah($item['booking_fee']);
		echo json_encode($item);  
    }


	public function cetak($idSPR)
	{
	    error_reporting(E_ALL);
        ini_set('display_errors', 1);

		// $query = "SELECT s.id_spr, s.id_customer, s.id_kavling, s.kode_kavling, s.tipe_rumah, s.atas_nama, s.tanggal_spr, s.jam_spr, 
		// s.nomor_spr, s.harga_rumah, s.booking_fee_spr, c.nik, c.alamat, c.nama_saudara, c.hubungan_saudara, c.no_telp, c.no_telp_saudara, c.nama_perusahaan, 
		// c.alamat_kantor, c.telp_kantor, c.nama_marketing, p.luas_tanah, p.harga_diskon  
		// FROM spr s 
		// LEFT JOIN kavling_peta p ON s.id_kavling = p.id_kavling 
		// LEFT JOIN customer c ON s.id_customer = c.id_customer 
		// WHERE s.id_spr='$idSPR'";
		$query = "SELECT * FROM spr WHERE id_spr='$idSPR'";
		$item = $this->db->query($query)->row_array();
		$kavling = $this->db->from('kavling_peta')->where('id_kavling', $item['id_kavling'])->get()->row_array();

		$file= 'assets/template_spr.docx';

		$templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($file);
		// $templateProcessor->setValue('harga_jual', rupiah($item['harga_jual']));
		// $templateProcessor->setValue('terbilang', ucwords(penyebut($jJual)));
		// $kodeKavling = $item['kode_kavling'];
		$templateProcessor->setValue('tanggal_spr', tgl_indo_slash($item['tanggal_spr']));
		$templateProcessor->setValue('jam_spr', $item['jam_spr']);
		$templateProcessor->setValue('nomor_spr', $item['nomor_spr']);
		$templateProcessor->setValue('kode_kavling', $item['kode_kavling']);
		$templateProcessor->setValue('nama_lengkap', strtoupper($item['nama_lengkap']));
		$templateProcessor->setValue('nik', $item['nik']);
		$templateProcessor->setValue('alamat', $item['alamat_rumah']);
		$templateProcessor->setValue('no_telp', $item['no_telp']);
		$templateProcessor->setValue('no_hp', $item['no_telp']);

		$templateProcessor->setValue('nama_saudara', $item['nama_keluarga']);
		$templateProcessor->setValue('hubungan_saudara', $item['hubungan_keluarga']);
		$templateProcessor->setValue('telp_saudara', $item['no_telp_keluarga']);

		$templateProcessor->setValue('nama_perusahaan', $item['nama_perusahaan']);
		$templateProcessor->setValue('alamat_perusahaan', $item['alamat_kantor']);
		$templateProcessor->setValue('telp_perusahaan', $item['telp_kantor']);


		$templateProcessor->setValue('nama_marketing', $item['nama_marketing']);
		$templateProcessor->setValue('booking_fee_spr', rupiah($kavling['hrg_jual'] == 0 ? $kavling['harga_jual_ajb'] : $kavling['hrg_jual']));
		
		
		$templateProcessor->setValue('tipe_bangunan', $kavling['model_rumah']);
		$templateProcessor->setValue('luas_tanah', rupiah($kavling['luas_tanah']));
		$templateProcessor->setValue('harga_rumah', rupiah($kavling['hrg_jual'] == 0 ? $kavling['harga_jual_ajb'] : $kavling['hrg_jual']));
		$templateProcessor->setValue('diskon', rupiah($kavling['harga_diskon']));

		$templateProcessor->saveAs('file_spr/spr_'.$idSPR.'_'.$item['nik'].'.docx');

		redirect('file_spr/spr_'.$idSPR.'_'.$item['nik'].'.docx');


// echo $item['tipe_bangunan'];
		
	}
	
	public function cetak_bintang($idSPR)
	{
	    error_reporting(E_ALL);
        ini_set('display_errors', 1);

		// $query = "SELECT s.id_spr, s.id_customer, s.id_kavling, s.kode_kavling, s.tipe_rumah, s.atas_nama, s.tanggal_spr, s.jam_spr, 
		// s.nomor_spr, s.harga_rumah, s.booking_fee_spr, c.nik, c.alamat, c.nama_saudara, c.hubungan_saudara, c.no_telp, c.no_telp_saudara, c.nama_perusahaan, 
		// c.alamat_kantor, c.telp_kantor, c.nama_marketing, p.luas_tanah, p.harga_diskon  
		// FROM spr s 
		// LEFT JOIN kavling_peta p ON s.id_kavling = p.id_kavling 
		// LEFT JOIN customer c ON s.id_customer = c.id_customer 
		// WHERE s.id_spr='$idSPR'";
		$query = "SELECT * FROM spr WHERE id_spr='$idSPR'";
		$item = $this->db->query($query)->row_array();
		$kavling = $this->db->from('kavling_peta')->where('id_kavling', $item['id_kavling'])->get()->row_array();
		
// 		var_dump($item);

		$file= 'assets/template_spr.docx';

		$templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($file);
		// $templateProcessor->setValue('harga_jual', rupiah($item['harga_jual']));
		// $templateProcessor->setValue('terbilang', ucwords(penyebut($jJual)));
		// $kodeKavling = $item['kode_kavling'];
		$templateProcessor->setValue('tanggal_spr', tgl_indo_slash($item['tanggal_spr']));
		$templateProcessor->setValue('jam_spr', $item['jam_spr']);
		$templateProcessor->setValue('nomor_spr', $item['nomor_spr'].'*');
		$templateProcessor->setValue('kode_kavling', $item['kode_kavling']);
		$templateProcessor->setValue('nama_lengkap', strtoupper($item['nama_lengkap']));
		$templateProcessor->setValue('nik', $item['nik']);
		$templateProcessor->setValue('alamat', $item['alamat_rumah']);
		$templateProcessor->setValue('no_telp', $item['no_telp']);
		$templateProcessor->setValue('no_hp', $item['no_telp']);

		$templateProcessor->setValue('nama_saudara', $item['nama_keluarga']);
		$templateProcessor->setValue('hubungan_saudara', $item['hubungan_keluarga']);
		$templateProcessor->setValue('telp_saudara', $item['no_telp_keluarga']);

		$templateProcessor->setValue('nama_perusahaan', $item['nama_perusahaan']);
		$templateProcessor->setValue('alamat_perusahaan', $item['alamat_kantor']);
		$templateProcessor->setValue('telp_perusahaan', $item['telp_kantor']);


		$templateProcessor->setValue('nama_marketing', $item['nama_marketing']);
		$templateProcessor->setValue('booking_fee_spr', rupiah($kavling['hrg_jual']));
		
		
		$templateProcessor->setValue('tipe_bangunan', $kavling['tipe_rumah']);
		$templateProcessor->setValue('luas_tanah', rupiah($kavling['luas_tanah']));
		$templateProcessor->setValue('harga_rumah', rupiah($kavling['hrg_jual']));
		$templateProcessor->setValue('diskon', rupiah($kavling['harga_diskon']));

		$templateProcessor->saveAs('file_spr/spr_'.$idSPR.'_'.$item['nik'].'.docx');

		redirect('file_spr/spr_'.$idSPR.'_'.$item['nik'].'.docx');


// echo $item['tipe_bangunan'];
		
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


	public function virtual(){
		//buat nomor_transaksi
		$tahun = date('Y');
		$nomor = $this->db->query("SELECT MAX(nomor_va) as besar FROM spr")->row_array();
		$noSekarangTRX = $nomor['besar'];
		$urutanTRX = (int) substr($noSekarangTRX, 0, 7);
		$urutanTRX++;
		$nomorVASekarang = '23791'.sprintf("%07s", $urutanTRX);
		return $nomorVASekarang;
	}


    public function download()
    {
        $this->db->from('spr');
		$this->db->join('kavling_peta', 'kavling_peta.id_kavling = spr.id_kavling', 'left');
		$this->db->join('customer', 'customer.id_customer = spr.id_customer', 'left');
		$this->db->where('status_spr','0');
		$this->db->where('customer.nup_spr','1');
		
        $data['data'] = $this->db->get()->result();
		$this->load->view('download', $data);
    }

















	// UPLOAD ============================>>>>>>>>>>>>>

	function do_upload_ktp($nik){

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
        $this->db->update('customer', ['foto_ktp' => $namaFileUpload], ['id_customer' => $nik]);

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
	$this->db->update('customer', ['foto_npwp' => $namaFileUpload], ['id_customer' => $nik]);

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
	$this->db->update('customer', ['foto_kk' => $namaFileUpload], ['id_customer' => $nik]);

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
	$this->db->update('customer', ['foto_bpjs' => $namaFileUpload], ['id_customer' => $nik]);

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
	$this->db->update('customer', ['foto_ktp_istri' => $namaFileUpload], ['id_customer' => $nik]);

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
	$this->db->update('customer', ['foto_calon_pemilik' => $namaFileUpload], ['id_customer' => $nik]);

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
	$this->db->update('customer', ['bukti_transfer' => $namaFileUpload], ['id_customer' => $nik]);

	return $namaFile.'.jpg';
}





}
