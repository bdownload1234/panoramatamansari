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
        // print_r($list);
        $data = [];
        $no = $_POST['start'];

        foreach ($list as $post) {
            $link_edit = '<a class="btn btn-xs btn-warning" href="javascript:void(0)" onclick="edit(' . "'" . $post->id_keu_booking . "'" . ')"> Edit Pajak</a>';
            $link_hapus = ' <a class="btn btn-xs btn-danger" href="javascript:void(0)" title="Hapus" onclick="hapus(' . "'" . $post->id_keu_booking . "'" . ')">Delete</a>';
            $link_print = ' <a class="btn btn-xs btn-info" href="javascript:void(0)" title="Print" onclick="print(' . "'" . $post->id_keu_booking . "'" . ')">Print</a>';

            $no++;
            $row = [];
            // make no relative using 0000, so if its 1 it will be 0001, if its 11 it will be 0011
            $id_booking = str_pad($post->id_keu_booking, 4, '0', STR_PAD_LEFT);
            $bln = bln_indo($post->tanggal);
            $thn = thn_indo($post->tanggal);
            $row[] = $id_booking . '/PTP/' . $bln . '/' . $thn;
            $row[] = tgl_indo($post->tanggal);
            $row[] = $post->nama_lengkap;
            $row[] = $post->lokasi_kavling;
            $row[] = $post->tipe_bangunan;
            $row[] = $post->model_rumah;
            $row[] = rupiah($post->nominal);

            $row[] = $link_hapus . $link_print;
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

    function print($id)
    {
        $this->load->library('pdfgenerator');
        $data['keuangan_booking'] = $this->keuangan_booking->get_by_id($id);

        // print_r($data['keuangan_booking']);

        $id_booking = str_pad($data['keuangan_booking']->id_keu_booking, 4, '0', STR_PAD_LEFT);
        $bln = bln_indo($data['keuangan_booking']->tanggal);
        $thn = thn_indo($data['keuangan_booking']->tanggal);
        $no_booking = $id_booking . '/PTP/' . $bln . '/' . $thn;
        $data['keuangan_booking']->no_booking = $no_booking;
        

        $html = $this->load->view('print', $data, true);
        return $this->pdfgenerator->generate($html, 'print');

        // dd equivalent codeigniter 3
        
    }
}
