<?php
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment;filename=\"Marketing.xls\"");
header("Cache-Control: max-age=0");

?>

<table border="1">
        <tr>
            <th>No</th>
            <th>Kode Kavling</th>
            <th>Nama Marketing</th>
            <th>Nama Agen</th>
            <th>Alamat Marketing</th>
            <th>No. Telp Marketing</th>
            <th>Pekerjaan</th>
            <th>Jenis Kelamin</th>
        </tr>

        <?php 
        $no =1;
        foreach ($downData as $dt) {
            echo '<tr>
            <td>'.$no++.'</td>
            <td>'.$dt->kode_marketing.'</td>
            <td>'.$dt->nama_marketing.'</td>
            <td>'.$dt->nama_agen.'</td>
            <td>'.$dt->alamat_marketing.'</td>
            <td>'.$dt->no_telp_marketing.'</td>
            <td>'.$dt->pekerjaan.'</td>
            <td>'.$dt->jenis_kelamin.'</td>
        </tr>';
        }
        ?>

</table>
