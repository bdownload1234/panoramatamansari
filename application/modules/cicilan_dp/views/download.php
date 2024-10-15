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
                            <th>Harga Jual AJB Kredit</th>
                            <th>Harga Acc Bank</th>
                            <th>Sisa Kewajiban</th>
                            <th>Tanggal DP 1</th>
                            <th>DP 1</th>
                            <th>Tanggal DP 2</th>
                            <th>DP 2</th>
                            <th>Tanggal DP 3</th>
                            <th>DP 3</th>
                            <th>Kekurangan</th>
                            <th>Status</th>
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
                                
                                echo '
                                    <tr>
                                    <td>'.($key+1).'</td>
                                    <td>'.$datas->nama_lengkap.'</td>
                                    <td>'.$datas->kode_kavling.'</td>
                                    <td>'.number_format($datas->nominal_booking, 2).'</td>
                                    <td>'.number_format($datas->hrg_jual, 2).'</td>
                                    <td>'.number_format($datas->harga_acc_bank, 2).'</td>
                                    <td>'.number_format(($datas->hrg_jual-$datas->harga_acc_bank), 2).'</td>
                                    <td>'.$datas->tanggal_dp_1.'</td>
                                    <td>'.number_format($datas->dp_1, 2).'</td>
                                    <td>'.$datas->tanggal_dp_2.'</td>
                                    <td>'.number_format($datas->dp_2, 2).'</td>
                                    <td>'.$datas->tanggal_dp_3.'</td>
                                    <td>'.number_format($datas->dp_3, 2).'</td>
                                    <td>'.number_format($kekurangan, 2).'</td>
                                    <td>'.$datas->status.'</td>
                                    </tr>
                                ';
                            }
                        ?>
                    </tbody>
                </table>