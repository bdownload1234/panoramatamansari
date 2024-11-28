  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Data Daftar Hadir Akad</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard'); ?>">Home</a></li>
              <li class="breadcrumb-item active">Daftar Hadir</li>
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
          <h3 class="card-title">Data Daftar Hadir</h3>
              <div class="card-tools">
                <a href="#" class="btn btn-info btn-sm" onclick="add()"><i class="fa fa-plus"></i> Tambah Kehadiran</a>&nbsp;
                <a href="<?=base_url('daftar_hadir/download');?>" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-plus"></i> Download Excel</a>&nbsp;
                <button class="btn btn-default btn-sm" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
              </div>
              <!-- /.card-tools -->
        </div>

        <!-- /.card-header -->
        <div class="card-body">

           <table id="table" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th width="5%">No Akad</th>
                        <th width="15%">Nomor SPR</th>
                        <th width="10%">Tempat</th>
                        <th width="10%">Tanggal Akad</th>
                        <th width="10%">Jam Akad</th>
                        <th width="10%">Blok Unit</th>
                        <th width="20%">Nama Customer</th>
                        <th width="10%">Harga Jual AJB</th>
                        <th width="10%">Jenis Pembelian</th>
                        <th width="10%">Jenis Akad</th>
                        <th width="15%">Notaris</th>
                        <th width="15%">No. Rekening</th>
                        <th width="15%">Keterangan</th>
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


<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">header</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id"/> 
                    <div class="form-body">

                        <div class="form-group row">
                            <label class="control-label col-md-3">Tempat</label>
                            <div class="col-md-7">
                                <input name="tempat" id="tempat" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Tanggal Akad</label>
                            <div class="col-md-4">
                                <input name="tanggal_kehadiran" value="<?=date('Y-m-d');?>" class="form-control" type="date">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="control-label col-md-3">Jam Akad</label>
                            <div class="col-md-4">
                                <input name="jam_kehadiran" value="<?=date('H:i:s');?>" class="form-control" type="time">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Nama Customer</label>
                            <div class="col-md-7">
                                <input name="nama_customer" id="nama_customer" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Lokasi Unit Rumah</label>
                            <div class="col-md-7">
                                <input name="lokasi_kavling" id="lokasi_kavling" class="form-control" type="text" readonly>
                                <input name="id_kavling" id="id_kavling" class="form-control" type="hidden">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Model Rumah</label>
                            <div class="col-md-7">
                                <input name="tipe_bangunan" id="tipe_bangunan" class="form-control" type="text" readonly>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="control-label col-md-3">Tipe Rumah</label>
                            <div class="col-md-7">
                                <input name="tipe_rumah" id="tipe_rumah" class="form-control" type="text" readonly>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="control-label col-md-3">Harga Jual AJB</label>
                            <div class="col-md-7">
                                <input name="harga_jual_ajb" id="harga_jual_ajb" class="form-control" type="text" >
                                <span class="help-block"></span>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="control-label col-md-3">Jenis Pembayaran</label>
                            <div class="col-md-7">
                                <select name="jenis_pembelian" id="jenis_pembelian" class="form-control">
                                    <option value="">-- pilih --</option>
                                    <option value="0">Cash</option>
                                    <option value="1">KPR</option>
                                    </select>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Jenis Akad</label>
                            <div class="col-md-7">
                                <select name="jenis_akad" id="jenis_akad" class="form-control">
                                    <option value="">-- pilih --</option>
                                    <option value="AJB">AJB</option>
                                    <option value="PPJB">PPJB</option>
                                    </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="control-label col-md-3">Notaris</label>
                            <div class="col-md-7">
                                <select name="notaris" id="notaris" class="form-control">
                                    <option value="">-- pilih --</option>
                                    <?php 
                                    $bank = $this->db->query("SELECT * FROM notaris")->result();
                                    foreach($bank as $b){
                                        echo '<option value="'.$b->id_notaris.'">'.$b->nama_notaris.'</option>';
                                    }
                                    ?>
                                    </select>
                                    </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="control-label col-md-3">Bank</label>
                            <div class="col-md-7">
                                <select name="bank" id="bank" class="form-control">
                                    <option value="">-- pilih --</option>
                                    <?php 
                                    $bank = $this->db->query("SELECT * FROM bank")->result();
                                    foreach($bank as $b){
                                        echo '<option value="'.$b->id_bank.'">'.$b->nama_bank.'</option>';
                                    }
                                    ?>
                                    </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        
                        

                        <div class="form-group row">
                            <label class="control-label col-md-3">No. Rekening</label>
                            <div class="col-md-7">
                                <input name="no_rekening" id="no_rekening" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Keterangan</label>
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





<?php  $this->load->view('template/footer'); ?>

