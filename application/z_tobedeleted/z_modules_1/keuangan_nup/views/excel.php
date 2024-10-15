<?php 
header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=abc.xls");  //File name extension was wrong
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);
?>
<h2>Data Keuangan NUP</h2>
<table border="1">
    <tr>
        <td width="50px">No.</td>
        <td width="150px">Tanggal NUP</td>
        <td width="350">Nama Customer</td>
        <td width="150px">No. Telp</td>
        <td width="150px">Lokasi Rumah</td>
        <td width="150px">Tipe Rumah Rumah</td>
        <td width="150px">Nominal Booking</td>
    </tr>
    <?php 
    $no = 1;
    foreach ($keuangan_nup as $dt) {
        echo '<tr>
        <td>'.$no++.'</td>
        <td>'.tgl_indo($dt->tanggal).'</td>
        <td>'.$dt->nama_lengkap.'</td>
        <td>'.$dt->no_telp.'</td>
        <td>'.$dt->lokasi_kavling.'</td>
        <td>'.$dt->tipe_unit.'</td>
        <td align="right">'.rupiah($dt->nominal).'</td>
    </tr>';
    }
    ?>
</table>