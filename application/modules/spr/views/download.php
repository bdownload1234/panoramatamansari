<?php
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment;filename=\"Data Penjualan SPR.xls\"");
header("Cache-Control: max-age=0");
?>

<table border="1">
    <tr>
        <th width="5%">No</th>
        <th width="15%">Nomor SPR</th>
        <th width="30%">Nama Customer</th>
        <th width="10%">Lokasi Rumah</th>
        <th width="10%">Nomor VA</th>
        <th width="10%">Status Pesanan</th>
    </tr>
    <?php
        $no = 1;
        foreach($data as $data){
            if($data->status_spr == '0'){
    			$stt = 'SPR';
    		}else if($data->status_spr == '11'){
    			$stt = 'Pindah Kavling';
    		}else if($data->status_spr == '12'){
    			$stt = 'Ganti Nama';
    		}else if($data->status_spr == '21'){
    			$stt = 'AKAD';
    		}else{
    			$stt = 'HOLD';
    		}
            echo '
                <tr>
                    <td>'.$no++.'</td>
                    <td>'.$data->nomor_spr.'</td>
                    <td>'.$data->nama_lengkap.'</td>
                    <td>'.$data->kode_kavling.'</td>
                    <td>'.$data->nomor_va.'</td>
                    <td>'.$stt.'</td>
                </tr>
            ';
        }
    
    ?>
</table>