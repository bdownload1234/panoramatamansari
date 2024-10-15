  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
          <div class="container-fluid">
              <div class="row mb-2">
                  <div class="col-sm-6">
                      <h1 class="m-0 text-dark">Data Pencairan Bank</h1>
                  </div><!-- /.col -->
                  <div class="col-sm-6">
                      <ol class="breadcrumb float-sm-right">
                          <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard'); ?>">Home</a></li>
                          <li class="breadcrumb-item active">Keuangan Pencairan</li>
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
                  <h3 class="card-title">Total : Rp. </h3>
                  <div class="card-tools">
                  <a href="#" onclick="add()" class="btn btn-warning btn-sm" ><i class="fa fa-plus"></i> Input Pencairan</a>&nbsp;
                      <a href="<?=base_url('keuangan_booking/excel');?>" target="_blank" class="btn btn-info btn-sm" ><i class="fa fa-plus"></i> Import Data ke Excel</a>&nbsp;
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
                              <th width="25%">Nama Lengkap</th>
                              <th width="15%">Lokasi Kavling</th>
                              <th width="15%">Nama Bank</th>
                              <th width="15%">Nominal Pengajuan</th>
                              <th width="15%">Jumlah Pencairan</th>
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
      <div class="modal-dialog modal-lg">
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
                                  <input name="tanggal" id="tanggal" class="form-control" type="date" value="<?= date('Y-m-d') ?>">
                                  <span class="help-block"></span>
                              </div>
                          </div>

                          <div class="form-group row">
                            <label class="control-label col-md-3">Nama Customer</label>
                            <div class="col-md-6">
                                <input name="nama_lengkap" id="nama_lengkap" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>


                          <div class="form-group row">
                              <label class="control-label col-md-3">Lokasi Kavling</label>
                              <div class="col-md-3">
                                  <input name="kode_kavling" id="kode_kavling" class="form-control" type="text" readonly>
                                  <span class="help-block"></span>
                              </div>
                          </div>

                          <div class="form-group row">
                              <label class="control-label col-md-3">Nama Bank</label>
                              <div class="col-md-5">
                                  <select name="bank" id="bank" class="form-control" type="text">
                                    <?php 
                                    $bank = $this->db->query("SELECT * FROM bank")->result();
                                    foreach($bank as $bk){
                                        echo '<option value="'.$bk->id_bank.'">'.$bk->nama_bank.'</option>';
                                    }
                                    ?>
                                    </select>
                              </div>
                          </div>


                          <div class="form-group row">
                              <label class="control-label col-md-3">Pengajuan Kredit</label>
                              <div class="col-md-5">
                                  <input name="pengajuan" id="pengajuan" class="form-control" type="text">
                                  <span class="help-block"></span>
                              </div>
                          </div>

                          <div class="form-group row">
                              <label class="control-label col-md-3">Pencairan Kredit</label>
                              <div class="col-md-5">
                                  <input name="pencairan" id="pencairan" class="form-control" type="text">
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





  <!-- Bootstrap modal -->
  <div class="modal fade" id="modal_form_detail" role="dialog">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <h3 class="modal-title">Detail Cicilan</h3>
              </div>
              <div class="modal-body form">
                    <div id="detailDisposisi"></div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
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
          $('.modal-title').text('Form Pencairan Kredit'); // Set Title to Bootstrap modal title
      }

      function edit(id) {
        $('#modal_form_detail').modal('show'); // show bootstrap modal
        $('#detailDisposisi').load('<?=base_url('keuangan_dpcicilan/ajax_edit/');?>' + id);
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


      $("#nama_lengkap").select2({
    ajax: {
      url: url_apps+'spr/ajax_select',
      dataType: 'json',
      delay: 250,
      data: function (params) {
        return {
          q: params, // search term
        };
      },
      results: function (data, params) {
        console.log(data);
        return {
            results: $.map(data, function (item) {
                return {
                  text: item.nama_lengkap,
                    id: item.id_customer
                }
            })
        };
      },
      cache: true
    },
    minimumInputLength: 1,
  });  



$('#nama_lengkap').on('change', function() {
  
  $.ajax({
    url: url_apps + 'spr/get_select/' + $(this).val(),
    type: 'GET',
    dataType: 'json',
  })
  .done(function(data) {
    $('#id_customer').val(data.id_customer);
    $('#booking_fee').val(data.booking_fee);
    $('#kode_kavling').val(data.lokasi_kavling);    
  })
  .fail(function() {
    console.log("error");
  })
  .always(function() {
    console.log("complete");
  });
  
});

  </script>


