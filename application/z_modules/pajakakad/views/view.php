  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
          <div class="container-fluid">
              <div class="row mb-2">
                  <div class="col-sm-6">
                      <h1 class="m-0 text-dark">Data Pajak Akad</h1>
                  </div><!-- /.col -->
                  <div class="col-sm-6">
                      <ol class="breadcrumb float-sm-right">
                          <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard'); ?>">Home</a></li>
                          <li class="breadcrumb-item active">Pajak Akad</li>
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
                  <h3 class="card-title">Data Pajak Akad</h3>
                  <div class="card-tools">
                      <a href="#" class="btn btn-info btn-sm" onclick="add()"><i class="fa fa-plus"></i> Tambah
                          Data
                          Pajak</a>&nbsp;
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
                              <th width="20%">ID Billing Akad</th>
                              <th width="20%">NTPN Akad</th>
                              <th width="20%">Nomor Seri Pajak Akad</th>
                              <th width="15%">Lampiran Pajak Akad</th>
                              <th width="10%">Lampiran BPHTB</th>
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


  <!-- Bootstrap modal -->
  <div class="modal fade" id="modal_form" role="dialog">
      <div class="modal-dialog modal-xl">
          <div class="modal-content">
              <div class="modal-header">
                  <h3 class="modal-title">header</h3>
              </div>
              <div class="modal-body form">
                  <form action="#" id="form" class="form-horizontal">
                      <input type="hidden" name="id" id="id" />
                      <div class="form-body">


                          <div class="form-group row">
                              <label class="control-label col-md-3">Tanggal</label>
                              <div class="col-md-3">
                                  <input name="tanggal_penjualan" id="tanggal_penjualan" class="form-control"
                                      type="date" value="<?= date('Y-m-d') ?>">
                                  <span class="help-block"></span>
                              </div>
                          </div>

                          <div class="form-group row">
                              <label class="control-label col-md-3">ID Billing</label>
                              <div class="col-md-3">
                                  <input name="id_billing" id="id_billing" class="form-control" type="text"
                                      value="">
                                  <span class="help-block"></span>
                              </div>
                          </div>


                          <div class="form-group row">
                              <label class="control-label col-md-3">NTPN Akad</label>
                              <div class="col-md-3">
                                  <input name="NTPN" id="NTPN" class="form-control" type="text">
                                  <span class="help-block"></span>
                              </div>
                          </div>

                          <div class="form-group row">
                              <label class="control-label col-md-3">No Seri Pajak Akad</label>
                              <div class="col-md-3">
                                  <input name="no_seri_akad" id="no_seri_akad" class="form-control" type="text">
                                  <span class="help-block"></span>
                              </div>
                          </div>

                          <div class="form-group row">
                              <label class="control-label col-md-3">Lampiran Pajak Akad</label>
                              <div class="col-md-7">
                                  <input name="lampiran_akad" id="lampiran_akad" type="file">
                                  <span class="help-block"></span>
                              </div>
                          </div>


                          <div class="form-group row">
                              <label class="control-label col-md-3">Lampiran BPHTB</label>
                              <div class="col-md-3">
                                  <input name="lampiran_bphtb" id="lampiran_bphtb" type="file">
                                  <span class="help-block"></span>
                              </div>
                          </div>


                          <div class="form-group row">
                              <label class="control-label col-md-3">Catatan</label>
                              <div class="col-md-7">
                                  <input name="keterangan" id="keterangan" class="form-control" type="text">
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

  <script src="<?php echo base_url('theme_admin/plugins/select2/select2.min.js'); ?>"></script>

  <link rel="stylesheet" type="text/css" href="<?php echo base_url('theme_admin/plugins/select2/select2.css'); ?>">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('theme_admin/plugins/select2/select2-bootstrap.css'); ?>">


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
          $('.modal-title').text('Form Pajak Akad'); // Set Title to Bootstrap modal title
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
                  $('[name="id"]').val(data.id_pajak);
                  $('[name="id_billing"]').val(data.id_billing);
                  $('[name="NTPN"]').val(data.NTPN_akad);
                  $('[name="no_seri_akad"]').val(data.no_seri_pajak_akad);
                  $('[name="keterangan"]').val(data.keterangan);

                  $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                  $('.modal-title').text('Edit Data Pajak'); // Set title to Bootstrap modal title

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
                      location.reload();
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

      var url_apps = '<?= base_url() ?>';

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
                              location.reload();
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


      function lampiran_1(idPajak) {
          $('#lampiran').modal('show');
          $('#detailLampiran').load('<?= base_url('pajakakad/view_lampiran/') ?>' + idPajak);
      };

      function lampiran_2(idPajak) {
          $('#lampiran').modal('show');
          $('#detailLampiran').load('<?= base_url('pajakakad/view_lampiran_2/') ?>' + idPajak);
      };
  </script>


  <div class="modal fade" id="modal_form_notif" role="dialog">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <h3 class="modal-title">header</h3>
              </div>
              <div class="modal-body">
                  <form action="#" id="form_notif" class="form-horizontal">
                      <input type="hidden" value="" name="id" />
                      <input type="hidden" value="" name="noFile" />
                      <div class="form-body">


                          <div class="form-group row">
                              <label class="control-label col-md-2">Nomor Tujuan</label>
                              <div class="col-md-3">
                                  <input name="no_telp" placeholder="" class="form-control" type="text">
                                  <span class="help-block"></span>
                              </div>
                          </div>

                          <div class="form-group row">
                              <label class="control-label col-md-2">Nama Kontak</label>
                              <div class="col-md-3">
                                  <input name="nama_lengkap" placeholder="" class="form-control" type="text">
                                  <span class="help-block"></span>
                              </div>
                          </div>

                          <div class="form-group row">
                              <label class="control-label col-md-2">Isi Pesan</label>
                              <div class="col-md-8">
                                  <textarea name="isi_pesan" rows="7" class="form-control"></textarea>
                                  <span class="help-block"></span>
                              </div>
                          </div>

                          <div class="form-group row">
                              <label class="control-label col-md-2">Kwitansi</label>
                              <div class="col-md-10">
                                  <div id="kartuanggota">

                                  </div>
                              </div>
                          </div>

                      </div>
                  </form>
              </div>
              <div class="modal-footer">
                  <button type="button" id="btnSave" onclick="kirim()" class="btn btn-primary">Kirim
                      Pesan</button>
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
              </div>
          </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->



  <div class="modal" tabindex="-1" id="lampiran">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title">Lampiran</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <div id="detailLampiran"></div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              </div>
          </div>
      </div>
  </div>
