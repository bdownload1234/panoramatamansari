  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Data Registrasi Customer</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard'); ?>">Home</a></li>
              <li class="breadcrumb-item active">Registrasi Customer</li>
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
          <h3 class="card-title">Registrasi Customer</h3>
        </div>

        <!-- /.card-header -->
        <div class="card-body">

          <table id="table" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="15%">Nama Customer</th>
                    <th width="20%">NIK</th>
                    <th width="15%">Email</th>
                    <th width="15%">No. Telp</th>
                    <th width="10%">Lokasi</th>
                    <th width="10%">Status</th>
                    <th width="10%">Action</th>
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






<div class="modal fade" id="modal-lg">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Extra Large Modal</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">


        <form action="#" id="form" class="form-horizontal">
          <input type="hidden" value="" name="id" id="id"/>

          <div class="form-group row">
            <label class="col-sm-2 control-label">Nama Customer </label>
            <div class="col-md-5">
              <input name="nama" type="text" class="form-control" id="nama">
              <span class="help-block"></span>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-2 control-label">Email</label>
            <div class="col-md-5">
              <input name="email" type="text" class="form-control" id="email">
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-2 control-label">Nomor WA</label>
            <div class="col-md-5">
              <input name="no_wa" type="text" class="form-control" id="no_wa">
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-2 control-label">Alamat</label>
            <div class="col-md-8">
              <textarea name="alamat" class="form-control"></textarea>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-2 control-label">Username</label>
            <div class="col-md-5">
              <input name="username" type="text" class="form-control" id="username" autocomplete="OFF">
              <input name="password" type="hidden" class="form-control" id="password">
              <span class="help-block"></span>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-2 control-label">Password</label>
            <div class="col-md-5">
              <input name="password" type="text" class="form-control" id="password" autocomplete="OFF">
              <input name="password" type="hidden" class="form-control" id="password">
              <span class="help-block"></span>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-2 control-label">Verifikasi</label>
            <div class="col-md-5">
              <select name="verifikasi" id="verifikasi"  class="form-control">
                <option value="0">Pending</option>
                <option value="1">Setujui</option>
              </select>
              <span class="help-block"></span>
            </div>
          </div>

                                                  
          </form>

      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Simpan</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->




<?php  $this->load->view('template/footer'); ?>






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
          "columnDefs": [
          {
              "targets": [ -1 ], //last column
              "orderable": false, //set not orderable
          },
          ],

      });

      //datepicker
      $('.datepicker').datepicker({
          autoclose: true,
          format: "yyyy-mm-dd",
          todayHighlight: true,
          orientation: "top auto",
          todayBtn: true,
          todayHighlight: true,  
      });
      //set input/textarea/select event when change value, remove class error and remove text help block
      $("input").change(function(){
          $(this).parent().parent().removeClass('has-error');
          $(this).next().empty();
      });
      $("textarea").change(function(){
          $(this).parent().parent().removeClass('has-error');
          $(this).next().empty();
      });
      $("select").change(function(){
          $(this).parent().parent().removeClass('has-error');
          $(this).next().empty();
      });

  });

   function add()
   {
      
      // alert("asd");
       save_method = 'add';
       $('#form')[0].reset(); // reset form on modals
       $('.form-group').removeClass('has-error'); // clear error class
       $('.help-block').empty(); // clear error string
       $('#modal-lg').modal('show'); // show bootstrap modal
       $('.modal-title').text('Tambah Agen'); // Set Title to Bootstrap modal title
   }

   function edit(id)
   {
       save_method = 'update';
       $('#form')[0].reset(); // reset form on modals
       $('.form-group').removeClass('has-error'); // clear error class
       $('.help-block').empty(); // clear error string
    
       //Ajax Load data from ajax
       $.ajax({
           url : "<?php echo site_url($data_ref['uri_controllers'].'/ajax_edit/')?>/" + id,
           type: "GET",
           dataType: "JSON",
           success: function(data)
           {
               $('[name="id"]').val(data.id_registrasi);
               $('[name="nama"]').val(data.nama_lengkap);
               $('[name="email"]').val(data.email);
               $('[name="no_wa"]').val(data.no_telp);
               $('[name="alamat"]').val(data.alamat);
               $('[name="verifikasi"]').val(data.status_registrasi);
               $('#modal-lg').modal('show'); // show bootstrap modal when complete loaded
               $('.modal-title').text('Verifikasi Registrasi'); // Set title to Bootstrap modal title
               
               $('#btnSave').text('Simpan'); //change button text
               $('#btnSave').attr('disabled',false); //set button enable 
    
           },
           error: function (jqXHR, textStatus, errorThrown)
           {
               alert('Error get data from ajax');
           }
       });
   }

   function reload_table()
   {
      table.ajax.reload(null,false); //reload datatable ajax
   }

   function save()
   {
       $('#btnSave').text('Menyimpan...'); //change button text
       $('#btnSave').attr('disabled',true); //set button disable 
       var url;
    
       if(save_method == 'add') {
           url = "<?php echo site_url($data_ref['uri_controllers'].'/ajax_add')?>";
       } else {
           url = "<?php echo site_url($data_ref['uri_controllers'].'/ajax_update')?>";
       }
    
       // ajax adding data to database
       $.ajax({
           url : url,
           type: "POST",
           data: $('#form').serialize(),
           dataType: "JSON",
           success: function(data)
           {
    
               if(data.status) //if success close modal and reload ajax table
               {
                   $('#modal-lg').modal('hide');
                   reload_table();
                   Lobibox.notify('success', {
                       size: 'mini',
                       msg: 'Data berhasil Disimpan'
                   });
               }
               else
               {
                   for (var i = 0; i < data.inputerror.length; i++) 
                   {
                       $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                       $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                   }
               }
               $('#btnSave').text('Simpan'); //change button text
               $('#btnSave').attr('disabled',false); //set button enable 
    
    
           },
           error: function (jqXHR, textStatus, errorThrown)
           {
               alert('Error adding / update data');
               $('#btnSave').text('Simpan'); //change button text
               $('#btnSave').attr('disabled',false); //set button enable 
    
           }
       });
   }

   function hapus(id){
    $.confirm({
      title: 'Confirm!',
      content: 'Apakah anda yakin menghapus data ini ?',
      buttons: {
        confirm: function () {
           $.ajax({
              url : url + "<?php echo $data_ref['uri_controllers']; ?>/ajax_delete/" + id,
              type: "POST",
              dataType: "JSON",
              success: function(data)
              {
                  //if success reload ajax table
                  reload_table();
                  Lobibox.notify('success', {
                       size: 'mini',
                       msg: 'Data berhasil Dihapus'
                   });
              },
              error: function (jqXHR, textStatus, errorThrown)
              {
                  alert('Error deleting data');
              }
          });
        },
        cancel: function () {
          
        }
      }
    });
  }

</script>





