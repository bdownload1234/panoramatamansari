<?php 
header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=Data-Keuangan-Booking.xls");  //File name extension was wrong
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);
?>
<h2>Data Keuangan Booking</h2>
<table border="1">
    <tr>
        <td width="50px">No.</td>
        <td width="150px">Tanggal Booking</td>
        <td width="350">Nama Lengkap</td>
        <td width="150px">Lokasi Kavling</td>
        <td width="150px">Tipe Rumah</td>
        <td width="150px">Model Rumah</td>
        <td width="150px">No. Telp</td>
        <td width="150px">Nominal Booking</td>
    </tr>
    <?php 
    $no = 1;
    foreach ($keuangan_booking as $dt) {
        $id_booking = str_pad($dt->id_keu_booking, 4, '0', STR_PAD_LEFT);
        $bln = bln_indo($dt->tanggal);
        $thn = thn_indo($dt->tanggal);

        $no_booking = $id_booking . '/PTP/' . $bln . '/' . $thn;


        echo '<tr>
        <td>'.$no_booking.'</td>
        <td>'.tgl_indo($dt->tanggal).'</td>
        <td>'.$dt->nama_lengkap.'</td>
        <td>'.$dt->lokasi_kavling.'</td>
        <td>'.$dt->tipe_unit.'</td>
        <td>'.$dt->model_rumah.'</td>
        <td>'.$dt->no_telp.'</td>
        <td align="right">'.rupiah($dt->nominal).'</td>
    </tr>';
    }
    ?>
</table>