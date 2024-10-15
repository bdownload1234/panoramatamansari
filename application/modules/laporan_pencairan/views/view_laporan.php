  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Report Data Pencairan</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard'); ?>">Home</a></li>
              <li class="breadcrumb-item active">Report</li>
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
          <h3 class="card-title">Periode : <b><?=tgl_indo($tgl_awal);?></b> sampai <b><?=tgl_indo($tgl_akhir);?></b> </h3>
            <div class="card-tools">
              <a href="/laporan_pencairan/excel?tgl_awal=<?=$tgl_awal;?>&tgl_akhir=<?=$tgl_akhir;?>" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-plus"></i> Import Data ke Excel</a>&nbsp;
            </div>
        </div>

        <!-- /.card-header -->
        <div class="card-body">

           <table id="table" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="15%">Tanggal</th>
                        <th width="30%">Nama Customer</th>
                        <th width="10%">Bank</th>
                        <th width="10%">Jumlah Pengajuan</th>
                        <th width="10%">Jumlah Pencairan</th>
                        <th width="10%">Status Pesanan</th>
                    </tr>
                </thead>
                <tbody>
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
<script>
    $('#table').DataTable();
</script>

