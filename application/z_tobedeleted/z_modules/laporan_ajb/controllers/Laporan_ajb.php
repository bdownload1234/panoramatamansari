<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Laporan_ajb extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->model('transaksi/Transaksi_model', 'trx');
        $this->load->model('customer/Customer_model', 'cust');
        $this->load->model('Ajb_model');
        $this->load->library('form_validation');

        check_login();
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));

        if ($q <> '') {
            $config['base_url'] = base_url() . 'laporan_ajb/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'laporan_ajb/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'laporan_ajb/index.html';
            $config['first_url'] = base_url() . 'laporan_ajb/index.html';
        }

        $config['per_page'] = 0; // Ubah ini agar tidak ada limit pada jumlah data yang ditampilkan
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Ajb_model->total_rows($q);
        $ajb = $this->Ajb_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        //Join Tabel
        $trx_data = $this->trx->get_all();
        $cust_data = $this->cust->get_all();

        $data = array(
            'ajb_data' => $ajb,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'content' => 'backend/ajb_laporan2',
        );
        $user_data['title'] = 'Laporan AJB';
        $user_data['menu_active'] = 'Laporan';
        $user_data['sub_menu_active'] = 'Laporan AJB';
        $user_data['trx_content'] = $trx_data;
        $user_data['cust_content'] = $cust_data;

        $this->load->view($data['content'], $data);
    }


    public function filter()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));

        if ($q <> '') {
            $config['base_url'] = base_url() . 'laporan_ajb/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'laporan_ajb/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'laporan_ajb/index.html';
            $config['first_url'] = base_url() . 'laporan_ajb/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Ajb_model->total_rows($q);
        $ajb = $this->Ajb_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        //Join Tabel
        $trx_data = $this->trx->get_all();
        $cust_data = $this->cust->get_all();

        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');

        $data = array(
            'ajb_laporan_data' => $ajb,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'content' => 'backend/ajb_laporan2',
            'ajb_data' => $this->Ajb_model->filter_by_date($start_date, $end_date),
            'start_date' => $start_date,
            'end_date' => $end_date,
        );
        $user_data['title'] = 'Laporan AJB';
        $user_data['menu_active'] = 'Laporan';
        $user_data['sub_menu_active'] = 'Laporan AJB';
        $user_data['trx_content'] = $trx_data;
        $user_data['cust_content'] = $cust_data;

        $this->load->view($data['content'], $data);
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "laporan_ajb.xls";
        $judul = "Laporan AJB";
        $tablehead = 0;
        $tablebody = 1;
        $nourut = 1;
        //penulisan header
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename=" . $namaFile . "");
        header("Content-Transfer-Encoding: binary ");

        xlsBOF();

        $kolomhead = 0;
        xlsWriteLabel($tablehead, $kolomhead++, "No");
        xlsWriteLabel($tablehead, $kolomhead++, "SKP");
        xlsWriteLabel($tablehead, $kolomhead++, "Tanggal");
        xlsWriteLabel($tablehead, $kolomhead++, "Customer");
        xlsWriteLabel($tablehead, $kolomhead++, "Notaris");
        xlsWriteLabel($tablehead, $kolomhead++, "Keterangan");

        foreach ($this->Ajb_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
            xlsWriteLabel($tablebody, $kolombody++, $data->nomor_skp);
            xlsWriteLabel($tablebody, $kolombody++, $data->tanggal_ajb);
            xlsWriteLabel($tablebody, $kolombody++, $data->nama_lengkap);
            xlsWriteLabel($tablebody, $kolombody++, $data->notaris);
            xlsWriteLabel($tablebody, $kolombody++, $data->keterangan_ajb);

            $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }


    public function export()
    {
        include APPPATH . 'third_party/PHPExcel/PHPExcel.php';

        $excel = new PHPExcel();

        $excel->getProperties()->setCreator('Laporan AJB')
            ->setLastModifiedBy('Kota Sutera')
            ->setTitle('Laporan AJB')
            ->setDescription('Laporan AJB')
            ->setKeyword('Laporan AJB');


        $style_col = array(
            'font' => array('bold' => true),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ),
            'borders' => array(
                'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
            )
        );

        $style_row = array(
            'font' => array('bold' => true),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ),
            'borders' => array(
                'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
            )
        );

        $excel->setActiveSheetIndex(0)->setCellValue('A1', "Laporan AJB");
        $excel->getActiveSheet()->mergeCells('A1:F1');
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
        $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $excel->setActiveSheetIndex(0)->setCellValue('A3', "No");
        $excel->setActiveSheetIndex(0)->setCellValue('B3', "SKP");
        $excel->setActiveSheetIndex(0)->setCellValue('C3', "Tanggal");
        $excel->setActiveSheetIndex(0)->setCellValue('D3', "Customer");
        $excel->setActiveSheetIndex(0)->setCellValue('E3', "Notaris");
        $excel->setActiveSheetIndex(0)->setCellValue('F3', "Keterangan");

        $excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);

        $data = $this->Ajb_model->get_all();

        $no = 1;
        $numrow = 4;
        foreach ($data as $value) {
            $excel->getActiveSheet()->setCellValue('A' . $numrow, $no);
            $excel->getActiveSheet()->setCellValue('B' . $numrow, $value->nomor_skp);
            $excel->getActiveSheet()->setCellValue('C' . $numrow, $value->tanggal_ajb);
            $excel->getActiveSheet()->setCellValue('D' . $numrow, $value->nama_lengkap);
            $excel->getActiveSheet()->setCellValue('E' . $numrow, $value->notaris);
            $excel->getActiveSheet()->setCellValue('F' . $numrow, $value->keterangan);
        }

        $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $excel->getActiveSheet()->getColumnDimension('F')->setWidth(30);

        //Height

        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

        $excel->getActiveSheet(0)->setTitle('Laporan AJB');
        $excel->getActiveSheetIndex(0);

        //Proses File Excel

        $file_name = 'laporan_ajb.xls';
        $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
        ob_end_clean();

        header('Content-type: application/vnd.ms.excel');
        header('Content-Disposition: attachment; filename' . $file_name);

        $objWriter->save('php://output');
    }
}
