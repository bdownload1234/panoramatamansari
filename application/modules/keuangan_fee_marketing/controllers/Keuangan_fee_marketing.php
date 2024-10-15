<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Keuangan_fee_marketing extends CI_Controller
{
    var $data_ref = ['uri_controllers' => 'keuangan_fee_marketing'];

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Keuangan_fee_marketing_model', 'keuangan_fee_marketing');
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
        $list = $this->keuangan_fee_marketing->get_datatables();
        $data = [];
        $no = $_POST['start'];

        foreach ($list as $post) {
            $link_detail = '<a class="btn btn-xs btn-warning" href="javascript:void(0)" onclick="detail_marketing(' . "'" . $post->id_marketing . "'" . ')"> Detail Penjualan</a>';

            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $post->kode_marketing;
            $row[] = $post->nama_marketing;
            $row[] = $post->nama_agen;
            $jumTrx = $this->db->query("SELECT COUNT(id_keu_marketing) as jum FROM keuangan_fee_marketing WHERE id_marketing = '$post->id_marketing'")->row_array();
            $row[] = rupiah($jumTrx['jum']);
            $jumTrxNominal = $this->db->query("SELECT SUM(nominal_fee) as jum FROM keuangan_fee_marketing WHERE id_marketing = '$post->id_marketing'")->row_array();
            $row[] = rupiah($jumTrxNominal['jum']);

            $row[] = $link_detail;
            $data[] = $row;
        }
        $output = [
            'draw' => $_POST['draw'],
            'recordsTotal' => $this->keuangan_fee_marketing->count_all(),
            'recordsFiltered' => $this->keuangan_fee_marketing->count_filtered(),
            'data' => $data,
        ];
        //output to json format
        echo json_encode($output);
    }


    public function ajax_delete($id)
    {
        $this->db->delete('keuangan_fee_marketing', ['id_keu_marketing' => $id]);
        echo json_encode(['status' => true]);
    }


    function excel()
    {
        $user_data['keuangan_fee_marketing'] = $this->db->query("SELECT * FROM keuangan_fee_marketing k LEFT JOIN 
        customer c ON c.id_registrasi = k.id_registrasi")->result();
        $this->load->view('excel', $user_data);
    }

    public function ajax_detail_fee($id)
	{
		$data = $this->db->query("SELECT * FROM keuangan_fee_marketing  m
        LEFT JOIN kavling_peta k ON m.id_kavling = k.id_kavling 
        LEFT JOIN marketing mk ON mk.id_marketing = m.id_marketing 
        WHERE m.id_marketing='$id'")->result();

		$a = '<table class="table table-bordered">
            <tr>
                <th>No.</th>
                <th>Tanggal Penjualan</th>
                <th>Lokasi Kavling</th>
                <th>Nominal Fee</th>
                <th>Status Fee</th>
                <th>Action</th>
            </tr>';
        $no = 1;
        foreach($data as $dt) {
            $a .= '<tr>
                <td>'.$no++.'</td>
                <td>'.tgl_indo($dt->tanggal_transaksi).'</td>
                <td>'.tgl_indo($dt->kode_kavling).'</td>
                <td align="right">'.rupiah($dt->nominal_fee).'</td>
                <td align="right"></td>
                <td align="center"><a class="btn btn-xs btn-danger" href="javascript:void(0)" title="Hapus" onclick="hapus('."'".$dt->id_keu_marketing."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a></td>
            </tr>';
        }

        $a .= '</table>';

        echo $a;
	}


}
