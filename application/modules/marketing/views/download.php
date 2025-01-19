<?php
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment;filename=\"Marketing.xls\"");
header("Cache-Control: max-age=0");

?>

<table border="1">
        <tr>
            <th>No</th>
            <th>ID Kode Agen</th>
            <th>Nama Marketing</th>
            <th>Nama Agen</th>
            <th>Jenis Kelamin</th>
            <th>No. Telp</th>
            <th>Alamat</th>
            <th>NIK</th>
            <th>KTP</th>
            <th>NPWP</th>
            <th>Presentase Fee Marketing</th>
            <th>Harga Jual AJB</th>
        </tr>

        <?php 
        $no =1;
        foreach ($downData as $dt) {
            echo '<tr>
            <td>'.$no++.'</td>
            <td>'.$dt->kode_marketing.'</td>
            <td>'.$dt->nama_marketing.'</td>
            <td>'.$dt->nama_agen.'</td>
            <td>'.$dt->jenis_kelamin.'</td>
            <td>'.$dt->no_telp_marketing.'</td>
            <td>'.$dt->alamat_marketing.'</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>';
        }
        ?>

</table>
