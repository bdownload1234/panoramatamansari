<?php 
header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=Laporan-SPR-".$tgl_awal."-".$tgl_akhir.".xls");  //File name extension was wrong
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);
?>
<h2>Laporan SPR <?=$tgl_awal;?> - <?=$tgl_akhir;?></h2>
<table border="1">
    <tr>
        <th width="5%">No</th>
        <th width="12%">Tanggal SPR</th>
        <th width="17%">Nomor SPR</th>
        <th width="23%">Nama Customer</th>
        <th width="12%">Lokasi Rumah</th>
        <th width="12%">Nomor VA</th>
        <th width="12%">Status Pesanan</th>
    </tr>
    <?php 
      $no = 1;
      foreach($data as $dt){
        if($dt->status_spr == '0'){
    		$status_spr = 'SPR';
    	}else if($dt->status_spr == '11'){
    		$status_spr = 'Pindah Kavling';
    	}else if($dt->status_spr == '12'){
    		$status_spr = 'Ganti Nama';
    	}else if($dt->status_spr == '21'){
    		$status_spr = 'AKAD';
    	}else{
    		$status_spr = 'HOLD';
    	}
        echo '<tr>
        <td>'.$no++.'</td>
        <td>'.$dt->tanggal_spr.'</td>
        <td>'.$dt->nomor_spr.'</td>
        <td>'.$dt->nama_lengkap.'</td>
        <td>'.$dt->kode_kavling.'</td>
        <td>'.$dt->nomor_va.'</td>
        <td>'.$status_spr.'</td>
        ';
      }
    ?>
</table>