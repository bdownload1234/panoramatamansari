<?php
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment;filename=\"Daftar Hadir.xls\"");
header("Cache-Control: max-age=0");

?>
<table border="1">
        <tr>
            <th width="5%">No</th>
            <th>Nomor SPR</th>
            <th>Tempat</th>
            <th>Tanggal Akad</th>
            <th>Jam Akad</th>
            <th>Blok Unit</th>
            <th>Nama Customer</th>
            <th>Harga Jual AJB</th>
            <th>Jenis Pembelian</th>
            <th>Jenis Akad</th>
            <th>Notaris</th>
            <th>No Rekening</th>
            <th>Keterangan</th>
        </tr>

        <?php 
        $no =1;
        foreach ($downData as $dt) {
            echo "<tr>
            <td>".$no++."</td>
            <td>".$dt->nomor_spr."</td>
            <td>".$dt->tempat."</td>
            <td>".(date_format(date_create($dt->tanggal), "d/m/Y"))."</td>
            <td>".$dt->jam."</td>
            <td>".$dt->lokasi_kavling."</td>
            <td>".$dt->nama_lengkap."</td>
            <td>".$dt->harga_jual_ajb."</td>
            <td>".$dt->jenis_pembelian."</td>
            <td>".$dt->jenis_akad."</td>
            <td>".$dt->nama_notaris."</td>
            <td>".$dt->nama_bank.' - '.$dt->no_rekening."</td>
            <td>".$dt->keterangan."</td>
        </tr>";
        }
        ?>

</table>
