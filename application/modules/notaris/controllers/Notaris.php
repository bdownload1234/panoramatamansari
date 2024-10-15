<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notaris extends CI_Controller
{
    var $data_ref = ['uri_controllers' => 'notaris'];

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Notaris_model', 'notaris');
        check_login();
    }

    public function index()
    {
        $user_data['data_ref'] = $this->data_ref;
        $this->load->view('template/header', $user_data);
        $this->load->view('view', $user_data);
    }

    public function download()
	{
		$data['downData'] = $this->db->query("SELECT * FROM notaris")->result();
		$this->load->view('download', $data);
	}

    public function ajax_list()
    {
        $list = $this->notaris->get_datatables();
        $data = [];
        $no = $_POST['start'];

        foreach ($list as $post) {
            $link_edit = ' <a class="btn btn-xs btn-primary" href="javascript:void(0)" title="Edit" onclick="edit(' . "'" . $post->id_notaris . "'" . ')"> Edit</a>';
            $link_hapus = ' <a class="btn btn-xs btn-danger" href="javascript:void(0)" title="Hapus" onclick="hapus(' . "'" . $post->id_notaris . "'" . ')"> Delete</a>';

            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $post->kode_notaris;
            $row[] = $post->nama_notaris;
            $row[] = $post->no_telp;
            $row[] = $post->alamat;
            $row[] = $post->jumlah_akad;

            $row[] = $link_edit . $link_hapus;
            $data[] = $row;
        }

        $output = [
            'draw' => $_POST['draw'],
            'recordsTotal' => $this->notaris->count_all(),
            'recordsFiltered' => $this->notaris->count_filtered(),
            'data' => $data,
        ];
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id)
    {
        $data = $this->notaris->get_by_id($id);
        echo json_encode($data);
    }

    public function ajax_add()
    {
        $data = [
            'kode_notaris' => strtoupper($this->input->post('kode_notaris')),
            'nama_notaris' => strtoupper($this->input->post('nama_notaris')),
            'no_telp' => $this->input->post('no_telp'),
            'alamat' => $this->input->post('alamat'),
        ];

        $this->notaris->save($data);
        echo json_encode(['status' => true]);
    }

    public function ajax_update()
    {
        $data = [
            'kode_notaris' => strtoupper($this->input->post('kode_notaris')),
            'nama_notaris' => strtoupper($this->input->post('nama_notaris')),
            'no_telp' => $this->input->post('no_telp'),
            'alamat' => $this->input->post('alamat'),
        ];
        $this->notaris->update(['id_notaris' => $this->input->post('id')], $data);
        echo json_encode(['status' => true]);
    }

    public function ajax_delete($id)
    {
        $this->db->delete('notaris', ['id_notaris' => $id]);
        echo json_encode(['status' => true]);
    }
}
