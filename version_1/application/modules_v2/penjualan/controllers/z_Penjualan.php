<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penjualan extends CI_Controller {

   var $data_ref = array('uri_controllers' => 'penjualan');

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Penjualan_model','penjualan');
		check_login();
	}

	public function index()
	{
		$user_data['data_ref'] = $this->data_ref;
		//buat nomor_transaksi
		$tahun = date('Y');
		$nomor = $this->db->query("SELECT MAX(no_penjualan) as besar FROM penjualan WHERE no_penjualan like '%$tahun'")->row_array();
		$noSekarangTRX = $nomor['besar'];
		$urutanTRX = (int) substr($noSekarangTRX, 0, 5);
		$urutanTRX++;
		$hurufTRX = "/P-PTS/$tahun";
		$noTraSekarang = sprintf("%05s", $urutanTRX).$hurufTRX;
		$user_data['notrx'] = $noTraSekarang;

		$this->load->view('template/header',$user_data);
		$this->load->view('view',$user_data);
	}

	public function spr()
	{
		$user_data['data_ref'] = $this->data_ref;
		$this->load->view('template/header',$user_data);
		$this->load->view('view_spr',$user_data);
	}

	public function akad()
	{
		$user_data['data_ref'] = $this->data_ref;
		$this->load->view('template/header',$user_data);
		$this->load->view('view_akad',$user_data);
	}

	public function batal()
	{
		$user_data['data_ref'] = $this->data_ref;
		$this->load->view('template/header',$user_data);
		$this->load->view('view_batal',$user_data);
	}


	public function ajax_list($jenis = '')
	{

		$list = $this->penjualan->get_datatables($jenis);
		$data = array();
		$no = $_POST['start'];

		foreach ($list as $post) {

			$link_edit = '<a class="btn btn-xs btn-warning" href="javascript:void(0)" onclick="edit('."'".$post->id_penjualan."'".')"> Edit penjualan</a>';
			$link_cetak = ' <a class="btn btn-xs btn-success" target="_blank" href="'.base_url('penjualan/cetak_kwitansi/'.$post->id_penjualan).'">Cetak Kwitansi</a>';
			$link_hapus = ' <a class="btn btn-xs btn-danger" href="javascript:void(0)" title="Hapus" onclick="hapus('."'".$post->id_penjualan."'".')">Delete</a>';
			$link_kirim_modal = ' <a class="btn btn-xs btn-info" href="javascript:void(0)" title="Hapus" onclick="kirimpersonal('."'".$post->id_penjualan."'".')"> Kirim</a>';

			$no++;
			$row = array();
         	$row[] = $no;
         	$row[] = $post->no_penjualan;
         	$row[] = $post->nama_lengkap;
         	$row[] = $post->kode_kavling;
         	$row[] = rupiah($post->booking_fee);
			$row[] = $post->no_telp;
			if($post->stt_penjualan == '0'){
				$row[] = '<span class="badge badge-secondary">Penjualan</span>';
			}else if($post->stt_penjualan == '1'){
				$row[] = '<span class="badge badge-info">SPR</span>';
			}else if($post->stt_penjualan == '2'){
				$row[] = '<span class="badge badge-warning">Akad</span>';
			}else if($post->stt_penjualan == '3'){
				$row[] = '<span class="badge badge-danger">Batal</span>';
			}
			
			// $row[] = $link_cetak;
			$row[] = $link_cetak;
			$row[] = $link_edit.$link_hapus.$link_kirim_modal;
			$data[] = $row;
		}
		$output = array(
					"draw" => $_POST['draw'],
					"recordsTotal" => $this->penjualan->count_all($jenis),
					"recordsFiltered" => $this->penjualan->count_filtered($jenis),
					"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}



	public function ajax_edit($id)
	{
		$data = $this->db->select('customer.nik, alamat, nama_lengkap, no_penjualan, kode_kavling, penjualan.id_penjualan, 
		penjualan.booking_fee, no_telp, kavling_peta.id_kavling, nama_saudara, no_telp_saudara')
		->join('customer', 'customer.id_customer = penjualan.id_customer', 'left')
		->join('kavling_peta', 'kavling_peta.id_kavling = penjualan.id_kavling', 'left')
		->get_where('penjualan', ['id_penjualan' => $id])->row();
		$data->booking_fee = rupiah($data->booking_fee);
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$param = array(
			'id_customer' 			=> $this->input->post('nama_lengkap'),
			'no_penjualan' 			=> $this->input->post('nomor_penjualan'),
			'id_kavling' 			=> $this->input->post('id_kavling'),
			'tanggal_penjualan' 	=> $this->input->post('tanggal_penjualan'),
			'booking_fee' 			=> $this->input->post('nominal_booking'),
			'catatan' 				=> $this->input->post('catatan')
		);
		$this->db->insert('penjualan', $param);
		$this->db->update('customer', ['status_customer' => '2'], ['id_customer' => $this->input->post('nama_lengkap')]);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$booking = str_replace('.', '', $this->input->post('nominal_booking'));
		$param = array(
			'tanggal_penjualan' 	=> $this->input->post('tanggal_penjualan'),
			'booking_fee' 			=> $booking,
			'catatan' 				=> $this->input->post('catatan')
		);
		$this->penjualan->update(array('id_penjualan' => $this->input->post('id')), $param);

		echo json_encode(array("status" => TRUE));
	}



	public function ajax_delete($id)
	{
		// cari id customer
		$cus = $this->db->query("SELECT * FROM penjualan WHERE id_penjualan='$id'")->row_array();
		$this->db->delete('penjualan',array('id_penjualan'=>$id));

		// normalkan status customer menjadi 1
		$this->db->update('customer', ['status_customer' => '1'], ['id_customer' => $cus['id_customer']]);
		echo json_encode(array("status" => TRUE));
	}


	// public function no_cust()
	// {
	// 	$nomor = $this->db->query("SELECT MAX(kode_penjualan) as besar FROM penjualan")->row_array();
	// 	$noCustRX = $nomor['besar'];

	// 	$urutanTRX = (int) substr($noCustRX, 2, 3);
	// 	$urutanTRX++;
	// 	$hurufTRX = "C-";
	// 	$noCust = $hurufTRX.penjualanintf("%03s", $urutanTRX);
	// 	return $noCust;
	// }


	public function ajax_select(){
		$q =$this->input->get('q');
        $items = $this->db->query("SELECT * FROM customer 
		WHERE (nama_lengkap like '%$q%' AND status_customer < 2)")->result_array();
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


	public function cetak($idpenjualan)
	{
		$query = "SELECT * FROM penjualan t 
		LEFT JOIN kavling_peta p ON t.id_kavling = p.id_kavling 
		LEFT JOIN customer c ON t.id_customer = c.id_customer 
		WHERE t.id_penjualan='$idpenjualan'";
		$item = $this->db->query($query)->row_array();

		$file= 'assets/template_penjualan.docx';

		$templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($file);
		// $templateProcessor->setValue('harga_jual', rupiah($item['harga_jual']));
		// $templateProcessor->setValue('terbilang', ucwords(penyebut($jJual)));
		// $kodeKavling = $item['kode_kavling'];
		$templateProcessor->setValue('tanggal_penjualan', tgl_indo_slash($item['tanggal_penjualan']));
		$templateProcessor->setValue('jam_penjualan', $item['jam_penjualan']);
		$templateProcessor->setValue('nomor_penjualan', $item['nomor_penjualan']);
		$templateProcessor->setValue('kode_kavling', $item['kode_kavling']);
		$templateProcessor->setValue('nama_lengkap', $item['nama_lengkap']);
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
		$templateProcessor->setValue('booking_fee_penjualan', rupiah($item['booking_fee']));

		$templateProcessor->saveAs('file_penjualan/penjualan_'.$item['nik'].'.docx');

		redirect('file_penjualan/penjualan_'.$item['nik'].'.docx');
		
	}



	public function cetak_kwitansi($id){

		
		$this->db->select('penjualan.tanggal_penjualan, nama_lengkap, penjualan.no_penjualan, kode_kavling, penjualan.id_penjualan, penjualan.booking_fee, no_telp, kavling_peta.id_kavling');
		// $this->db->from('penjualan');
		$this->db->join('kavling_peta', 'kavling_peta.id_kavling = penjualan.id_kavling', 'left');
		$this->db->join('customer', 'kavling_peta.id_kavling = customer.lokasi_kavling', 'left');
		$kavling = $this->db->get_where('penjualan ', array('id_penjualan'=>$id))->row_array();

		$konfig = $this->db->get_where('konfigurasi a', array('a.id'=>'1'))->row_array();
        

        $config=array('orientation'=>'P','size'=>'A4');
        $this->load->library('MyPDF',$config);
        $this->mypdf->SetFont('Arial','B',10);
        $this->mypdf->SetLeftMargin(10);
        $this->mypdf->addPage();
        $this->mypdf->setTitle('Kwintasi Pembayaran');
        $this->mypdf->SetFont('Arial','B',14);

		//Master Desain background Kwitansi Pembayaran
		$this->mypdf->Image(base_url().'assets/aplikasi/kwitansi_v1.jpg',10,10,190);
		// L0go Kavling untuk kwitansi
		$logoKwitansi = $this->db->query("SELECT * FROM konfigurasi_media WHERE jenis_data='Logo Kwitansi'")->row_array();
		$this->mypdf->Image(base_url().'assets/aplikasi/'.$logoKwitansi['nama_file'],18,15,15);


		// Nomor Pembayaran_model $this->mypdfi->SetTextColor(229,8,8);
        $this->mypdf->SetFont('Arial','B',8);
		$this->mypdf->SetTextColor(229,8,8);
        $this->mypdf->text(158,33.7, $kavling['no_penjualan']);
        $this->mypdf->SetTextColor(0,0,0);

		//Data Diri
		$this->mypdf->SetFont('Times','',12);
        $this->mypdf->text(65,39, $kavling['nama_lengkap']);
        $this->mypdf->text(65,47, ucwords(terbilang($kavling['booking_fee'])).'Rupiah');
		$this->mypdf->text(65,55, "Pembayaran Booking Pembelian Rumah Dengan Lokasi : ");

        
        $this->mypdf->SetFont('Times','B',16);
        $this->mypdf->text(37,74, rupiah($kavling['booking_fee']));



        $this->mypdf->SetFont('Times','',11);

		$this->mypdf->SetY(70);
		$this->mypdf->Cell(120,4,'',0,0,'C');
        $this->mypdf->Cell(60,4,$konfig['kota_penandatanganan'].', '.tgl_indo($kavling['tanggal_penjualan']),0,0,'C');
		$this->mypdf->ln(21);
		$this->mypdf->Cell(120,4,'',0,0,'C');
        $this->mypdf->Cell(60,4,$konfig['nama_penandatangan'],0,0,'C');

		//Tanda Tangan
		// $this->mypdf->Image(base_url().'assets/aplikasi/'.$konfig['file_ttd'],141,62,35);


		// Rekening Pembayaran
		$this->mypdf->SetFont('Times','',9);
		$this->mypdf->text(22,82,'Rekening Pembayaran : ');
		$this->mypdf->text(22,85,$konfig['nama_bank']);
		$this->mypdf->SetFont('Times','B',11);
		$this->mypdf->text(22,89,$konfig['no_rekening']);
		$this->mypdf->SetFont('Times','',10);
		$this->mypdf->text(22,92,$konfig['nama_pemilik_rek']);

		$namaFile = str_replace('/','-', $kavling['no_penjualan']);
		$noFile = explode('-', $namaFile);
		

		if(file_exists('./kwitansi/'.$namaFile.'.pdf')){
			echo '';
		}else{
			$this->mypdf->Output('F', './kwitansi/kwitansi-'.$noFile[0].'.pdf', true);
		}
        $this->mypdf->Output();
    }


	public function ajax_kirim_bukti($id)
	{
		$param = $this->db->query("SELECT * FROM penjualan p 
		LEFT JOIN customer c ON p.id_customer = c.id_customer 
		LEFT JOIN kavling_peta k ON k.id_kavling = p.id_kavling 
		WHERE id_penjualan='$id'")->row_array();

		$file = $this->db->get_where('penjualan', ['id_penjualan' => $id])->row_array();
		$pecah = explode('/', $file['no_penjualan']);

		$template = $this->db->query("SELECT * FROM template WHERE jenis_pesan ='kwitansi'")->row_array();
		$pesan = str_replace('[nama]', $param['nama_lengkap'], $template['isi_template']);
		$pesan = str_replace('[kode_kavling]', $param['kode_kavling'], $pesan);

		$noTelp = $param['no_telp'];
		$zona = substr($noTelp, 0, 2);
		$nomornya = substr($noTelp, 2);
		if ($zona == '08') {
			$param['no_telp'] = '628' . $nomornya;
		} else {
			$param['no_telp'] = '62' . $nomornya;
		}

		$param['isi_pesan'] = $pesan;
		$param['noFile'] = $pesan;

		echo json_encode($param);
	}



	function kwitansi($id=""){
		// error_reporting(0);
		$file = $this->db->get_where('penjualan', ['id_penjualan' => $id])->row_array();
		$pecah = explode('/', $file['no_penjualan']);
		sleep(2);
		echo '<iframe id="pdfViewer" src="'.base_url('kwitansi/kwitansi-'.$pecah[0].'.pdf').'" frameborder="0" style="width: 100%; height: 300px;"></iframe>';
	
	}


	public function ajax_kirim()
	{
		$noFile = $this->input->post('noFile');
		$penerima = $this->input->post('no_telp');
		$pesan = $this->input->post('isi_pesan');

		// Menggunakan WATZAP
		$age = array(
			"api_key"     => 'A88F4KWX5JECQOO6', 
			"number_key"  => 'A0Kp0tTyOqUBEu5T', 
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

			// echo json_encode($response);


		$lokasiFile = base_url('kwitansi/kwitansi-'.$noFile.'.pdf');

		$age = array(
			"api_key"     => 'A88F4KWX5JECQOO6', 
			"number_key"  => 'A0Kp0tTyOqUBEu5T', 
			"phone_no"    => $penerima,
			"url"         => "$lokasiFile"
		  );
		  
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
		//   echo json_encode($response);

		// $data = array(
		// 	'tanggal' 		=> $tanggal,
		// 	'jam' 			=> $jam,
		// 	'nama_pasien' 	=> $param['nama_lengkap'],
		// 	'jenis' 		=> 'pribadi',
		// 	'no_tujuan' 	=> $param['no_telp'],
		// 	'isi_pesan' 	=> $pesan, 
		// 	'stt_kirim' 	=> '1'
		// );
		// $this->db->insert('kirim', $data);

		echo json_encode(array("status" => TRUE));
	}




}
