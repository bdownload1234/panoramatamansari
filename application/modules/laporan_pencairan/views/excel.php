<?php 
header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=Laporan-Pencairan-".$tgl_awal."-".$tgl_akhir.".xls");  //File name extension was wrong
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);
?>
<h2>Laporan SPR <?=$tgl_awal;?> - <?=$tgl_akhir;?></h2>
<table border="1">
    <tr>
        <th width="5%">No</th>
        <th width="15%">Tanggal</th>
        <th width="30%">Nama Customer</th>
        <th width="10%">Bank</th>
        <th width="10%">Jumlah Pengajuan</th>
        <th width="10%">Jumlah Pencairan</th>
        <th width="10%">Status Pesanan</th>
    </tr>
    <?php 
      $no = 1;
      foreach($data as $dt){
//              if($dt->status == '0'){
// 				    $status = '<span class="badge badge-pill badge-info">SPR</span>';
// 			}else if($dt->status == '11'){
// 				$status = '<span class="badge badge-pill badge-success">Pindah Kavling</span>';
// 			}else if($dt->status == '12'){
// 				$status = '<span class="badge badge-pill badge-warning">Ganti Nama</span>';
// 			}else if($dt->status == '21'){
// 				$status = '<span class="badge badge-pill badge-primary">AKAD</span>';
// 			}else{
// 				$status = '<span class="badge badge-pill badge-secondary">HOLD</span>';
// 			}
            echo '<tr>
            <td>'.$no++.'</td>
            <td>'.$dt->tanggal.'</td>
            <td>'.$dt->nama_lengkap.'</td>
            <td>'.$dt->nama_bank.'</td>
            <td>'.$dt->jumlah_pengajuan.'</td>
            <td>'.$dt->jumlah_pencairan.'</td>
            <td>'.$dt->status.'</td>
            ';
        }
    ?>
</table>