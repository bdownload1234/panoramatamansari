<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark"><a class="btn" id="btn-custom">Rekap Data Pembelian</a></h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard'); ?>">Home</a></li>
            <li class="breadcrumb-item active">Rekap Pembelian</li>
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
        <h3 class="card-title"></h3>
        <div class="card-tools">
          <a href="<?= base_url('denahtrx'); ?>" class="btn btn-sm" style="background-color: #cca353;"><i class="fa fa-plus"></i> Tambah Transaksi</a>&nbsp;
          <button class="btn btn-default btn-sm" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
        </div>
        <!-- /.card-tools -->
      </div>

      <!-- /.card-header -->
      <div class="card-body">
        <div class="table-responsive">

          <table id="table" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th class="text-center" width="5%">No</th>
                <th class="text-center" width="25%">Nama Customer</th>
                <th class="text-center" width="15%">Nomor Tlp</th>
                <th class="text-center" width="15%">Kode Kavling</th>
                <th class="text-center" width="15%">Jenis Pembelian</th>
                <th class="text-center" width="15%">SPR</th>
                <th class="text-center" width="10%">Action</th>
              </tr>
            </thead>
            <tbody>
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





<?php $this->load->view('template/footer'); ?>


<script type="text/javascript">
  var save_method; //for save method string
  var table;
  var url = "<?php echo site_url(); ?>";

  $(document).ready(function() {

    //datatables
    table = $('#table').DataTable({

      "processing": true, //Feature control the processing indicator.
      "serverSide": true, //Feature control DataTables' server-side processing mode.
      "order": [], //Initial no order.

      // Load data for the table's content from an Ajax source
      "ajax": {
        "url": url + "<?php echo $data_ref['uri_controllers']; ?>/ajax_list",
        "type": "POST"
      },

      //Set column definition initialisation properties.
      "columnDefs": [{
        "targets": [-1], //last column
        "orderable": false, //set not orderable
      }, ],

    });


    //set input/textarea/select event when change value, remove class error and remove text help block
    $("input").change(function() {
      $(this).parent().parent().removeClass('has-error');
      $(this).next().empty();
    });
    $("textarea").change(function() {
      $(this).parent().parent().removeClass('has-error');
      $(this).next().empty();
    });
    $("select").change(function() {
      $(this).parent().parent().removeClass('has-error');
      $(this).next().empty();
    });

  });




  function reload_table() {
    table.ajax.reload(null, false); //reload datatable ajax
  }

  function hapus(id) {
    $.confirm({
      title: 'Confirm!',
      content: 'Apakah anda yakin menghapus data ini ?',
      buttons: {
        confirm: function() {
          $.ajax({
            url: url + "<?php echo $data_ref['uri_controllers']; ?>/ajax_delete/" + id,
            type: "POST",
            dataType: "JSON",
            success: function(data) {
              //if success reload ajax table
              reload_table();
              Lobibox.notify('success', {
                size: 'mini',
                msg: 'Data berhasil Dihapus'
              });
            },
            error: function(jqXHR, textStatus, errorThrown) {
              alert('Error deleting data');
            }
          });
        },
        cancel: function() {

        }
      }
    });
  }
</script>