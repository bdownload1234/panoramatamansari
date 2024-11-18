<?php
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment;filename=\"Kavling.xls\"");
header("Cache-Control: max-age=0");

?>

<table border="1">
        <tr>
            <th>No</th>
            <th>Kode Kavling</th>
            <th>Luas Tanah</th>
            <th>Tipe Rumah</th>
            <th>Model Rumah</th>
            <?php 
                $query_user = $this->db->query("SELECT * FROM users WHERE id = ".$this->session->userdata('raw_id'));
                $query_user = $query_user->row();
                
                if(strtoupper($query_user->jabatan) == 'PIC PUSAT' || strtoupper($query_user->jabatan) == 'DIREKTUR' || strtoupper($query_user->jabatan) == 'DIREKTUR UTAMA'){
                    echo '<th>Maksimal Kredit KPR</th><th>Harga Jual AJB Cash</th><th width="10%">Harga Diskon</th>';
                }else if(strtoupper($query_user->jabatan) == 'ADMIN'){
                    echo '<th width="10%">Harga Diskon</th>';
                }else{
                    echo '';
                }
            ?>
            <th>Nama Cuntomer</th>
            <th>Nama Marketing</th>
            <th>Status Kavling</th>
            <th>Keterangan</th>
        </tr>

        <?php 
        $no =1;
        foreach ($downData as $dt) {
            if(strtoupper($query_user->jabatan) == 'PIC PUSAT' || strtoupper($query_user->jabatan) == 'DIREKTUR' || strtoupper($query_user->jabatan) == 'DIREKTUR UTAMA'){
                $row = '<td>'.rupiah($dt->hrg_jual).'</td><td>'.rupiah($dt->harga_jual_ajb).'</td><td align="right">'.rupiah($dt->harga_diskon).'</td>';
            }else if(strtoupper($query_user->jabatan) == 'ADMIN'){
                $row = '<td>'.rupiah($dt->harga_diskon).'</td>';
            }else{
                $row = '';
            }
            
            
            if($dt->stt_kavling == '0'){
				$stat = 'HOLD';
			}elseif($dt->stt_kavling == '1'){
				$stat = 'AVAILABLE';
			}elseif($dt->stt_kavling == '2'){
				$stat = 'NUP';
			}elseif($dt->stt_kavling == '3'){
				$stat = 'TERBOOKING';
			}elseif($dt->stt_kavling == '4'){
				$stat = 'SUDAH AKAD';
			}elseif($dt->stt_kavling == '5'){
				$stat = 'STANDART';
			}elseif($dt->stt_kavling == '6'){
				$stat = 'KHUSUS';
			}else{
				$stat = '';
			}
			
            echo '<tr>
            <td>'.$no++.'</td>
            <td>'.$dt->kode_kavling.'</td>
            <td>'.$dt->luas_tanah.'</td>
            <td>'.$dt->tipe_bangunan.'</td>
            <td>'.$dt->model_rumah.'</td>
            '.$row.'
            <td>'.$dt->nama_lengkap.'</td>
            <td>'.$dt->nama_marketing.'</td>
            <td>'.$stat.'</td>
            <td>'.$dt->keterangan.'</td>
        </tr>';
        }
        ?>

</table>
