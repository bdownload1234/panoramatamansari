<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Detail Penjualan</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard'); ?>">Home</a></li>
              <li class="breadcrumb-item active">Stok</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->




    <!-- Main content -->
    <section class="content">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Detail Penjualan </h3>
          <div class="card-tools">
            <a href="<?=base_url('dashboard_keuangan/download_detail_penjualan/'.$stt);?>" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-plus"></i> Download Data</a>&nbsp;
            </div>
             <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="table-responsive">
                <table id="table" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <?php
                            if(in_array($stt, ['ganti_nama', 'pindah_kavling'])){
                                $html = '<th width="10%">No SPR Lama</th>
                                        <th width="10%">Tanggal SPR Lama</th>
                                        <th width="10%">No SPR Baru</th>
                                        <th width="10%">Tanggal SPR Baru</th>';
                                if($stt == 'ganti_nama'){
                                    $html .= '<th width="10%">Nama Customer Lama</th>
                                            <th width="10%">Nama Customer baru</th>
                                            <th width="">Blok Kavling</th>';
                                }
                                if($stt == 'pindah_kavling'){
                                    $html .= '<th width="25%">Customer</th>
                                        <th width="">Blok Kavling Lama</th>
                                        <th width="">Blok Kavling Baru</th>';
                                }
                                echo $html;
                            }else{
                                echo '<th width="10%">No SPR</th>
                                    <th width="10%">Tanggal SPR</th>
                                    <th width="25%">Customer</th>
                                    <th width="">Blok Kavling</th>';
                            }
                        ?>
                        <th width="">Luas Tanah</th>
                        <th width="">Type Rumah</th>
                        <th width="">Model Rumah</th>
                        <th width="10%">Maksimal Kredit KPR</th>
                        <th width="10%">Harga Jual AJB Cash</th>
                        <th width="10%">Discount Lainnya</th>
                        <th width="">Jenis Pembayaran</th>
                        <th width="">Status</th>
                        <?php 
                            if(in_array($stt, ['batal', 'pindah_kavling', 'ganti_nama'])) echo '<th width="10%">Keterangan</th>';
                        ?>
                    </tr>
                </thead>
                <tbody>
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
                </tbody>
            </table>
            </div>
          </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
</div>
</body>
</html>

<?php  $this->load->view('template/footer'); ?>
<script type="text/javascript">


  var url = "<?php echo site_url(); ?>";
  
  
  $(document).ready(function() {

      //datatables
      table = $('#table').DataTable({
          "paging": false,
      });
   });
</script>