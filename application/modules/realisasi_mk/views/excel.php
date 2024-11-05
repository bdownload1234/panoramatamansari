<?php 
header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=Data-Realisasi-MK.xls");  //File name extension was wrong
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);
?>
<h2>Data Realisasi MK</h2>
<table border="1">
    <tr>
        <th>Nomor Akad</th>
        <th>Tanggal Akad</th>
        <th>Nama Customer</th>
        <th>Nama Bank</th>
        <th>Blok Kavling</th>
        <th>Realisasi MK</th>
        <th>Total Pencairan</th>
        <th>Jenis Pencairan</th>
        <th>Nominal Pencairan</th>
        <th>Tanggal Pencairan</th>
        <th>Dana Blokir Progress Bangunan 1</th>
        <th>Dana Blokir Progress Bangunan 2</th>
        <th>Dana Blokir Sertifikat</th>
        <th>Dana Blokir IMB</th>
        <th>Dana Blokir Bestek</th>
        <th>Dana Blokir Listrik</th>
        <th>Dana Blokir PPJB</th>
        <th>Dana Blokir BPHTB</th>
        <th>Dana Blokir PBB</th>
        <th>Dana Lain-Lain</th>
        <th>Status</th>
    </tr>
    <?php
        $no = 1;
        foreach($data as $key => $datax){
            if(($datax->realisasi_mk-$datax->total_pencairan) == 0){
                $status = 'Lunas';
            }else{
                $status = 'Belum Lunas';
            }

            // <option value="1">Progress Bangunan 1</option>
            // <option value="2">Progress Bangunan 2</option>
            // <option value="3">Sertifikat</option>
            // <option value="4">IMB</option>
            // <option value="5">Bestek</option>
            // <option value="6">Listrik</option>
            // <option value="7">PPJB</option>
            // <option value="8">BPHTB</option>
            // <option value="9">PBB</option>
            // <option value="10">Lain-lain</option>

            // make switch case here based on pencairan_id

            $data = $this->db->query("
                SELECT * FROM realisasi_mk_dt WHERE id_header = '".$datax->id."'
            ")->result();

           

            echo '
                <tr>
                    <td>'.$datax->no_akad.'</td>
                    <td>'.$datax->tanggal_akad.'</td>
                    <td>'.$datax->nama_lengkap.'</td>
                    <td>'.$datax->nama_bank.'</td>
                    <td>'.$datax->kode_kavling.'</td>
                    <td>'.number_format($datax->realisasi_mk, 2).'</td>
                    <td>'.number_format($datax->total_pencairan, 2).'</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>'.number_format($datax->dana_blokir_progress_bangunan_1, 2).'</td>
                    <td>'.number_format($datax->dana_blokir_progress_bangunan_2, 2).'</td>
                    <td>'.number_format($datax->dana_blokir_sertifikat, 2).'</td>
                    <td>'.number_format($datax->dana_blokir_imb, 2).'</td>
                    <td>'.number_format($datax->dana_blokir_bestek, 2).'</td>
                    <td>'.number_format($datax->dana_blokir_listrik, 2).'</td>
                    <td>'.number_format($datax->dana_blokir_ppjb, 2).'</td>
                    <td>'.number_format($datax->dana_blokir_bphtb, 2).'</td>
                    <td>'.number_format($datax->dana_blokir_pbb, 2).'</td>
                    <td>'.number_format($datax->dana_dll, 2).'</td>
                    <td>'.$status.'</td>
                </tr>
            ';

            foreach($data as $key => $datas){
                $jenis_pencairan = '';
                switch($datas->pencairan_id){
                    case 1:
                        $jenis_pencairan = 'Progress Bangunan 1';
                        break;
                    case 2:
                        $jenis_pencairan = 'Progress Bangunan 2';
                        break;
                    case 3:
                        $jenis_pencairan = 'Sertifikat';
                        break;
                    case 4:
                        $jenis_pencairan = 'IMB';
                        break;
                    case 5:
                        $jenis_pencairan = 'Bestek';
                        break;
                    case 6:
                        $jenis_pencairan = 'Listrik';
                        break;
                    case 7:
                        $jenis_pencairan = 'PPJB';
                        break;
                    case 8:
                        $jenis_pencairan = 'BPHTB';
                        break;
                    case 9:
                        $jenis_pencairan = 'PBB';
                        break;
                    case 10:
                        $jenis_pencairan = 'Lain-lain';
                        break;
                }

                echo '
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>'.$jenis_pencairan.'</td>
                    <td>'.number_format($datas->pencairan, 2).'</td>
                    <td>'.$datas->tanggal_pencairan.'</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            ';
            
            }

            $no++;
        }
    ?>
</table>