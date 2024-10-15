<?php
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment;filename=\"Customer.xls\"");
header("Cache-Control: max-age=0");

?>
<table border="1">
        <tr>
            <th width="5%">No</th>
            <th width="15%">Nama Customer</th>
            <th width="10%">NIK</th>
            <th width="10%">Alamat</th>
            <th>Tempat Bekerja</th>
            <th>Alamat Tempat Bekerja</th>
            <th>Booking Fee</th>
            <th>Nama Marketing</th>
            <th>email</th>
            <th>No. Telp</th>
            <th>Nama Saudara</th>
            <th>Hubungan Saudara</th>
            <th>Telp Saudara</th>
            <th>Pengalaman Interaksi</th>
            <th>Lokasi Kavling</th>
            <th>Tipe Unit</th>
        </tr>

        <?php 
        $no =1;
        foreach ($downData as $dt) {
            echo "<tr>
            <td>".$no++."</td>
            <td>".$dt->nama_lengkap."</td>
            <td>".("'".$dt->nik)."</td>
            <td>".$dt->alamat."</td>
            <td>".$dt->nama_perusahaan."</td>
            <td>".$dt->alamat_kantor."</td>
            <td>".$dt->booking_fee."</td>
            <td>".$dt->nama_marketing."</td>
            <td>".$dt->email."</td>
            <td>".("'".$dt->no_telp)."</td>
            <td>".$dt->nama_saudara."</td>
            <td>".$dt->hubungan_saudara."</td>
            <td>".("'".$dt->no_telp_saudara)."</td>
            <td>".$dt->pengalaman_interaksi."</td>
            <td>".$dt->lokasi_kavling."</td>
            <td>".$dt->tipe_unit."</td>
        </tr>";
        }
        ?>

</table>
