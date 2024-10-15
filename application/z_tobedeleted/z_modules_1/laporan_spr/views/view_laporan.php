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
          <h3 class="card-title">Report SPR</h3>
        </div>

        <!-- /.card-header -->
        <div class="card-body">

           <table id="table" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="15%">Nomor SPR</th>
                        <th width="30%">Nama Customer</th>
                        <th width="10%">Lokasi Rumah</th>
                        <th width="10%">Nomor VA</th>
                        <th width="10%">Status Pesanan</th>
                        <th width="15%">Action</th>
                    </tr>
                </thead>
                <tbody>

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
