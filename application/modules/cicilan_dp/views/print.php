<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kwitansi DP</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #fff;
        }

        .container {
            width: 100%;
            padding: 20px;
            border: 1px solid #000;
        }

        header {
            margin-bottom: 20px;
        }

        header h1 {
            font-size: 18px;
            margin-bottom: 5px;
        }

        header p {
            font-size: 12px;
        }

        header h2 {
            margin-top: 10px;
            font-size: 16px;
            text-decoration: underline;
        }

        .details {
            margin-bottom: 20px;
        }

        .details p {
            font-size: 14px;
            margin-bottom: 5px;
        }

        .booking-info table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            border: 1px solid #000; /* Outer border */
        }

        .booking-info th {
            border: none; /* Outer border */
            border-bottom: 1px solid #000; /* Inner border */
            text-align: center;
            font-size: 13px;
            font-weight: bold;
        }
        
        .booking-info td {
            border: none; /* No border for inner cells */
            /* border bottom double line */
            border-bottom: 5px double #000;
            padding: 2px;
            text-align: center;
        }

        footer {
            margin-top: 20px;
        }

        footer p {
            font-size: 14px;
            margin-bottom: 10px;
        }

        .signatures {
            width: 100%;
            margin-top: 50px;
            margin-bottom: 50px;
        }

        .signatures table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .signatures td {
            text-align: center;
            border-bottom: none;
            height: 60px;
            vertical-align: bottom;
        }

        .signature-line {
            border-bottom: none;
            width: 100%;
            display: inline-block;
            margin-top: 80px; /* Space between title and line */
        }

        .title-invoice {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            margin-bottom: 20px;
            border-bottom: 5px double #000;
        }

        .title-invoice th {
            text-align: left;
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .details-table th.underline {
            text-align: left;
            border-top: 5px double #000;
            border-bottom: 5px double #000;
        }

    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>PT. PRIMA TOSSA PERKASA</h1>
            <p>Jl. Meruya Ilir No 2-2A Jakarta Barat</p>
            <p>021-5870816 / 021-5842222</p>
            <table class="title-invoice">
                <tr>
                    <th>TANDA BUKTI PENERIMAAN BUKTI TRANSFER</th>
                </tr>
            </table>
        </header>

        <section class="details">
            <h4><strong>Nama Konsumen:</strong> <?= $header[0]->nama_lengkap ?></h4>
            <table class="details-table">
                <tr>
                    <th class="underline" width="20%">Rp. <?= rupiah($detail[0]->nilai_dp) ?></th>
                    <th style="text-align: left;" width="80%">Terbilang : <?= ucwords(terbilang($detail[0]->nilai_dp)) ?> Rupiah</th>
                </tr>
            </table>
        </section>

        <section class="booking-info">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No. CICILAN DP</th>
                        <th>Perumahaan</th>
                        <th>Blok / Kavling</th>
                        <th>Tgl. Transfer</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td><?= $formatted_number ?></td>
                        <td>PTS</td>
                        <td><?= $header[0]->kode_kavling ?></td>
                        <td><?= $detail[0]->tanggal_dp ?></td>
                        <td>Rp <?= rupiah($detail[0]->nilai_dp) ?></td>
                    </tr>
                </tbody>
            </table>
        </section>

        <footer>
            <table class="details-table">
                <tr>
                    <th width="70%"></th>
                    <th width="30%">Total : Rp <?= rupiah($detail[0]->nilai_dp) ?></th>
                </tr>
            </table>
            <div class="signatures">
                <table>
                    <tr>
                        <td>PEMBELI / KONSUMEN<br><span class="signature-line">(..............................)</span></td>
                        <td>AGENT / MARKETING<br><span class="signature-line">(..............................)</span></td>
                        <td>ADMIN<br><span class="signature-line">(..............................)</span></td>
                        <td>HEAD OFFICE<br><span class="signature-line">(..............................)</span></td>
                    </tr>
                </table>
            </div>
            <p>Note: Cek ulang Bagian Keuangan</p>
        </footer>
    </div>
</body>
</html>