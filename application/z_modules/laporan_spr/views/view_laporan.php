  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Report Data SPR</h1>
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
        </div>

        <!-- /.card-header -->
        <div class="card-body">

           <table id="table" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="12%">Tanggal SPR</th>
                        <th width="17%">Nomor SPR</th>
                        <th width="23%">Nama Customer</th>
                        <th width="12%">Lokasi Rumah</th>
                        <th width="12%">Nomor VA</th>
                        <th width="12%">Status Pesanan</th>
                    </tr>
                </thead>
                <tbody>
                  <?php 
                  $no = 1;
                  foreach($data as $dt){
                    echo '<tr>
                    <td>'.$no++.'</td>
                    <td>'.$dt->tanggal_spr.'</td>
                    <td>'.$dt->nomor_spr.'</td>
                    <td>'.$dt->nama_lengkap.'</td>
                    <td>'.$dt->kode_kavling.'</td>
                    <td>'.$dt->nomor_va.'</td>
                    <td>'.$dt->status_spr.'</td>
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
