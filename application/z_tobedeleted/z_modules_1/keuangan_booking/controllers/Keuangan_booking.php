<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Keuangan_booking extends CI_Controller
{
    var $data_ref = ['uri_controllers' => 'keuangan_booking'];

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Keuangan_booking_model', 'keuangan_booking');
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
        $list = $this->keuangan_booking->get_datatables();
        $data = [];
        $no = $_POST['start'];

        foreach ($list as $post) {
            $link_edit = '<a class="btn btn-xs btn-warning" href="javascript:void(0)" onclick="edit(' . "'" . $post->id_keu_booking . "'" . ')"> Edit Pajak</a>';
            $link_hapus = ' <a class="btn btn-xs btn-danger" href="javascript:void(0)" title="Hapus" onclick="hapus(' . "'" . $post->id_keu_booking . "'" . ')">Delete</a>';

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
            'recordsTotal' => $this->keuangan_booking->count_all(),
            'recordsFiltered' => $this->keuangan_booking->count_filtered(),
            'data' => $data,
        ];
        //output to json format
        echo json_encode($output);
    }


    public function ajax_delete($id)
    {
        $this->db->delete('keuangan_booking', ['id_keu_booking' => $id]);
        echo json_encode(['status' => true]);
    }


    function excel()
    {
        $user_data['keuangan_booking'] = $this->db->query("SELECT * FROM keuangan_booking k LEFT JOIN 
        customer c ON c.id_registrasi = k.id_registrasi")->result();
        $this->load->view('excel', $user_data);
    }
}
