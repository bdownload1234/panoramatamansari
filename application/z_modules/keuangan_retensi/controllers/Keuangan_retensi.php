<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Keuangan_retensi extends CI_Controller
{
    var $data_ref = ['uri_controllers' => 'keuangan_nup'];

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Keuangan_nup_model', 'keuangan_nup');
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
        $list = $this->keuangan_nup->get_datatables();
        $data = [];
        $no = $_POST['start'];

        foreach ($list as $post) {
            $link_edit = '<a class="btn btn-xs btn-warning" href="javascript:void(0)" onclick="edit(' . "'" . $post->id_keu_nup . "'" . ')"> Edit Pajak</a>';
            $link_hapus = ' <a class="btn btn-xs btn-danger" href="javascript:void(0)" title="Hapus" onclick="hapus(' . "'" . $post->id_keu_nup . "'" . ')">Delete</a>';

            $no++;
            $row = [];
            $row[] = $no;
            $row[] = tgl_indo($post->tanggal);
            $row[] = $post->nama_lengkap;
            $row[] = rupiah($post->nominal);

            $row[] = $link_hapus;
            $data[] = $row;
        }
        $output = [
            'draw' => $_POST['draw'],
            'recordsTotal' => $this->keuangan_nup->count_all(),
            'recordsFiltered' => $this->keuangan_nup->count_filtered(),
            'data' => $data,
        ];
        //output to json format
        echo json_encode($output);
    }


    public function ajax_delete($id)
    {
        $this->db->delete('keuangan_nup', ['id_keu_nup' => $id]);
        echo json_encode(['status' => true]);
    }


    function excel()
    {
        $user_data['keuangan_nup'] = $this->db->query("SELECT * FROM keuangan_nup k LEFT JOIN 
        customer c ON c.id_registrasi = k.id_registrasi")->result();
        $this->load->view('excel', $user_data);
    }
}
