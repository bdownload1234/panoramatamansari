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

			$no++;
			$row = array();
         	$row[] = $no;
         	$row[] = $post->tanggal;
         	$row[] = $post->lokasi_kavling;
			$row[] = $post->nama_lengkap;
         	$row[] = $post->jenis_pembelian;
         	$row[] = $post->nama_notaris;
			$row[] = $post->nama_bank.'<br>'.$post->no_rekening;
			$row[] = $post->ket;

			//add html for action
			$row[] = $link_edit.$link_hapus;

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
			'tanggal' 			=> $this->input->post('tanggal_kehadiran'),
			'id_kavling' 		=> $this->input->post('id_kavling'), 
			'lokasi_kavling' 	=> $this->input->post('lokasi_kavling'),
			'jenis_pembelian' 		=> $this->input->post('jenis_pembelian'),
			'id_notaris' 		=> $this->input->post('notaris'),
			'id_bank' 		=> $this->input->post('bank'),
			'no_rekening' 		=> $this->input->post('no_rekening'),
			'keterangan' 		=> $this->input->post('keterangan')
		);

        $this->daftar_hadir->update(['id_hadir' => $this->input->post('id')], $data);
        echo json_encode(['status' => true]);
    }



	public function ajax_add()
	{
		$data = array(
			'tanggal' 			=> $this->input->post('tanggal_kehadiran'),
			'id_kavling' 		=> $this->input->post('id_kavling'), 
			'lokasi_kavling' 	=> $this->input->post('lokasi_kavling'),
			'jenis_pembelian' 		=> $this->input->post('jenis_pembelian'),
			'id_notaris' 		=> $this->input->post('notaris'),
			'id_bank' 		    => $this->input->post('bank'),
			'id_customer' 		=> $this->input->post('nama_customer'),
			'no_rekening' 		=> $this->input->post('no_rekening'),
			'keterangan' 		=> $this->input->post('keterangan')
		);

		$this->db->insert('daftar_hadir', $data);
		
        // Update data status Customer menjadi 4 agar dashboard customer berubah statusnya
        $this->db->update('customer', ['status_customer' => '4'], ['id_customer' => $this->input->post('nama_customer')]);
// 		echo json_encode(array("status" => TRUE));
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




}
