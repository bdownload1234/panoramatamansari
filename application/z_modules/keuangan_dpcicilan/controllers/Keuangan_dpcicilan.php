<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Keuangan_dpcicilan extends CI_Controller
{
    var $data_ref = ['uri_controllers' => 'keuangan_dpcicilan'];

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Keuangan_dpcicilan_model', 'keuangan_dpcicilan');
        check_login();
    }

    public function index()
    {
        $user_data['data_ref'] = $this->data_ref;
        $this->load->view('template/header', $user_data);
        $this->load->view('view', $user_data);
    }

    public function ajax_list()
    {
        $list = $this->keuangan_dpcicilan->get_datatables();
        $data = [];
        $no = $_POST['start'];

        foreach ($list as $post) {
            $link_edit = '<a class="btn btn-xs btn-info" href="javascript:void(0)" onclick="edit(' . "'" . $post->id_customer . "'" . ')"> Detail Cicilan</a>';
            $link_hapus = ' <a class="btn btn-xs btn-danger" href="javascript:void(0)" title="Hapus" onclick="hapus(' . "'" . $post->id_customer . "'" . ')">Delete</a>';

            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $post->nama_lengkap;
            $row[] = $post->lokasi_kavling;
            $row[] = rupiah($post->booking_fee);
            // hitung jumlah cicilan yang sudah dibayar
            $cicilan = $this->db->query("SELECT SUM(nominal) as jum FROM keuangan_dpcicilan WHERE id_customer='$post->id_customer'")->row_array();
            $row[] = rupiah($cicilan['jum']);

            $row[] = $link_edit;
            $data[] = $row;
        }
        $output = [
            'draw' => $_POST['draw'],
            'recordsTotal' => $this->keuangan_dpcicilan->count_all(),
            'recordsFiltered' => $this->keuangan_dpcicilan->count_filtered(),
            'data' => $data,
        ];
        //output to json format
        echo json_encode($output);
    }


    public function ajax_delete($id)
    {
        $this->db->delete('keuangan_dpcicilan', ['id_keu_dpcicilan' => $id]);
        echo json_encode(['status' => true]);
    }


    function excel()
    {
        $user_data['keuangan_cicilan'] = $this->db->query("SELECT * FROM keuangan_dpcicilan k LEFT JOIN 
        customer c ON c.id_customer = k.id_customer")->result();
        $this->load->view('excel', $user_data);
    }


    public function ajax_add()
    {
        $data = [
            'tanggal'       => $this->input->post('tanggal'),
            'id_customer'   => $this->input->post('nama_lengkap'),
            'nominal'       => str_replace('.', '', $this->input->post('cicilan')),
        ];

        $this->db->insert('keuangan_dpcicilan', $data);
        echo json_encode(['status' => true]);
    }


    public function ajax_edit($id)
	{
		$data = $this->db->query("SELECT * FROM keuangan_dpcicilan WHERE id_customer='$id'")->result();
        $cust = $this->db->query("SELECT * FROM customer WHERE id_customer='$id'")->row_array();
		$a = '<table class="table table-bordered">
            <tr>
                <th>No.</th>
                <th>Tanggal Pembayaran</th>
                <th>Nominal Bayar</th>
                <th>Kekurangan</th>
                <th>Action</th>
            </tr>
            
            <tr>
                <td>1</td>
                <td>Booking Fee</td>
                <td align="right">0</td>
                <td align="right">'.rupiah($cust['booking_fee']).'</td>
                <td></td>
            </tr>';
        $no = 2;
        $sisa = $cust['booking_fee'];
        foreach($data as $dt) {
            $sisa = $sisa - $dt->nominal;
            $a .= '<tr>
                <td>'.$no++.'</td>
                <td>'.tgl_indo($dt->tanggal).'</td>
                <td align="right">'.rupiah($dt->nominal).'</td>
                <td align="right">'.rupiah($sisa).'</td>
                <td align="center"><a class="btn btn-xs btn-danger" href="javascript:void(0)" title="Hapus" onclick="hapus('."'".$dt->id_keu_dpcicilan."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a></td>
            </tr>';
        }

        $a .= '</table>';

        echo $a;
	}


    
}
