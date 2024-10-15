  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Laporan SPR</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard'); ?>">Home</a></li>
              <li class="breadcrumb-item active">Laporan</li>
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
          <h3 class="card-title">Form Laporan</h3>
        </div>

        <!-- /.card-header -->
        <div class="card-body">

        <form action="<?=base_url('laporan_spr/proses');?>" method="POST" id="form" class="form-horizontal">

                    <div class="form-body">


                        <div class="form-group row">
                            <label class="control-label col-md-3">Tanggal Awal</label>
                            <div class="col-md-3">
                                <input name="tanggal_awal" id="tanggal_awal" class="form-control" type="date" value="">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Tanggal Akhir</label>
                            <div class="col-md-3">
                                <input name="tanggal_akhir" id="tanggal_akhir" class="form-control" type="date" value="">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3"></label>
                            <div class="col-md-3">
                                <button name="submit" id="tanggal_akhir" class="btn btn-primary" type="submit">Proses</button>
                            </div>
                        </div>



                    </div>
                </form>
           

          </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
</div>


</body>
</html>





<?php  $this->load->view('template/footer'); ?>
