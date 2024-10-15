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
        </style>
    </head>
    <body>
        <div style="font-size: 14px; font-family: Arial, Helvetica, sans-serif !important; margin-bottom: 10px">
            <b>PEMBATALAN SPR
            <br>
            PROYEK : PERUMAHAN PANORAMA TAMAN SARI</b>
        </div>
        <table id="table">
            <tbody>
                <tr>
                    <td width="25%">No. SPR</td>
                    <td><?= $data['nomor_spr'] ?></td>
                </tr>
                <tr>
                    <td>Tanggal SPR</td>
                    <td><?= $data['tanggal_spr'] ?></td>
                </tr>
                <tr>
                    <td>Nama Pembeli</td>
                    <td><?= $data['nama_lengkap'] ?></td>
                </tr>
                <tr>
                    <td>Blok / Kav</td>
                    <td><?= $data['kode_kavling'] ?></td>
                </tr>
                <tr>
                    <td>Type</td>
                    <td><?= $data['tipe_bangunan'] ?></td>
                </tr>
                <tr>
                    <td>Model</td>
                    <td><?= $data['model_rumah'] ?></td>
                </tr>
                <tr>
                    <td>Sebab</td>
                    <td><?= $data['keterangan_pembatalan'] ?></td>
                </tr>
                <tr>
                    <td>Biaya ADM</td>
                    <td>1,000,000</td>
                </tr>
                <tr>
                    <td>Keterangan</td>
                    <td>LAIN-LAIN</td>
                </tr>
            </tbody>
        </table>
        <div style="padding: 20px">
            <table style="border-collapse: collapse; border: 0px; width: 100%">
                <tbody>
                    <tr>
                        <td style="text-align: center; padding: 10px;">Konsumen,</td>
                        <td style="text-align: center; padding: 10px;">Admin,</td>
                        <td style="text-align: center; padding: 10px;">Kepala Kantor,</td>
                    </tr>
                    <tr>
                        <td style="height: 50px"></td>
                        <td style="height: 50px"></td>
                        <td style="height: 50px"></td>
                    </tr>
                    <tr>
                        <td width="20%" style="text-align: center; padding: 10px;">(.............................)</td>
                        <td width="20%" style="text-align: center; padding: 10px;">(.............................)</td>
                        <td width="20%" style="text-align: center; padding: 10px;">(.............................)</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </body>
</html>