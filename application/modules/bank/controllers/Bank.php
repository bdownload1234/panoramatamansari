<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bank extends CI_Controller
{
    var $data_ref = ['uri_controllers' => 'bank'];

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Bank_model', 'bank');
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
        $list = $this->bank->get_datatables();
        $data = [];
        $no = $_POST['start'];

        foreach ($list as $post) {
            $link_edit = ' <a class="btn btn-xs btn-primary" href="javascript:void(0)" title="Edit" onclick="edit(' . "'" . $post->id_bank . "'" . ')"> Edit</a>';
            $link_hapus = ' <a class="btn btn-xs btn-danger" href="javascript:void(0)" title="Hapus" onclick="hapus(' . "'" . $post->id_bank . "'" . ')"> Delete</a>';

            $no++;
            $row = [];
            $row[] = $no;
            // $row[] = $post->kode_bank;
            $row[] = $post->nama_bank;
            // $row[] = $post->bunga_pertahun;
            // $row[] = $post->tenor;
            // $row[] = $post->norekening;
            // $row[] = $post->nama_pemilik;
            // $row[] = $post->v_account_bank;
            $row[] = $post->alamat_bank;
            $row[] = $post->no_telp;
            $row[] = $post->keterangan;

            $row[] = $link_edit . $link_hapus;
            $data[] = $row;
        }

        $output = [
            'draw' => $_POST['draw'],
            'recordsTotal' => $this->bank->count_all(),
            'recordsFiltered' => $this->bank->count_filtered(),
            'data' => $data,
        ];
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id)
    {
        $data = $this->bank->get_by_id($id);
        echo json_encode($data);
    }

    public function ajax_add()
    {
        $data = [
            'kode_bank' => strtoupper($this->input->post('kode_bank')),
            'nama_bank' => strtoupper($this->input->post('nama_bank')),
            'bunga_pertahun' => $this->input->post('bunga_pertahun'),
            'tenor' => $this->input->post('tenor'),
            'norekening' => $this->input->post('no_rekening'),
            'nama_pemilik' => $this->input->post('nama_pemilik'),
            'v_account_bank' => $this->input->post('v_account_bank'),
            'alamat_bank' => $this->input->post('alamat_bank'),
            'no_telp' => $this->input->post('no_telp'),
            'keterangan' => $this->input->post('keterangan'),
        ];

        $this->bank->save($data);
        echo json_encode(['status' => true]);
    }

    public function ajax_update()
    {
        $data = [
            'kode_bank' => strtoupper($this->input->post('kode_bank')),
            'nama_bank' => strtoupper($this->input->post('nama_bank')),
            'bunga_pertahun' => $this->input->post('bunga_pertahun'),
            'tenor' => $this->input->post('tenor'),
            'norekening' => $this->input->post('no_rekening'),
            'nama_pemilik' => $this->input->post('nama_pemilik'),
            'v_account_bank' => $this->input->post('v_account_bank'),
            'alamat_bank' => $this->input->post('alamat_bank'),
            'no_telp' => $this->input->post('no_telp'),
            'keterangan' => $this->input->post('keterangan'),
        ];

        $this->bank->update(['id_bank' => $this->input->post('id')], $data);
        echo json_encode(['status' => true]);
    }

    public function ajax_delete($id)
    {
        $this->db->delete('bank', ['id_bank' => $id]);
        echo json_encode(['status' => true]);
    }

    public function lampiran($id)
    {
        $a = '<thead>
    <tr>
     <th width="5%">No</th>
     <th width="15%">Tanggal</th>
     <th width="25%">Kode Kavling</th>
     <th width="25%">Jenis Penjualan</th>
     <th width="25%">Jumlah Komisi</th>
   </tr>
   </thead>
   <tbody>';
        $b = '';
        $no = 1;
        $query = "SELECT * FROM kavling_peta k LEFT JOIN transaksi_kavling t ON k.id_kavling = t.id_kavling WHERE t.id_bank='$id'";
        $komisi = $this->db->query($query)->result();
        foreach ($komisi as $kms) {
            if ($kms->status == '2') {
                $jenis = 'Cash';
            } elseif ($kms->status == '3') {
                $jenis = 'Kredit';
            } elseif ($kms->status == '1') {
                $jenis = 'Booking';
            }
            $b .=
                '<tr>
    
   <td>' .
                $no++ .
                '</td>
   <td>' .
                tgl_indo($kms->tgl_pembelian) .
                '</td>
   <td>' .
                $kms->kode_kavling .
                '</td>
   <td>' .
                $jenis .
                '</td>
   <td>' .
                rupiah($kms->fee_bank) .
                '</td>
  </tr>';
        }

        echo $a . $b . '</tbody>';
    }

    public function no_mark()
    {
        $nomor = $this->db->query('SELECT MAX(kode_bank) as besar FROM bank')->row_array();
        $noCustRX = $nomor['besar'];

        $urutanTRX = (int) substr($noCustRX, 2, 3);
        $urutanTRX++;
        $hurufTRX = 'M-';
        $noCust = $hurufTRX . sprintf('%03s', $urutanTRX);
        return $noCust;
    }

    private function _do_upload()
    {
        $config['upload_path'] = './foto_bank/';
        $config['allowed_types'] = 'gif|jpg|png|pdf';
        $config['max_size'] = 1000; //set max size allowed in Kilobyte
        $config['max_width'] = 3000; // set max width image allowed
        $config['max_height'] = 3000; // set max height allowed
        $config['file_name'] = round(microtime(true) * 1000); //just milisecond timestamp fot unique name

        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('foto')) {
            //upload and validate
            $data['inputerror'][] = 'foto';
            $data['error_string'][] = 'Upload error: ' . $this->upload->display_errors('', ''); //show ajax error
            $data['status'] = false;
            echo json_encode($data);
            exit();
        }
        return $this->upload->data('file_name');
    }
}
