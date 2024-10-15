<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Detail Stok</h1>
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
          <h3 class="card-title">Detail Stok</h3>
          <div class="card-tools">
            <a href="<?=base_url('dashboard_keuangan/download_detail_data/'.$stt);?>" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-plus"></i> Download Data</a>&nbsp;
            </div>
             <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body">

           <table id="table" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="10%">Blok Kavling</th>
                        <th width="10%">Luas Tanah</th>
                        <th width="10%">Type Rumah</th>
                        <th width="10%">Model Rumah</th>
                        <th width="10%">Harga Jual AJB Kredit</th>
                        <th width="10%">Harga Jual AJB Cash</th>
                        <th width="10%">Discount Lainnya</th>
                        <th width="10%">Jenis Pembayaran</th>
                        <th width="10%">Status</th>
                        <th width="25%">Customer</th>
                    </tr>
                </thead>
                <tbody>
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
                        <td>'.rupiah($kav->harga_jual_ajb).'</td>
                        <td>'.rupiah($kav->harga_diskon).'</td>
                        <td>'.($kav->jenis_bayar == '' ? '' : ($kav->jenis_bayar == '1' ? 'KPR' : 'Cash')).'</td>
                        <td align="center">'.$stat.'</td>
                        <td>'.$kav->nama_lengkap.'</td>
                    </tr>';
                }
                ?>
                </tbody>
            </table>

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