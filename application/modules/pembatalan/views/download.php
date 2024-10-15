<?php
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment;filename=\"Data Penjualan Pembatalan.xls\"");
header("Cache-Control: max-age=0");
?>

<table border="1">
    <tr>
        <th width="5%">No</th>
        <th width="30%">Tanggal Pembatalan</th>
        <th width="30%">Nama Customer</th>
        <th width="10%">No. Telp</th>
        <th width="10%">Lokasi Rumah</th>
        <th width="10%">Keterangan</th>
    </tr>
    <?php
        $no = 1;
        foreach($data as $data){
            echo '
                <tr>
                    <td>'.$no++.'</td>
                    <td>'.tgl_indo($data->tanggal_pembatalan).'</td>
                    <td>'.$data->nama_lengkap.'</td>
                    <td>'.$data->kode_kavling.'</td>
                    <td>`'.$data->no_telp.'</td>
                    <td>'.$data->keterangan_pembatalan.'</td>
                </tr>
            ';
        }
    
    ?>
</table>