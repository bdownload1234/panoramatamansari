<?php
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment;filename=\"Stok Data.xls\"");
header("Cache-Control: max-age=0");

?>

<table border="1">
        <tr>
            <th width="5%">No</th>
            <th width="10%">Blok Kavling</th>
            <th width="10%">Luas Tanah</th>
            <th width="10%">Type Rumah</th>
            <th width="10%">Model Rumah</th>
            <th width="10%">Harga Jual</th>
            <th width="10%">Status</th>
            <th width="25%">Customer</th>
        </tr>

        <?php 
        $no = 1;
        foreach($data as $kav){
            if($kav->stt_kavling == '0'){
				$stat = '<span class="btn btn-danger btn-xs">HOLD</span>';
			}elseif($kav->stt_kavling == '1'){
				$stat = '<span class="btn btn-xs" style="background-color: #00a123; color: #fff">AVAILABLE</span>';
			}elseif($kav->stt_kavling == '2'){
				$stat = '<span class="btn btn-xs" style="background-color: #FFF987; color: #000">NUP</span>';
			}elseif($kav->stt_kavling == '3'){
				$stat = '<span class="btn btn-xs" style="background-color: #F5BC4C; color: #000">TERBOOKING</span>';
			}elseif($kav->stt_kavling == '4'){
				$stat = '<span class="btn btn-xs" style="background-color: #418bf2; color: #000">SUDAH AKAD</span>';
			}
// 			elseif($kav->stt_kavling == '5'){
// 				$stat = '<span class="btn btn-warning btn-xs">STANDART</span>';
// 			}elseif($kav->stt_kavling == '6'){
// 				$stat = '<span class="btn btn-secondary btn-xs">KHUSUS</span>';
// 			}
			else{
				$stat = '<span class="btn btn-xs bg-primary">SUDAH AKAD</span>';
			}
	
            echo '<tr id="'.$no.'">
                <td>'.$no++.'</td>
                <td>'.$kav->kode_kavling.'</td>
                <td>'.$kav->luas_tanah.' meter'.'</td>
                <td>'.$kav->tipe_bangunan.'</td>
                <td>'.$kav->model_rumah.'</td>
                <td>'.rupiah($kav->hrg_jual).'</td>
                <td align="center">'.$stat.'</td>
                <td>'.$kav->nama_lengkap.'</td>
            </tr>';
        }
        ?>

</table>
