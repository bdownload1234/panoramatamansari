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
			$link_cetak = ' <a class="btn btn-xs btn-success" target="_blank" href="'.base_url('pembatalan/cetak/'.$post->id_spr).'">Cetak SPR</a>';
			$link_hapus = ' <a class="btn btn-xs btn-danger" href="javascript:void(0)" title="Hapus" onclick="hapus('."'".$post->id_spr."'".')">Batalkan</a>';

			$no++;
			$row = array();
			$row[] = $no;
			// hitory SPR
			$a = '';
			$histori = $this->db->query("SELECT * FROM spr WHERE id_customer ='$post->id_customer'")->result();
			foreach($histori as $hs){
				$a .= $hs->nomor_spr.'<br>'.' <a class="btn btn-xs btn-success" target="_blank" href="'.base_url('pembatalan/cetak/'.$hs->id_spr).'">Cetak SPR</a><br>';
			}
         	$row[] = $a;
         	$row[] = $post->nama_lengkap.'<br>'.$post->no_telp;;
         	$row[] = $post->kode_kavling;
			$row[] = $post->nomor_va;
			$row[] = $post->status_spr;
			$row[] = $link_edit.$link_hapus;
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
		$this->db->insert('pembatalan', $param);
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


	public function cetak($idpembatalan)
	{
		$query = "SELECT * FROM pembatalan t 
		LEFT JOIN kavling_peta p ON t.id_kavling = p.id_kavling 
		LEFT JOIN customer c ON t.id_customer = c.id_customer 
		WHERE t.id_spr='$idpembatalan'";
		$item = $this->db->query($query)->row_array();

		$file= 'assets/template_pembatalan.docx';

		$templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($file);
		// $templateProcessor->setValue('harga_jual', rupiah($item['harga_jual']));
		// $templateProcessor->setValue('terbilang', ucwords(penyebut($jJual)));
		// $kodeKavling = $item['kode_kavling'];
		$templateProcessor->setValue('tanggal_pembatalan', tgl_indo_slash($item['tanggal_pembatalan']));
		$templateProcessor->setValue('jam_pembatalan', $item['jam_pembatalan']);
		$templateProcessor->setValue('nomor_pembatalan', $item['nomor_pembatalan']);
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
		$templateProcessor->setValue('booking_fee_pembatalan', rupiah($item['booking_fee']));

		$templateProcessor->saveAs('file_pembatalan/pembatalan_'.$item['nik'].'.docx');

		redirect('file_pembatalan/pembatalan_'.$item['nik'].'.docx');
		
	}




}
