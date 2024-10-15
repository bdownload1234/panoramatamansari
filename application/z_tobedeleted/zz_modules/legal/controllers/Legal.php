<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Legal extends CI_Controller {

	var $data_ref = array('uri_controllers' => 'legal');
	
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('customade');
		$this->load->library(array('form_validation'));	
		check_login();

	}
	
	public function index()
	{
		$data=array();
		$csrf = array(
		        'name' => $this->security->get_csrf_token_name(),
		        'hash' => $this->security->get_csrf_hash()
		    );
		$data=array('csrf'=>$csrf);	
		$data['data_ref'] = $this->data_ref;


		$this->load->view('template/header',$data);
		$this->load->view('dashboard',$data);
		// $this->load->view('template/footer',$data);
	}

	public function ajax_list()
	{

		$list = $this->legal->get_datatables();
		$data = array();
		$no = $_POST['start'];

		foreach ($list as $post) {

			$link_edit = '<a class="btn btn-xs btn-primary" href="javascript:void(0)" title="Edit" onclick="edit('."'".$post->id_kavling."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>';
			$link_hapus = ' <a class="btn btn-xs btn-danger" href="javascript:void(0)" title="Hapus" onclick="hapus('."'".$post->id_kavling."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
		

			$no++;
			$row = array();
         	$row[] = $no;
         	$row[] = $post->kode_kavling.'<br><b>'.$post->luas_tanah.' </b>meter';
			$row[] = rupiah($post->hrg_meter);
			$row[] = rupiah($post->luas_tanah * $post->hrg_meter);

			if($post->status == '0'){
				$row[] = '<span class="btn btn-secondary btn-sm">Kosong</span>';
			}elseif($post->status == '1'){
				$row[] = '<span class="btn btn-warning btn-sm">Booking</span>';
			}elseif($post->status == '2'){
				$row[] = '<span class="btn btn-primary btn-sm">Cash</span>';
			}elseif($post->status == '3'){
				$row[] = '<span class="btn btn-info btn-sm">Kredit</span>';
			}else{
				$row[] = 'Pengurus';
			}
			
			$row[] = "";

			//add html for action
			$row[] = $link_edit;

			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->legal->count_all(),
						"recordsFiltered" => $this->legal->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function detail()
	{
		$data=array();
		$data['data_ref'] = $this->data_ref;
		$this->load->view('template/header',$data);
		$this->load->view('legal_index',$data);
		$this->load->view('template/footer',$data);
	}

	public function detailblok($idBlok)
	{
		$data=array();
		$data['data_ref'] = $this->data_ref;
		$data['kavlingBlok'] = $this->db->query("SELECT * FROM kavling_peta WHERE blok = '$idBlok' ORDER BY 
		SUBSTRING(kode_kavling, 1, 2), CAST(SUBSTRING(kode_kavling, 4) AS SIGNED)")->result();
		$this->load->view('template/header',$data);
		$this->load->view('legal_blok_index',$data);
		$this->load->view('template/footer',$data);
	}

	

	public function ajax_edit($id)
	{
		$data = $this->db->query("SELECT * FROM legal l 
			LEFT JOIN kavling_peta a ON l.id_kavling = a.id_kavling 
			LEFT JOIN customer b ON a.id_customer=b.id_customer 
			WHERE l.id_legal = '$id' ")->row_array();
		echo json_encode($data);
	}

	public function ajax_tampil($id)
	{
		$data = $this->db->query("SELECT * FROM legal l 
			LEFT JOIN kavling_peta a ON l.id_kavling = a.id_kavling 
			LEFT JOIN customer b ON a.id_customer=b.id_customer 
			WHERE l.id_kavling = '$id' ")->row_array();
		echo json_encode($data);
	}

	public function cekcicilan()
	{
		$a = '<table border="1">';
		$data = $this->db->query("SELECT *, (SELECT MAX(pembayaran_ke) as besar FROM pembayaran WHERE id_kavling=t.id_kavling) as oke FROM transaksi_kavling t 
		LEFT JOIN kavling_peta k ON t.id_kavling = k.id_kavling  
		WHERE t.jenis_pembelian='3' ORDER BY t.lama_cicilan ASC")->result();
		foreach($data as $it){
			if($it->lama_cicilan <= $it->oke){ 
				$lns = 'LUNAS';
				//Update status cicilan = LUNAS
				$this->db->query("UPDATE kavling_peta SET stt_cicilan='1' WHERE id_kavling='$it->id_kavling'");
			} else{ 
				$lns ='';
			}
			$a .= '<tr>
				<td>'.$it->kode_kavling.'</td>
				<td>'.$it->lama_cicilan.'</td>
				<td>'.$it->oke.'</td>
				<td>'.$lns.'</td>
			</tr>';
		}

		$a .= '</table>';

		echo $a;
	}


	public function ajax_add()
	{
		
		$param = array(
			'id_kavling' 		=> $this->input->post('kode_kavling'),
			'blok' 				=> $this->input->post('blok'),
			'ukuran' 			=> $this->input->post('ukuran_tanah'),
			'luas' 				=> $this->input->post('ukuran_tanah'),
			'no_shm' 			=> $this->input->post('no_shm'),
			'atas_nama' 		=> $this->input->post('nama_cust'),
			'stt_legal' 		=> $this->input->post('status')
		);


		$this->db->insert('legal', $param);
		echo json_encode(array("status" => TRUE));
	}


	public function ajax_update()
	{
		
		$param = array(
			'ukuran' 			=> $this->input->post('ukuran_tanah'),
			'luas' 				=> $this->input->post('ukuran_tanah'),
			'no_shm' 			=> $this->input->post('no_shm'),
			'stt_legal' 		=> $this->input->post('status')
		);


		$this->db->update('legal', $param, ['id_legal' => $this->input->post('id')]);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_select_kavling(){
        $this->db->select('id_kavling,kode_kavling');
        $this->db->like('kode_kavling',$this->input->get('q'),'both');
        $this->db->limit(20);
        $items=$this->db->get_where('kavling_peta', ['status <> "0"'])->result_array();
        //output to json format
        echo json_encode($items);
    }

	public function get($id){
        $item=$this->db->query("SELECT * FROM kavling_peta k 
		LEFT JOIN customer c ON c.id_customer = k.id_customer 
		WHERE k.id_kavling ='$id' ")->row_array();
        return $this->output->set_content_type('application/json')->set_output(json_encode($item));        
    }

	public function ajax_delete($id)
	{
		$this->db->delete('legal',array('id_legal'=>$id));
		echo json_encode(array("status" => TRUE));
	}
	

}