<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ganti_nama extends CI_Controller {

   var $data_ref = array('uri_controllers' => 'ganti_nama');

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Ganti_nama_model','ganti_nama');
		// $this->load->model('Group/Group_model','group');

		check_login();
	}

	public function index()
	{
		$user_data['data_ref'] = $this->data_ref;

		$this->load->view('template/header',$user_data);
		$this->load->view('view',$user_data);
	}


	public function ajax_list()
	{

		$list = $this->ganti_nama->get_datatables();
		$data = array();
		$no = $_POST['start'];

		foreach ($list as $post) {

			$link_edit = '<a class="btn btn-xs btn-warning" href="javascript:void(0)" onclick="edit('."'".$post->id_spr."'".')"> Edit SPR</a>';
			$link_cetak = ' <a class="btn btn-xs btn-success" target="_blank" href="'.base_url('spr/cetak/'.$post->id_spr).'">Cetak SPR</a>';
			$link_hapus = ' <a class="btn btn-xs btn-danger" href="javascript:void(0)" title="Hapus" onclick="hapus('."'".$post->id_spr."'".')">Batalkan</a>';

			$link_kwitansi = ' <a class="btn btn-xs btn-success" target="_blank" href="'.base_url('ganti_nama/cetak_kwitansi/'.$post->id_customer).'">Cetak Kwitansi</a> ';
			$link_form = ' <a class="btn btn-xs btn-success" target="_blank" href="'.base_url('ganti_nama/cetak_form/'.$post->id_customer).'">Cetak Form</a> ';
			
			$no++;
			$row = array();
			$row[] = $no;
			// hitory SPR
			$a = '';
			$histori = $this->db->query("SELECT * FROM spr WHERE id_customer ='$post->id_customer'")->result();
			foreach($histori as $hs){
				$a .= $hs->nomor_spr.'<br>'.' <a class="btn btn-xs btn-success" target="_blank" href="'.base_url('spr/cetak_bintang/'.$hs->id_spr).'">Cetak SPR</a><br>';
			}
         	$row[] = $a;
         	$row[] = $post->nama_lengkap.'<br>'.$post->no_telp;;
         	$row[] = $post->kode_kavling;
			$row[] = $post->nomor_va;
			
			if($post->status_spr == '0'){
				$row[] = '<span class="badge badge-pill badge-info">SPR</span>';
			}else if($post->status_spr == '11'){
				$row[] = '<span class="badge badge-pill badge-success">Pindah Kavling</span>';
			}else if($post->status_spr == '12'){
				$row[] = '<span class="badge badge-pill badge-warning">Pindah Kavling</span>';
			}else if($post->status_spr == '14'){
				$row[] = '<span class="badge badge-pill badge-success">Ganti Nama</span>';
			}else if($post->status_spr == '21'){
				$row[] = '<span class="badge badge-pill badge-primary">AKAD</span>';
			}else{
				$row[] = '<span class="badge badge-pill badge-secondary">HOLD</span>';
			}
			
			$row[] = $link_kwitansi.$link_form.$link_edit.$link_hapus;
			$data[] = $row;
		}
		$output = array(
					"draw" => $_POST['draw'],
					"recordsTotal" => $this->ganti_nama->count_all(),
					"recordsFiltered" => $this->ganti_nama->count_filtered(),
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
		// $data->booking_fee_pembatalan = rupiah($data->booking_fee_pembatalan);
		echo json_encode($data);
	}


	public function ajax_update()
	{
	    try{
    		$booking = str_replace('.', '', $this->input->post('nominal_booking'));
    		$hargaRumah = str_replace('.', '', $this->input->post('harga_rumah'));
    		$param = array(
    			'tanggal_spr' 			=> $this->input->post('tanggal_spr'),
    			'harga_rumah' 			=> $hargaRumah,
    			'nomor_va' 				=> $this->input->post('nomor_va'),
    			'booking_fee_spr' 		=> $booking,
    			'catatan' 				=> $this->input->post('catatan')
    		);
    		$this->db->update('spr', $param, array('id_spr' => $this->input->post('id')));
	    }catch(\Exception $e){
	        echo json_encode(array('status' => $e->getMessage()));
	    }

		echo json_encode(array("status" => TRUE));
	}

	



	public function ajax_delete($id_spr)
	{
		date_default_timezone_set("Asia/Jakarta");	
		$tanggal = date('Y-m-d');
		$jam = date('H:i:s');
		// cari data SPR
		$spr = $this->db->query("SELECT * FROM spr WHERE id_spr='$id_spr'")->row_array();
		$param = [
			'tanggal_pembatalan'			=> $tanggal, 
			'jam_pembatalan'				=> $jam, 
			'id_spr'						=> $id_spr, 
			'no_penjualan'					=> $spr['nomor_spr'], 
			'id_customer'					=> $spr['id_customer'], 
			'id_kavling'					=> $spr['id_kavling'], 
			'keterangan_pembatalan' 		=> ''
		];
// 		$this->db->insert('pembatalan', $param);
		// cari id customer
		$cus = $this->db->query("UPDATE spr SET status_spr='13' WHERE id_spr='$id_spr'");

		// normalkan status customer menjadi 1
		$this->db->update('customer', ['status_customer' => '1'], ['id_customer' => $spr['id_customer']]);

		// normalkan data Kavling
		$this->db->update('kavling_peta', ['status' => '0', 'id_customer' => '0'], ['id_kavling' => $spr['id_kavling']]);
		echo json_encode(array("status" => TRUE));
	}


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
		$templateProcessor->setValue('nama_lengkap', strtoupper($item['atas_nama']));
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
	
	
	public function cetak_kwitansi($idCust){

		
    		$this->db->select('*');
    		$this->db->join('customer', 'customer.id_customer = ganti_nama.id_customer', 'left');
    		$this->db->join('kavling_peta', 'kavling_peta.id_kavling = customer.lokasi_kavling', 'left');
    // 		$kavling = $this->db->get_where('ganti_nama ', array('ganti_nama.id_spr'=>$idSPR))->row_array();
            $this->db->from('ganti_nama');
            $this->db->where('ganti_nama.id_customer', $idCust);
            
            
            $kavling = $this->db->get()->row_array();
    
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
            $this->mypdf->text(158,33.7, '');
            $this->mypdf->SetTextColor(0,0,0);
    
    		//Data Diri
    		$this->mypdf->SetFont('Times','',12);
            $this->mypdf->text(65,39, $kavling['nama_lengkap']);
            // $this->mypdf->text(65,47, ucwords(terbilang($kavling['hrg_jual'])).'Rupiah');
            // $this->mypdf->text(65,47, ucwords(terbilang($kavling['hrg_jual'])).'Rupiah');
    		$this->mypdf->text(65,55, "Biaya Ganti Nama Pembelian Rumah Dengan Lokasi : ". $kavling['kode_kavling']);
    
            
            $this->mypdf->SetFont('Times','B',16);
            $this->mypdf->text(37,74, rupiah($kavling['biaya']));
    
    
    
            $this->mypdf->SetFont('Times','',11);
    
    		$this->mypdf->SetY(70);
    		$this->mypdf->Cell(120,4,'',0,0,'C');
            $this->mypdf->Cell(60,4,$konfig['kota_penandatanganan'].', '.tgl_indo($kavling['tgl_ganti']),0,0,'C');
    		$this->mypdf->ln(21);
    		$this->mypdf->Cell(120,4,'',0,0,'C');
            $this->mypdf->Cell(60,4,$konfig['nama_penandatangan'],0,0,'C');
    
    		//Tanda Tangan
    		$this->mypdf->Image(base_url().'assets/aplikasi/ttd_kav-removebg-preview.png',138,67,30);
    
    
    		// Rekening Pembayaran
    		$this->mypdf->SetFont('Times','',9);
    		$this->mypdf->text(22,82,'Rekening Pembayaran : ');
    		$this->mypdf->text(22,85,$konfig['nama_bank']);
    		$this->mypdf->SetFont('Times','B',11);
    		$this->mypdf->text(22,89,$konfig['no_rekening']);
    		$this->mypdf->SetFont('Times','',10);
    		$this->mypdf->text(22,92,$konfig['nama_pemilik_rek']);
    
    // 		$namaFile = str_replace('/','-', $kavling['no_registrasi']);
    // 		$noFile = explode('-', $namaFile);
    		
    
    // 		if(file_exists('./kwitansi/'.$namaFile.'.pdf')){
    // 			echo '';
    // 		}else{
    // 			$this->mypdf->Output('F', './kwitansi/kwitansi-'.$noFile[0].'.pdf', true);
    // 		}
            $this->mypdf->Output();
    }

    function cetak_form($idCust){
        // panggil library yang kita buat sebelumnya yang bernama pdfgenerator
        $this->load->library('pdfgenerator');
        
        // title dari pdf
        $this->db->select('ganti_nama.*, spr.nomor_spr, spr.tanggal_spr, customer.nama_lengkap, kavling_peta.kode_kavling, kavling_peta.tipe_bangunan, kavling_peta.model_rumah');
		$this->db->join('customer', 'customer.id_customer = ganti_nama.id_customer', 'left');
		$this->db->join('kavling_peta', 'kavling_peta.id_kavling = customer.id_kavling', 'left');
		$this->db->join('spr', 'spr.id_spr = ganti_nama.id_spr', 'left');
// 		$kavling = $this->db->get_where('ganti_nama ', array('ganti_nama.id_spr'=>$idSPR))->row_array();
        $this->db->from('ganti_nama');
        $this->db->where('ganti_nama.id_customer', $idCust);
        $this->data['data'] = $this->db->get()->row_array();
        $this->data['title_pdf'] = 'Form Ganti Nama';
        
        // filename dari pdf ketika didownload
        $file_pdf = 'Form Ganti Nama';
        // setting paper
        $paper = 'A4';
        //orientasi paper potrait / landscape
        $orientation = "portrait";
        
		$html = $this->load->view('form',$this->data, true);	    
        
        // run dompdf
        $this->pdfgenerator->generate($html, $file_pdf,$paper,$orientation);
    }
    
    public function download()
    {
        $this->db->from('spr');
		$this->db->join('kavling_peta', 'kavling_peta.id_kavling = spr.id_kavling', 'left');
		$this->db->join('customer', 'customer.id_customer = spr.id_customer', 'left');
		$this->db->where('status_spr','14');
		
        $data['data'] = $this->db->get()->result();
		$this->load->view('download', $data);
    }


}
