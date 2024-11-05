<?php
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment;filename=\"Data-Cicilan-DP.xls\"");
header("Cache-Control: max-age=0");
?>

<table border="1">
    <thead>
        <tr>
            <th width="5%">No</th>
            <th width="20%">Nama Customer</th>
            <th>Blok Kavling</th>
            <th>Nominal Booking</th>
            <th>Jenis Harga</th>
            <th>Harga Jual</th>
            <th>Harga Acc Bank</th>
            <th>Sisa Kewajiban</th>
            <th>Kekurangan</th>
            <th>Status</th>
            <th>Tanggal DP</th>
            <th>Nilai DP</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($data as $key => $datas){
                // $sisa_kewajiban = ($datas->harga_jual_ajb-$datas->harga_acc_bank);
                $sisa_kewajiban = ($datas->hrg_jual-$datas->harga_acc_bank);
                $kekurangan = ($sisa_kewajiban-$datas->dp_1-$datas->dp_2-$datas->dp_3);
                
                $button = '';
                if($kekurangan <> 0){
                    $button .= '
                    <button type="button" class="btn btn-sm btn-warning btnEdit" data-toggle="modal" data-target="#modalAdd" data-id="'.$datas->id.'">
                        <i class="fa fa-edit"></i> Edit Data
                    </button>
                    ';
                }

                $data = $this->db->query("
                    SELECT * FROM cicilan_dp_dt WHERE cicilan_dp_id = '".$datas->id."'
                ")->result();
                
                echo '
                    <tr>
                    <td>'.($key+1).'</td>
                    <td>'.$datas->nama_lengkap.'</td>
                    <td>'.$datas->kode_kavling.'</td>
                    <td>'.number_format($datas->nominal_booking, 2).'</td>
                    <td>'.($datas->jenis_pembayaran == 1 ? "Kredit" : "Cash").'</td>
                    <td>'.($datas->jenis_pembayaran == 1 ? number_format($datas->hrg_jual, 2) : number_format($datas->harga_jual_ajb, 2)).'</td>
                    <td>'.number_format($datas->harga_acc_bank, 2).'</td>
                    <td>'.number_format((($datas->jenis_pembayaran == 1 ? $datas->hrg_jual : $datas->harga_jual_ajb)-$datas->harga_acc_bank), 2).'</td>
                    <td>'.number_format((($datas->jenis_pembayaran == 1 ? $datas->hrg_jual : $datas->harga_jual_ajb)-$datas->harga_acc_bank)-$datas->total_dp, 2).'</td>
                    <td>'.$datas->status.'</td>
                    <td></td>
                    <td></td>
                    </tr>
                ';

                foreach($data as $key => $datas){
                    echo '
                        <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>'.$datas->tanggal_dp.'</td>
                        <td>'.number_format($datas->nilai_dp, 2).'</td>
                        </tr>
                    ';
                }
            }
        ?>
    </tbody>
</table>