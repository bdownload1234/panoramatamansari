<?php
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment;filename=\"Stok Penjualan.xls\"");
header("Cache-Control: max-age=0");

?>

<table border="1">
        <tr>
            <th width="auto">No</th>
            <?php
                if(in_array($stt, ['ganti_nama', 'pindah_kavling'])){
                    $html = '<th width="auto">No SPR Lama</th>
                            <th width="auto">Tanggal SPR Lama</th>
                            <th width="auto">No SPR Baru</th>
                            <th width="auto">Tanggal SPR Baru</th>';
                    if($stt == 'ganti_nama'){
                        $html .= '<th width="auto">Nama Customer Lama</th>
                                <th width="auto">Nama Customer baru</th>
                                <th width="auto">Blok Kavling</th>';
                    }
                    if($stt == 'pindah_kavling'){
                        $html .= '<th width="auto">Customer</th>
                            <th width="auto">Blok Kavling Lama</th>
                            <th width="auto">Blok Kavling Baru</th>';
                    }
                    echo $html;
                }else{
                    echo '<th width="auto">No SPR</th>
                        <th width="auto">Tanggal SPR</th>
                        <th width="auto">Customer</th>
                        <th width="auto">Blok Kavling</th>';
                }
            ?>
            <th width="auto">Luas Tanah</th>
            <th width="auto">Type Rumah</th>
            <th width="auto">Model Rumah</th>
            <th width="auto">Maksimal Kredit KPR</th>
            <th width="auto">Harga Jual AJB Cash</th>
            <th width="auto">Discount Lainnya</th>
            <th width="auto">Jenis Pembayaran</th>
            <th width="auto">Status</th>
            <?php 
                if(in_array($stt, ['batal', 'pindah_kavling', 'ganti_nama'])) echo '<th width="10%">Keterangan</th>';
            ?>
        </tr>

        <?php 
            $no = 1;
            $ket = '';
            $row = '';
            if(in_array($stt, ['ganti_nama', 'pindah_kavling'])){
                foreach($data as $kav){
                    $a = '';
                    $b = '';
        			$histori = $this->db->query("SELECT * FROM spr WHERE id_customer ='$kav->id_customer'")->result();
        			foreach($histori as $hs){
        			    if($kav->nomor_spr <> $hs->nomor_spr){
            				$a .= $hs->nomor_spr.'<br>';
            				$b .= $hs->tanggal_spr.'<br>';
        			    }
        			}
        			
        			$c = '';
        			if($stt == 'ganti_nama'){
        			    $history = $this->db->query("Select a.*, b.catatan_nama From customer_diganti a
        			        left join ganti_nama b ON a.id_customer = b.id_customer
        			        Where a.id_customer = '$kav->id_customer'")->result();
        			    foreach($history as $hs){
        			        $c .= $hs->nama_lengkap.'<br>';
        			        $ket = '<td>'.$hs->catatan_nama.'</td>';
        			    }
        			    $row = '
        			        <td>'.$c.'</td>
        			        <td>'.$kav->nama_lengkap.'</td>
        			        <td>'.$kav->lokasi_kavling.'</td>
        			    ';
        			}
        			
        			$d = '';
        			$e = '';
        			$f = '';
        			if($stt == 'pindah_kavling'){
        			    $history = $this->db->query("Select a.*, b.kode_kavling as kav_lama, c.kode_kavling as kav_baru, d.nama_lengkap From pindah_kavling a 
        			        Left join kavling_peta b ON a.lokasi_lama = b.id_kavling
        			        Left join kavling_peta c ON a.lokasi_baru = c.id_kavling
        			        left join customer d on a.id_customer = d.id_customer
        			        Where a.id_customer = '$kav->id_customer'")->result();
        			    foreach($history as $hs){
        			        $d .= $hs->nama_lengkap.'<br>';
        			        $e .= $hs->kav_lama.'<br>';
        			        $f .= $hs->kav_baru.'<br>';
        			        $ket = '<td>'.$hs->catatan_pindah.'</td>';
        			    }
        			    $row .= '
            			    <td>'.$d.'</td>
            			    <td>'.$e.'</td>
            			    <td>'.$f.'</td>
        			    ';
        			}
        			
                    if($kav->status_spr == '0'){
        				$stat = '<span class="btn btn-primary btn-xs">SPR</span>';
        			}else if($kav->status_spr == '12'){
        				$stat = '<span class="btn btn-warning btn-xs">PINDAH KAVLING</span>';
        			}else if($kav->status_spr == '14'){
        				$stat = '<span class="btn btn-secondary btn-xs">GANTI NAMA</span>';
        			}else if($kav->status_spr == '13'){
        				$stat = '<span class="btn btn-danger btn-xs">BATAL</span>';
        				
        				$ket = '<td>'.$kav->keterangan_pembatalan.'</td>';
        			}
			
                    echo '<tr id="'.$no.'">
                        <td>'.$no++.'</td>
                        <td>'.$a.'</td>
                        <td>'.$b.'</td>
                        <td>'.$kav->nomor_spr.'</td>
                        <td>'.$kav->tanggal_spr.'</td>
                        '.$row.'
                        <td>'.$kav->luas_tanah.' meter'.'</td>
                        <td>'.$kav->tipe_bangunan.'</td>
                        <td>'.$kav->model_rumah.'</td>
                        <td>'.rupiah($kav->hrg_jual).'</td>
                        <td>'.rupiah($kav->harga_jual_ajb).'</td>
                        <td>'.rupiah($kav->harga_diskon).'</td>
                        <td>'.($kav->jenis_bayar == '' ? '' : ($kav->jenis_bayar == '1' ? 'KPR' : 'Cash')).'</td>
                        <td align="center">'.$stat.'</td>
                        '.$ket.'
                    </tr>';
                }
            }else{
                foreach($data as $kav){
                if($kav->status_spr == '0'){
    				$stat = '<span class="btn btn-primary btn-xs">SPR</span>';
    			}else if($kav->status_spr == '12'){
    				$stat = '<span class="btn btn-warning btn-xs">PINDAH KAVLING</span>';
    			}else if($kav->status_spr == '14'){
    				$stat = '<span class="btn btn-secondary btn-xs">GANTI NAMA</span>';
    			}else if($kav->status_spr == '13'){
    				$stat = '<span class="btn btn-danger btn-xs">BATAL</span>';
    				
    				$ket = '<td>'.$kav->keterangan_pembatalan.'</td>';
    			}
		
                echo '<tr id="'.$no.'">
                    <td>'.$no++.'</td>
                    <td>'.$kav->nomor_spr.'</td>
                    <td>'.$kav->tanggal_spr.'</td>
                    <td>'.$kav->nama_lengkap.'</td>
                    <td>'.$kav->kode_kavling.'</td>
                    <td>'.$kav->luas_tanah.' meter'.'</td>
                    <td>'.$kav->tipe_bangunan.'</td>
                    <td>'.$kav->model_rumah.'</td>
                    <td>'.rupiah($kav->hrg_jual).'</td>
                    <td>'.rupiah($kav->harga_jual_ajb).'</td>
                    <td>'.rupiah($kav->harga_diskon).'</td>
                    <td>'.($kav->jenis_bayar == '' ? '' : ($kav->jenis_bayar == '1' ? 'KPR' : 'Cash')).'</td>
                    <td align="center">'.$stat.'</td>
                    '.$ket.'
                </tr>';
            }
            }
        ?>

</table>
