<html>
    <style>
        @page { margin: 0px; }
        body { margin: 0px; }
    </style>
    <body style="">
        <img src="<?php echo base_url('./assets/kop surat panorama.png'); ?>" width="100%">
        <div style="width: 100%; padding: 5%; text-align: justify;">
            <table style="width: 100%; border: 0px; border-collapse: collapse;">
                <tr>
                    <td width="10%">Lampiran</td>
                    <td width="5%">:</td>
                    <td>1 Lembar</td>
                    <td width="25%">Kepada <b>Yth,</b></td>
                </tr>
                <tr>
                    <td>Perihal</td>
                    <td>:</td>
                    <td>Undangan Akad Kredit</td>
                    <td><b>Bapak/Ibu</b></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Di Tempat</td>
                </tr>
            </table>
            <br>
            <br>
            <b><i>Assalamualaikum Wr. Wb</i></b>
            <br>
            Dengan hormat,
            <br>
            <br>
            Sehubungan telah diterbitkannya Surat Persetujuan KPR Bank <?php echo $nama_bank ?> Cabang <?php echo $alamat_bank ?>, dengan ini kami mengundang Bapak / Ibu untuk Realisasi Akad Kredit dengan Bank <?php echo $nama_bank ?>, Developer dan Notaris yang akan dilaksanakan pada:
            <br>
            <div style="width: 100%; text-align: center; padding-left: 100px; padding-right: 100px">
                <table style="width: 100%; border: 0px; border-collapse: collapse;">
                    <tr>
                        <td width="25%">Hari / Tanggal</td>
                        <td width="5%">:</td>
                        <td><?php setlocale(LC_ALL, 'IND'); echo date('l', strtotime($tanggal)).', '.$tanggal ?></td>
                    </tr>
                    <tr>
                        <td>Waktu</td>
                        <td>:</td>
                        <td><?php echo $jam ?></td>
                    </tr>
                    <tr>
                        <td>Tempat</td>
                        <td>:</td>
                        <td><?php echo $tempat ?></td>
                    </tr>
                </table>
            </div>
            <br>
            Dengan membawa Persyaratan Akad Kredit diataranya sebagai berikut:
            <br>
            1. Buku Tabungan Bank xxx
            <br>
            2. KTP Pemohon dan KTP Pasangan (Jika Sudah Menikah)
            <br>
            3. Kartu Keluarga
            <br>
            4. NPWP
            <br>
            5. Kartu BPJS Kesehatan
            <br>
            6. Materai @10.000 sebanyak xx Lembar
            <br>
            <br>
            Demikian surat undangan Akad Kredit ini kami sampaikan atas perhatian dan kedatangannya kami ucapakan terima kasih.
            <br>
            <br>
            <br>
            <b><i>Wassalamualaikum Wr. Wb</i></b>
            <br>
            <br>
            <br>
            <i>Best Regards</i>
            <br>
            <b>Panorama Tamansari</b>
        </div>
    </body>
</html>