<script src="<?php echo base_url('theme_admin/plugins/select2/select2.min.js')?>"></script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('theme_admin/plugins/select2/select2.css') ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('theme_admin/plugins/select2/select2-bootstrap.css') ?>">


<script type="text/javascript">

var url_apps = "<?=base_url();?>"

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
       save_method = 'add';
       $('#form')[0].reset(); // reset form on modals
       $('.form-group').removeClass('has-error'); // clear error class
       $('.help-block').empty(); // clear error string
       $('#modal_form').modal('show'); // show bootstrap modal
       $('.modal-title').text('Tambah Kehadiran'); // Set Title to Bootstrap modal title

   }

   function edit(id)
   {
       save_method = 'update';
       $('#form')[0].reset(); // reset form on modals
       $('.form-group').removeClass('has-error'); // clear error class
       $('.help-block').empty(); // clear error string
    
       //Ajax Load data from ajax
       $.ajax({
           url : "<?php echo site_url($data_ref['uri_controllers'].'/ajax_edit')?>/" + id,
           type: "GET",
           dataType: "JSON",
           success: function(data)
           {
               $('[name="id"]').val(data.id_hadir);
               $('[name="lokasi_kavling"]').val(data.lokasi_kavling);
               $('[name="id_kavling"]').val(data.id_kavling);
               $('[name="id_customer"]').val(data.id_customer);
               $('[name="jenis_pembelian"]').val(data.jenis_pembelian);
               $('[name="jenis_akad"]').val(data.jenis_akad);
               $('[name="bank"]').val(data.id_bank);
               $('[name="notaris"]').val(data.id_notaris);
               $('[name="no_rekening"]').val(data.no_rekening);
               $('[name="keterangan"]').val(data.keterangan);
               $('[name="harga_jual_ajb"]').val(formatRupiah(data.harga_jual_ajb));
               
            //   var $option = $('<option selected>Loading...</option>').val(data.id_customer);
            //     $('[name="nama_customer"]').append($option).trigger('change');
                // $('[name="nama_customer"]').val(data.id_customer).trigger('change');
                $('[name="nama_customer"]').select2('data', { id:data.id_customer, text: data.nama_lengkap}).trigger('change');

               $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
               $('.modal-title').text('Edit Daftar Hadir'); // Set title to Bootstrap modal title
              
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
       var formData = new FormData($('#form')[0]);
       $.ajax({
            url : url,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "JSON",
           success: function(data)
           {
    
               if(data.status) //if success close modal and reload ajax table
               {
                   $('#modal_form').modal('hide');
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


  //Ambil semua data customer untuk select 2
  $("#nama_customer").select2({
    ajax: {
      url: url_apps+'daftar_hadir/ajax_select_customer',
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


  $('#nama_customer').on('change', function() {
      $.ajax({
        url: url_apps + 'customer/get/' + $(this).val(),
        type: 'GET',
        dataType: 'json',
      })
      .done(function(data) {
        // alert(data.lokasi);
        $('#lokasi_kavling').val(data.lokasi_kavling);
        $('#id_kavling').val(data.id_kavling);
        $('#tipe_bangunan').val(data.tipe_bangunan);
        $('#tipe_rumah').val(data.model_rumah);
        
      })
      .fail(function() {
        console.log("error");
      })
      .always(function() {
        console.log("complete");
      });
      
    });

    var harga_jual_ajb = document.getElementById('harga_jual_ajb');
    harga_jual_ajb.addEventListener('keyup', function(e) {
        harga_jual_ajb.value = formatRupiah(this.value);
    });
    
    
        
    /* Fungsi */
    function formatRupiah(bilangan, prefix) {
    var number_string = bilangan.replace(/[^,\d]/g, '').toString(),
      split = number_string.split(','),
      sisa = split[0].length % 3,
      rupiah = split[0].substr(0, sisa),
      ribuan = split[0].substr(sisa).match(/\d{1,3}/gi);
    
    if (ribuan) {
      separator = sisa ? '.' : '';
      rupiah += separator + ribuan.join('.');
    }
    
    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }
    
    function kirim_pesan(id){
        $.confirm({
          title: 'Confirm!',
          content: 'Apakah anda yakin ingin mengirim pesan untuk customer, marketing, dan notaris ?',
          buttons: {
            confirm: function () {
               $.ajax({
                   url : "<?php echo site_url($data_ref['uri_controllers'].'/kirim_pesan')?>/" + id,
                   type: "GET",
                   dataType: "JSON",
                   success: function(data)
                   {
                       alert('Success');
                   },
                   error: function (jqXHR, textStatus, errorThrown)
                   {
                       alert('Error get data from ajax');
                   }
               });
            },
            cancel: function () {
              
            }
          }
        });
    }
</script>


