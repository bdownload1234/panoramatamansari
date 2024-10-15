  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
          <div class="container-fluid">
              <div class="row mb-2">
                  <div class="col-sm-6">
                      <h1 class="m-0 text-dark">Data Notaris</h1>
                  </div><!-- /.col -->
                  <div class="col-sm-6">
                      <ol class="breadcrumb float-sm-right">
                          <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard'); ?>">Home</a></li>
                          <li class="breadcrumb-item active">Data </li>
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
                  <h3 class="card-title">Data </h3>
                  <div class="card-tools">
                      <a href="#" class="btn btn-info btn-sm" onclick="add()"><i class="fa fa-plus"></i> Tambah
                          Data Notaris
                      </a>&nbsp;
                      <button class="btn btn-default btn-sm" onclick="reload_table()"><i
                              class="glyphicon glyphicon-refresh"></i> Reload</button>
                  </div>
                  <!-- /.card-tools -->
              </div>

              <!-- /.card-header -->
              <div class="card-body">

                  <table id="table" class="table table-striped table-hover table-bordered" cellspacing="0"
                      width="100%">
                      <thead>
                          <tr>
                              <th width="5%">No</th>
                              <th width="10%">KODE NOTARIS</th>
                              <th width="25%">NAMA NOTARIS</th>
                              <th width="10%">NO TELP</th>
                              <th width="30%">ALAMAT</th>
                              <th width="10%">JUMLAH AKAD</th>
                              <th width="10%">ACTION</th>
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


  <!-- Bootstrap modal -->
  <div class="modal fade" id="modal_form" role="dialog">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <h3 class="modal-title">header</h3>
              </div>
              <div class="modal-body form">
                  <form action="#" id="form" class="form-horizontal">
                      <input type="hidden" value="" name="id" />
                      <div class="form-body">


                          <div class="form-group row">
                              <label class="control-label col-md-3">Kode Notaris</label>
                              <div class="col-md-4">
                                  <input name="kode_notaris" id="kode_notaris" class="form-control" type="text">
                                  <span class="help-block"></span>
                              </div>
                          </div>

                          <div class="form-group row">
                              <label class="control-label col-md-3">Nama Notaris</label>
                              <div class="col-md-6">
                                  <input name="nama_notaris" id="nama_notaris" class="form-control" type="text">
                                  <span class="help-block"></span>
                              </div>
                          </div>

                          <div class="form-group row">
                              <label class="control-label col-md-3">No. Telp</label>
                              <div class="col-md-6">
                                  <input name="no_telp" id="no_telp" class="form-control" type="text">
                                  <span class="help-block"></span>
                              </div>
                          </div>

                          <div class="form-group row">
                              <label class="control-label col-md-3">Alamat</label>
                              <div class="col-md-6">
                                  <input name="alamat" id="alamat" class="form-control" type="text">
                                  <span class="help-block"></span>
                              </div>
                          </div>

                      </div>
                  </form>
              </div>
              <div class="modal-footer">
                  <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Simpan</button>
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
              </div>
          </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
  <!-- End Bootstrap modal -->
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

      function add() {
          save_method = 'add';
          $('#form')[0].reset(); // reset form on modals
          $('.form-group').removeClass('has-error'); // clear error class
          $('.help-block').empty(); // clear error string
          $('#modal_form').modal('show'); // show bootstrap modal
          $('.modal-title').text('Tambah Data notaris'); // Set Title to Bootstrap modal title
      }

      function edit(id) {
          save_method = 'update';
          $('#form')[0].reset(); // reset form on modals
          $('.form-group').removeClass('has-error'); // clear error class
          $('.help-block').empty(); // clear error string

          //Ajax Load data from ajax
          $.ajax({
              url: "<?php echo site_url($data_ref['uri_controllers'] . '/ajax_edit/'); ?>" + id,
              type: "GET",
              dataType: "JSON",
              success: function(data) {
                  $('[name="id"]').val(data.id_notaris);
                  $('[name="kode_notaris"]').val(data.kode_notaris);
                  $('[name="nama_notaris"]').val(data.nama_notaris);
                  $('[name="no_telp"]').val(data.no_telp);
                  $('[name="alamat"]').val(data.alamat);

                  $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                  $('.modal-title').text('Edit Data Notaris'); // Set title to Bootstrap modal title

              },
              error: function(jqXHR, textStatus, errorThrown) {
                  alert('Error get data from ajax');
              }
          });
      }

      function reload_table() {
          table.ajax.reload(null, false); //reload datatable ajax
      }

      function save() {
          $('#btnSave').text('Menyimpan...'); //change button text
          $('#btnSave').attr('disabled', true); //set button disable 
          var url;

          if (save_method == 'add') {
              url = "<?php echo site_url($data_ref['uri_controllers'] . '/ajax_add'); ?>";
          } else {
              url = "<?php echo site_url($data_ref['uri_controllers'] . '/ajax_update'); ?>";
          }

          // ajax adding data to database
          var formData = new FormData($('#form')[0]);
          $.ajax({
              url: url,
              type: "POST",
              data: formData,
              contentType: false,
              processData: false,
              dataType: "JSON",
              success: function(data) {

                  if (data.status) //if success close modal and reload ajax table
                  {
                      $('#modal_form').modal('hide');
                      reload_table();
                      Lobibox.notify('success', {
                          size: 'mini',
                          msg: 'Data berhasil Disimpan'
                      });
                  } else {
                      for (var i = 0; i < data.inputerror.length; i++) {
                          $('[name="' + data.inputerror[i] + '"]').parent().parent().addClass(
                              'has-error'
                          ); //select parent twice to select div form-group class and add has-error class
                          $('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[
                              i]); //select span help-block class set text error string
                      }
                  }
                  $('#btnSave').text('Simpan'); //change button text
                  $('#btnSave').attr('disabled', false); //set button enable 


              },
              error: function(jqXHR, textStatus, errorThrown) {
                  alert('Error adding / update data');
                  $('#btnSave').text('Simpan'); //change button text
                  $('#btnSave').attr('disabled', false); //set button enable 

              }
          });
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

  <script type="text/javascript">
      var url = "<?= base_url() ?>";

      function detail(id, jenis) {
          $('#lampiran').load(url + '/lampiran/' + id);
          $('#lampiran_akte').modal('show'); // show bootstrap modal
          $('.modal-title').text('Detail Komisi Penjualan'); // Set Title to Bootstrap modal title

      }
  </script>


  <div class="modal fade bd-example-modal-xl" id="lampiran_akte" tabindex="-1" role="dialog"
      aria-labelledby="modalLabel">
      <div class="modal-dialog modal-xl ">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title" id="modalLabel">Upload Berkas</h4>
                  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span
                          class="sr-only">Close</span></button>
              </div>

              <div class="modal-body">



                  <table class="table table-bordered" id="lampiran">

                  </table>

              </div>
          </div>
      </div>
  </div>
