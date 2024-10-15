<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembatalan extends CI_Controller {

   var $data_ref = array('uri_controllers' => 'pembatalan');

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Pembatalan_model','pembatalan');
		// $this->load->model('Group/Group_model','group');

		check_login();
	}

	public function index()
	{
		$user_data['data_ref'] = $this->data_ref;

		$this->load->view('template/header',$user_data);
		$this->load->view('view_batal',$user_data);
	}


	public function ajax_list()
	{

		$list = $this->pembatalan->get_datatables();
		$data = array();
		$no = $_POST['start'];

		foreach ($list as $post) {

			$link_edit = '<a class="btn btn-xs btn-warning" href="javascript:void(0)" onclick="edit('."'".$post->id_pembatalan."'".')"> Edit pembatalan</a>';
			$link_cetak = ' <a class="btn btn-xs btn-success" target="_blank" href="'.base_url('spr/cetak/'.$post->id_pembatalan).'">Cetak pembatalan</a>';
			$link_hapus = ' <a class="btn btn-xs btn-danger" href="javascript:void(0)" title="Hapus" onclick="hapus('."'".$post->id_pembatalan."'".')">Delete</a>';

			$no++;
			$row = array();
         	$row[] = $no;
         	$row[] = tgl_indo($post->tanggal_pembatalan);
         	$row[] = $post->nama_lengkap;
         	$row[] = $post->kode_kavling;
			$row[] = $post->no_telp;
			$row[] = $post->keterangan_pembatalan;
			$row[] = $link_hapus;
			$data[] = $row;
		}
		$output = array(
					"draw" => $_POST['draw'],
					"recordsTotal" => $this->pembatalan->count_all(),
					"recordsFiltered" => $this->pembatalan->count_filtered(),
					"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}



	public function ajax_edit($id)
	{
		$data = $this->db->join('customer', 'customer.id_customer = pembatalan.id_customer', 'left')
		->join('kavling_peta', 'kavling_peta.id_kavling = pembatalan.id_kavling', 'left')
		->get_where('pembatalan', ['id_pembatalan' => $id])->row();
		$data->harga_rumah = rupiah($data->harga_rumah);
		$data->booking_fee_pembatalan = rupiah($data->booking_fee_pembatalan);
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$jam = date('H:i:s');
		$param = array(
			'id_customer' 				=> $this->input->post('nama_lengkap'),
			'id_kavling' 				=> $this->input->post('id_kavling'),
			'tanggal_pembatalan' 		=> $this->input->post('tanggal_pembatalan'),
			'jam_pembatalan' 			=> $jam,
			'keterangan_pembatalan' 	=> $this->input->post('keterangan_pembatalan')
		);
		$this->db->insert('pembatalan', $param);

		$this->db->update('customer', ['status_customer' => '3'], ['id_customer' => $this->input->post('nama_lengkap')]);
		$this->db->update('penjualan', ['stt_penjualan' => '3'], ['id_customer' => $this->input->post('nama_lengkap')]);

		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$booking = str_replace('.', '', $this->input->post('nominal_booking'));
		$hargaRumah = str_replace('.', '', $this->input->post('harga_rumah'));
		$param = array(
			'tanggal_pembatalan' 			=> $this->input->post('tanggal_pembatalan'),
			'harga_rumah' 			=> $hargaRumah,
			'booking_fee_pembatalan' 		=> $booking,
			'catatan' 				=> $this->input->post('catatan')
		);
		$this->pembatalan->update(array('id_pembatalan' => $this->input->post('id')), $param);

		echo json_encode(array("status" => TRUE));
	}



	public function ajax_delete($id)
	{
		// cari id customer
		$cus = $this->db->query("SELECT * FROM pembatalan WHERE id_pembatalan='$id'")->row_array();
		$this->db->delete('pembatalan',array('id_pembatalan'=>$id));

		// normalkan status customer menjadi 1
		$this->db->update('customer', ['status_customer' => '1'], ['id_customer' => $cus['id_customer']]);
		echo json_encode(array("status" => TRUE));
	}


	// public function no_cust()
	// {
	// 	$nomor = $this->db->query("SELECT MAX(kode_pembatalan) as besar FROM pembatalan")->row_array();
	// 	$noCustRX = $nomor['besar'];

	// 	$urutanTRX = (int) substr($noCustRX, 2, 3);
	// 	$urutanTRX++;
	// 	$hurufTRX = "C-";
	// 	$noCust = $hurufTRX.pembatalanintf("%03s", $urutanTRX);
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


	public function cetak($idpembatalan)
	{
		$query = "SELECT * FROM pembatalan t 
		LEFT JOIN kavling_peta p ON t.id_kavling = p.id_kavling 
		LEFT JOIN customer c ON t.id_customer = c.id_customer 
		WHERE t.id_pembatalan='$idpembatalan'";
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
