<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pajakakad extends CI_Controller
{
    var $data_ref = ['uri_controllers' => 'pajakakad'];

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Pajakakad_model', 'pajakakad');
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
        $list = $this->pajakakad->get_datatables();
        $data = [];
        $no = $_POST['start'];

        foreach ($list as $post) {
            $link_edit = '<a class="btn btn-xs btn-warning" href="javascript:void(0)" onclick="edit(' . "'" . $post->id_pajak . "'" . ')"> Edit Pajak</a>';
            $link_hapus = ' <a class="btn btn-xs btn-danger" href="javascript:void(0)" title="Hapus" onclick="hapus(' . "'" . $post->id_pajak . "'" . ')">Delete</a>';

            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $post->id_billing;
            $row[] = $post->NTPN_akad;
            $row[] = $post->no_seri_pajak_akad;
            if ($post->lampiran_pajak_akad == '') {
                $row[] = '';
            } else {
                $row[] = '<div style="text-align:center;"><a href="#" onclick="lampiran_1(' . "'" . $post->id_pajak . "'" . ')" class="btn btn-success btn-xs">View Lampiran</a></div>';
            }

            if ($post->lampiran_bphtb == '') {
                $row[] = '';
            } else {
                $row[] = '<div style="text-align:center;"><a href="#" onclick="lampiran_2(' . "'" . $post->id_pajak . "'" . ')" class="btn btn-success btn-xs">View Lampiran</a></div>';
            }

            $row[] = $link_edit . $link_hapus;
            $data[] = $row;
        }
        $output = [
            'draw' => $_POST['draw'],
            'recordsTotal' => $this->pajakakad->count_all(),
            'recordsFiltered' => $this->pajakakad->count_filtered(),
            'data' => $data,
        ];
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id)
    {
        $data = $this->db->get_where('pajak_akad', ['id_pajak' => $id])->row();
        echo json_encode($data);
    }

    public function ajax_add()
    {
        $data = [
            'id_billing' => $this->input->post('id_billing'),
            'NTPN_akad' => $this->input->post('NTPN'),
            'no_seri_pajak_akad' => $this->input->post('no_seri_akad'),
            'keterangan' => $this->input->post('keterangan'),
        ];

        if (!empty($_FILES['lampiran_akad']['name'])) {
            $upload = $this->_do_upload();
            $data['lampiran_pajak_akad'] = $upload;
        }

        if (!empty($_FILES['lampiran_bphtb']['name'])) {
            $upload = $this->_do_upload_bphtb();
            $data['lampiran_bphtb'] = $upload;
        }

        $this->db->insert('pajak_akad', $data);
        echo json_encode(['status' => true]);
    }

    public function ajax_update()
    {
        $data = [
            'id_billing' => $this->input->post('id_billing'),
            'NTPN_akad' => $this->input->post('NTPN'),
            'no_seri_pajak_akad' => $this->input->post('no_seri_akad'),
            'keterangan' => $this->input->post('keterangan'),
        ];

        if (!empty($_FILES['lampiran_akad']['name'])) {
            $upload = $this->_do_upload();
            $data['lampiran_pajak_akad'] = $upload;
        }

        if (!empty($_FILES['lampiran_bphtb']['name'])) {
            $upload = $this->_do_upload_bphtb();
            $data['lampiran_bphtb'] = $upload;
        }

        $this->pajakakad->update(['id_pajak' => $this->input->post('id')], $data);

        echo json_encode(['status' => true]);
    }

    public function ajax_delete($id)
    {
        $this->db->delete('pajak_akad', ['id_pajak' => $id]);
        echo json_encode(['status' => true]);
    }

    private function _do_upload()
    {
        $config['upload_path'] = './lampiran_pajak/';
        $config['allowed_types'] = 'gif|jpg|png|docx|xlsx|zip|rar_zip|pdf';
        $config['file_name'] = round(microtime(true) * 1000); //just milisecond timestamp fot unique name

        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('lampiran_akad')) {
            //upload and validate
            $data['inputerror'][] = 'lampiran_akad';
            $data['error_string'][] = 'Upload error: ' . $this->upload->display_errors('', ''); //show ajax error
            $data['status'] = false;
            echo json_encode($data);
            exit();
        }
        return $this->upload->data('file_name');
    }

    private function _do_upload_bphtb()
    {
        $config['upload_path'] = './lampiran_pajak/';
        $config['allowed_types'] = 'gif|jpg|png|docx|xlsx|zip|rar_zip|pdf';
        $config['file_name'] = round(microtime(true) * 1000); //just milisecond timestamp fot unique name

        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('lampiran_bphtb')) {
            //upload and validate
            $data['inputerror'][] = 'lampiran_bphtb';
            $data['error_string'][] = 'Upload error: ' . $this->upload->display_errors('', ''); //show ajax error
            $data['status'] = false;
            echo json_encode($data);
            exit();
        }
        return $this->upload->data('file_name');
    }

    function view_lampiran($idPajak = '')
    {
        $lamp = $this->db->get_where('pajak_akad', ['id_pajak' => $idPajak])->row_array();
        echo '<iframe id="pdfViewer" src="' . base_url('lampiran_pajak/' . $lamp['lampiran_pajak_akad']) . '" frameborder="0" style="width: 100%; height: 800px;"></iframe>';
        // echo json_encode(array("status" => TRUE));
    }

    function view_lampiran_2($idPajak = '')
    {
        $lamp = $this->db->get_where('pajak_akad', ['id_pajak' => $idPajak])->row_array();
        echo '<iframe id="pdfViewer" src="' . base_url('lampiran_pajak/' . $lamp['lampiran_bphtb']) . '" frameborder="0" style="width: 100%; height: 800px;"></iframe>';
        // echo json_encode(array("status" => TRUE));
    }
}
