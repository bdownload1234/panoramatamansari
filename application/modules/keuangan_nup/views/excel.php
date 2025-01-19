<?php 
header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=Data-Keuangan-NUP.xls");  //File name extension was wrong
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);
?>
<h2>Data Keuangan NUP</h2>
<table border="1">
    <tr>
        <td width="50px">No.</td>
        <td width="150px">Tanggal Booking</td>
        <td width="350">Nama Lengkap</td>
        <td width="150px">Lokasi Kavling</td>
        <td width="150px">Model Rumah</td>
        <td width="150px">Nominal</td>
    </tr>
    <?php 
    $no = 1;
    foreach ($keuangan_nup as $dt) {
        echo '<tr>
        <td>'.$no++.'</td>
        <td>'.tgl_indo($dt->tanggal).'</td>
        <td>'.$dt->nama_lengkap.'</td>
        <td>'.$dt->lokasi_kavling.'</td>
        <td>'.$dt->tipe_unit.'</td>
        <td align="right">'.rupiah($dt->nominal).'</td>
    </tr>';
    }
    ?>
</table>