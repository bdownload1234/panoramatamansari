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
			
			
			$link_pindah = ' <a class="btn btn-xs btn-info" href="javascript:void(0)" onclick="pindah('."'".$post->id_spr."'".')"> Pindah Kavling</a>';
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
		$data = $this->db->join('customer', 'customer.id_customer = spr.id_customer', 'left')
		->join('kavling_peta', 'kavling_peta.id_kavling = spr.id_kavling', 'left')
		->get_where('spr', ['id_spr' => $id])->row();
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
			'harga_baru'		=> str_replace('.', '', $this->input->post('kode_kavling_baru')),
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
		$this->buat_spr($this->input->post('id_customer'));
		// kode 11 untuk SPR LAMA pindah - tidak ditampilkan
		$this->db->update('spr', ['status_spr' => '11'], ['nomor_spr' => $this->input->post('no_spr_lama')]);
		// $this->db->update('customer', ['status_customer' => '2'], ['id_customer' => $this->input->post('nama_lengkap')]);
		
		
		echo json_encode(array("status" => TRUE));
	}
	
	
		public function ajax_ganti()
	{
		$param = array(
			'tgl_ganti'		    => $this->input->post('tanggal_ganti'),
			'id_customer'	    => $this->input->post('id_customer'),
			'id_spr'		    => $this->input->post('no_spr'),
			'biaya'		        => str_replace('.', '', $this->input->post('biaya')), 
			'nama_legalitas'	=> $this->input->post('nama_legalitas'),
			'nama_baru'		    => $this->input->post('nama_lengkap_pengganti'),
			'catatan_nama' 	    => $this->input->post('catatan_ganti_nama')
		);
		$this->db->insert('ganti_nama', $param);
		$id_spr = $this->input->post('no_spr');
		$cus = $this->db->query("UPDATE spr SET status_spr='14' WHERE id_spr='$id_spr'");

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
		LEFT JOIN kavling_peta p ON p.id_kavling = c.lokasi_kavling 
		WHERE c.id_customer ='$idCust' ")->row_array();
		$item['booking_fee'] = rupiah($item['booking_fee']);
		echo json_encode($item);  
    }


	public function cetak($idSPR)
	{
	    error_reporting(E_ALL);
        ini_set('display_errors', 1);

		$query = "SELECT s.id_spr, s.id_customer, s.id_kavling, s.kode_kavling, s.tipe_rumah, s.atas_nama, s.tanggal_spr, s.jam_spr, 
		s.nomor_spr, s.harga_rumah, s.booking_fee_spr, c.nik, c.alamat, c.nama_saudara, c.hubungan_saudara, c.no_telp, c.no_telp_saudara, c.nama_perusahaan, 
		c.alamat_kantor, c.telp_kantor, c.nama_marketing, p.luas_tanah, p.harga_diskon  
		FROM spr s 
		LEFT JOIN kavling_peta p ON s.id_kavling = p.id_kavling 
		LEFT JOIN customer c ON s.id_customer = c.id_customer 
		WHERE s.id_spr='$idSPR'";
		$item = $this->db->query($query)->row_array();

		$file= 'assets/template_spr.docx';

		$templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($file);
		// $templateProcessor->setValue('harga_jual', rupiah($item['harga_jual']));
		// $templateProcessor->setValue('terbilang', ucwords(penyebut($jJual)));
		// $kodeKavling = $item['kode_kavling'];
		$templateProcessor->setValue('tanggal_spr', tgl_indo_slash($item['tanggal_spr']));
		$templateProcessor->setValue('jam_spr', $item['jam_spr']);
		$templateProcessor->setValue('nomor_spr', $item['nomor_spr']);
		$templateProcessor->setValue('kode_kavling', $item['kode_kavling']);
		$templateProcessor->setValue('nama_lengkap', $item['atas_nama']);
		$templateProcessor->setValue('nik', $item['nik']);
		$templateProcessor->setValue('alamat', $item['alamat']);
		$templateProcessor->setValue('no_telp', $item['no_telp']);
		$templateProcessor->setValue('no_hp', $item['no_telp']);

		$templateProcessor->setValue('nama_saudara', $item['nama_saudara']);
		$templateProcessor->setValue('hubungan_saudara', $item['hubungan_saudara']);
		$templateProcessor->setValue('telp_saudara', $item['no_telp_saudara']);

		$templateProcessor->setValue('nama_perusahaan', $item['nama_perusahaan']);
		$templateProcessor->setValue('alamat_perusahaan', $item['alamat_kantor']);
		$templateProcessor->setValue('telp_perusahaan', $item['telp_kantor']);


		$templateProcessor->setValue('nama_marketing', $item['nama_marketing']);
		$templateProcessor->setValue('booking_fee_spr', rupiah($item['booking_fee_spr']));
		
		
		$templateProcessor->setValue('tipe_bangunan', $item['tipe_rumah']);
		$templateProcessor->setValue('luas_tanah', rupiah($item['luas_tanah']));
		$templateProcessor->setValue('harga_rumah', rupiah($item['harga_rumah']));
		$templateProcessor->setValue('diskon', rupiah($item['harga_diskon']));

		$templateProcessor->saveAs('file_spr/spr_'.$idSPR.'_'.$item['nik'].'.docx');

		redirect('file_spr/spr_'.$idSPR.'_'.$item['nik'].'.docx');


// echo $item['tipe_bangunan'];
		
	}



	public function buat_spr($idCustomer ='')
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
			'nomor_spr' 			=> $noTraSekarang,
			'id_kavling' 			=> $cust['id_kavling'],
			'kode_kavling' 			=> $cust['lokasi_kavling'],
			'tipe_rumah' 			=> $cust['tipe_unit'],
			'atas_nama' 			=> $cust['nama_lengkap'],
			'tanggal_spr' 			=> $tanggal,
			'jam_spr' 				=> $jam,
			'harga_rumah' 			=> $rumah['hrg_jual'],
			'booking_fee_spr' 		=> $cust['booking_fee'],
			'catatan' 				=> '',
			'status_spr' 			=> '12', //Status spr 12 lokasi baru dari pindahan (ditampilkan)
			'stt_keterangan' 		=> 'SPR Pindah kavling' //Status spr 12 lokasi baru dari pindahan (ditampilkan)
		);
		$this->db->insert('spr', $param);

		// $this->db->update('customer', ['status_customer' => '2'], ['id_customer' => $this->input->post('nama_lengkap')]);

		// echo json_encode(array("status" => TRUE));
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




}
