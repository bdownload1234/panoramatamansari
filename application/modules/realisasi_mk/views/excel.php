<?php 
header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=Data-Realisasi-MK.xls");  //File name extension was wrong
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);
?>
<h2>Data Keuangan Booking</h2>
<table border="1">
    <tr>
        <th width="5%">No</th>
        <th width="20%">Nama Customer</th>
        <th>Blok Kavling</th>
        <th>Realisasi MK</th>
        <th>Pencairan</th>
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
            if(($datax->realisasi_mk-$datax->pencairan) == 0){
                $status = 'Lunas';
            }else{
                $status = 'Belum Lunas';
            }
            echo '
                <tr>
                    <td>'.$no.'</td>
                    <td>'.$datax->nama_lengkap.'</td>
                    <td>'.$datax->kode_kavling.'</td>
                    <td>'.number_format($datax->realisasi_mk, 2).'</td>
                    <td>'.number_format($datax->pencairan, 2).'</td>
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
            $no++;
        }
    ?>
</table>