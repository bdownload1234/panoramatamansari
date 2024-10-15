<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= $title_pdf;?></title>
        <style>
            body{
                font-family: Arial, Helvetica, sans-serif !important;
                font-size: 10px;
                padding: 50px;
            }
            #table {
                border-collapse: collapse;
                width: 100%;
                border: 1px solid #000;
            }
            #table td{
                padding: 5px;
                border: 1px solid #000;
            }
            
            table td{
                padding: 10px;
            }
        </style>
    </head>
    <body>
        <div style="text-align: center; font-size: 14px">
            <b>
                PERUMAHAN PANORAMA TAMAN SARI
                <br>
                <br>
                FORMULIR NUP
                <br>
                <br>
                NO : <?= $data[0]['no_nup'] ?>
            </b>
        </div>
        <br>
        <br>
        <br>
        <div>
            Yang bertanda tangan di bawah ini : <br>
            <table style="border-collapse: collapse; border: 0px; margin-left: 10% !Important;">
                <tr>
                    <td width="25%">Nama</td>
                    <td width="5%">:</td>
                    <td><?= $data[0]['nama_lengkap'] ?></td>
                </tr>
                <tr>
                    <td>NIK</td>
                    <td>:</td>
                    <td><?= $data[0]['nik'] ?></td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>:</td>
                    <td><?= $data[0]['alamat'] ?></td>
                </tr>
                <tr>
                    <td>No Telp/Hp</td>
                    <td>:</td>
                    <td><?= $data[0]['no_telp'] ?></td>
                </tr>
            </table>
        </div>
        <br>
        <br>
        <br>
        <div>
            Dengan ini berniat untuk mengambil NUP: <br>
            <table style="border-collapse: collapse; border: 0px; margin-left: 10% !Important;">
                <tr>
                    <td width="25%">Tanggal NUP</td>
                    <td width="5%">:</td>
                    <td><?= $data[0]['created_at'] ?></td>
                </tr>
                <tr>
                    <td>Blok/Kav</td>
                    <td>:</td>
                    <td><?= $data[0]['kode_kavling'] ?></td>
                </tr>
                <tr>
                    <td>Model</td>
                    <td>:</td>
                    <td><?= $data[0]['model_rumah'] ?></td>
                </tr>
                <tr>
                    <td>Tipe</td>
                    <td>:</td>
                    <td><?= $data[0]['tipe_bangunan'] ?></td>
                </tr>
                <tr>
                    <td>Harga Jual</td>
                    <td>:</td>
                    <td><?= rupiah($data[0]['hrg_jual']) ?></td>
                </tr>
                <tr>
                    <td>Keterangan</td>
                    <td>:</td>
                    <td><?= $data[0]['keterangan'] ?></td>
                </tr>
                <tr>
                    <td>Lokasi</td>
                    <td>:</td>
                    <td>Panorama Taman Sari</td>
                </tr>
            </table>
        </div>
        <br>
        <br>
        <br>
        <div>
            Melalui Formulir NUP ini:
            <br>
            <table style="border-collapse: collapse; border: 0px; margin-left: 10% !Important;">
                <tr>
                    <td>1. Konsumen akan dibuatkan Surat Pemesanan Rumah (SPR)</td>
                </tr>
                <tr>
                    <td>2. Konsumen menyetujui sepenuhnya persyaratan SPR Panorama Taman Sari</td>
                </tr>
            </table>
            <br>
            <b>Jika formulir NUP dibatalkan maka biaya Formulir hangus.</b>
        </div>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <table width="100%">
            <tr>
                <td width="30%"><b>(Admin)</b></td>
                <td width="30%"><b>(Marketing)</b></td>
                <td width="30%"><b>(Pembeli)</b></td>
            </tr>
        </table>
        <br>
        <br>
        <br>
        <p>
            <b>
                Note:
                <br>
                * 1 Lembar Fotocopy KTP
                <br>
                * 1 Lembar Fotocopy NPWP
                <br>
                * 1 Lembar Fotocopy BPJS Kesehatan
            </b>
        </p>
    </body>
</html>