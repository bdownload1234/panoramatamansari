<?php
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment;filename=\"Notaris.xls\"");
header("Cache-Control: max-age=0");

?>

<table border="1">
        <tr>
            <th>No</th>
            <th>Kode NOtaris</th>
            <th>Nama Notaris</th>
            <th>No Telp</th>
            <th>Alamat Notaris</th>
        </tr>

        <?php 
        $no =1;
        foreach ($downData as $dt) {
            echo '<tr>
            <td>'.$no++.'</td>
            <td>'.$dt->kode_notaris.'</td>
            <td>'.$dt->nama_notaris.'</td>
            <td>'.$dt->no_telp.'</td>
            <td>'.$dt->alamat.'</td>
        </tr>';
        }
        ?>

</table>
