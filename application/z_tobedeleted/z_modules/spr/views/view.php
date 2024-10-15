  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Data Pemesanan Rumah</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard'); ?>">Home</a></li>
              <li class="breadcrumb-item active">SPR</li>
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
          <h3 class="card-title">Data SPR</h3>
              <div class="card-tools">
                <!--<a href="#" class="btn btn-info btn-sm" onclick="add()"><i class="fa fa-plus"></i> Buat SPR Baru</a>&nbsp;-->
                <button class="btn btn-default btn-sm" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
              </div>
              <!-- /.card-tools -->
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


<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">header</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" name="id" id="id"/> 
                    <div class="form-body">


                        <div class="form-group row">
                            <label class="control-label col-md-3">Tanggal SPR</label>
                            <div class="col-md-3">
                                <input name="tanggal_spr" id="tanggal_spr" class="form-control" type="date" value="<?=date('Y-m-d');?>">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Nomor SPR</label>
                            <div class="col-md-3">
                                <input name="nomor_spr" id="nomor_spr" class="form-control" type="text" value="">
                                <span class="help-block"></span>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="control-label col-md-3">Nama Customer</label>
                            <div class="col-md-3">
                                <input name="nama_lengkap" id="nama_lengkap" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">No. KTP</label>
                            <div class="col-md-3">
                                <input name="no_ktp" id="no_ktp" class="form-control" type="text" readonly>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="control-label col-md-3">Alamat</label>
                            <div class="col-md-7">
                                <input name="alamat" id="alamat" class="form-control" type="text" readonly>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">No. Telp</label>
                            <div class="col-md-3">
                                <input name="no_telp" id="no_telp" class="form-control" type="text" readonly>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Nama Saudara</label>
                            <div class="col-md-7">
                                <input name="nama_saudara" id="nama_saudara" class="form-control" type="text" readonly>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Nomor HP Keluarga tidak serumah</label>
                            <div class="col-md-3">
                                <input name="no_hp_tidak_serumah" id="no_hp_tidak_serumah" class="form-control" type="text" readonly>
                                <span class="help-block"></span>
                            </div>
                        </div>

                    
                        <div class="form-group row">
                            <label class="control-label col-md-3">Lokasi Rumah</label>
                            <div class="col-md-3">
                                <input name="kode_kavling" id="kode_kavling" class="form-control" type="text" readonly>
                                <input name="id_kavling" id="id_kavling" class="form-control" type="hidden">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Harga Rumah</label>
                            <div class="col-md-3">
                                <input name="harga_rumah" id="harga_rumah" class="form-control" type="text" readonly>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Nomor VA</label>
                            <div class="col-md-3">
                                <input name="nomor_va" id="nomor_va" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Nominal Booking</label>
                            <div class="col-md-3">
                                <input name="nominal_booking" id="nominal_booking" class="form-control" type="text" readonly>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Catatan</label>
                            <div class="col-md-7">
                                <input name="catatan" id="catatan" class="form-control" type="text">
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
<div class="modal fade" id="modal_form_pindah" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">header</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form_pindah" class="form-horizontal">
                    <input type="hidden" name="id" id="id"/> 
                    <div class="form-body">


                        <div class="form-group row">
                            <label class="control-label col-md-3">Tanggal SPR</label>
                            <div class="col-md-3">
                                <input name="tanggal_spr" id="tanggal_spr" class="form-control" type="date" value="<?=date('Y-m-d');?>">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Nomor SPR Lama</label>
                            <div class="col-md-3">
                                <input name="no_spr_lama" id="no_spr_lama" class="form-control" type="text" value="" readonly>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="control-label col-md-3">Nomor SPR Baru</label>
                            <div class="col-md-3">
                                <input name="nomor_spr" id="nomor_spr" class="form-control" type="text" value="<?=$notrx;?>" readonly>
                                <span class="help-block"></span>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="control-label col-md-3">Nama Customer</label>
                            <div class="col-md-3">
                                <input name="nama_lengkap" id="nama_lengkap" class="form-control" type="text" readonly>
                                <input name="id_customer" id="id_customer" class="form-control" type="hidden" readonly>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">No. KTP</label>
                            <div class="col-md-3">
                                <input name="no_ktp" id="no_ktp" class="form-control" type="text" readonly>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="control-label col-md-3">Alamat</label>
                            <div class="col-md-7">
                                <input name="alamat" id="alamat" class="form-control" type="text" readonly>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">No. Telp</label>
                            <div class="col-md-3">
                                <input name="no_telp" id="no_telp" class="form-control" type="text" readonly>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Nama Saudara</label>
                            <div class="col-md-7">
                                <input name="nama_saudara" id="nama_saudara" class="form-control" type="text" readonly>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Nomor HP Keluarga tidak serumah</label>
                            <div class="col-md-3">
                                <input name="no_hp_tidak_serumah" id="no_hp_tidak_serumah" class="form-control" type="text" readonly>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <hr>

                    
                        <div class="form-group row">
                            <label class="control-label col-md-3">Lokasi Rumah Lama</label>
                            <div class="col-md-3">
                                <input name="kode_kavling" id="kode_kavling" class="form-control" type="text" readonly>
                                <input name="id_kavling" id="id_kavling" class="form-control" type="hidden">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Lokasi Rumah Baru</label>
                            <div class="col-md-3">
                                <input name="kode_kavling_baru" id="kode_kavling_baru" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Harga Rumah Lama</label>
                            <div class="col-md-3">
                                <input name="harga_rumah_pindah" id="harga_rumah_pindah" class="form-control" type="text" readonly>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Harga Rumah Baru</label>
                            <div class="col-md-3">
                                <input name="harga_rumah_baru" id="harga_rumah_baru" class="form-control" type="text" readonly>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Biaya Pindah Kavling</label>
                            <div class="col-md-3">
                                <input name="biaya_pindah" id="biaya_pindah" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Catatan Pindah</label>
                            <div class="col-md-6">
                                <input name="catatan_pindah" id="catatan_pindah" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <hr>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save_pindah()" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->










<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form_ganti" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">header</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form_ganti_nama" class="form-horizontal">
                    <input type="hidden" name="id" id="id"/> 
                    <div class="form-body">


                        <div class="form-group row">
                            <label class="control-label col-md-3">Tanggal Ganti Nama</label>
                            <div class="col-md-3">
                                <input name="tanggal_ganti" id="tanggal_ganti" class="form-control" type="date" value="<?=date('Y-m-d');?>">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Nomor SPR</label>
                            <div class="col-md-3">
                                <input name="no_spr" id="no_spr" class="form-control" type="text" value="">
                                <input name="id_spr" id="id_spr" class="form-control" type="hidden" value="">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Nama Konsumen</label>
                            <div class="col-md-5">
                                <input name="nama_lengkap" id="nama_lengkap" class="form-control" type="text" readonly>
                                <input name="id_customer" id="id_customer" class="form-control" type="hidden" readonly>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="control-label col-md-3">Nama Pengganti Konsumen</label>
                            <div class="col-md-5">
                                <input name="nama_lengkap_pengganti" id="nama_lengkap_pengganti" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">No. KTP</label>
                            <div class="col-md-3">
                                <input name="no_ktp" id="no_ktp" class="form-control" type="text" readonly>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="control-label col-md-3">Alamat</label>
                            <div class="col-md-7">
                                <input name="alamat" id="alamat" class="form-control" type="text" readonly>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">No. Telp</label>
                            <div class="col-md-3">
                                <input name="no_telp" id="no_telp" class="form-control" type="text" readonly>
                                <span class="help-block"></span>
                            </div>
                        </div>      
                        
                        <div class="form-group row">
                            <label class="control-label col-md-3">Biaya Ganti Nama</label>
                            <div class="col-md-3">
                                <input name="biaya" id="biaya" class="form-control" type="text" value="1.000.000" readonly>
                                <span class="help-block"></span>
                            </div>
                        </div>      

                        <div class="form-group row">
                            <label class="control-label col-md-3">Nama Legalitas</label>
                            <div class="col-md-3">
                                <input name="nama_legalitas" id="nama_legalitas" class="form-control" type="text" >
                                <span class="help-block"></span>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="control-label col-md-3">Catatan Ganti Nama</label>
                            <div class="col-md-6">
                                <input name="catatan_ganti_nama" id="catatan_ganti_nama" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <hr>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save_ganti()" class="btn btn-primary">Simpan</button>
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

var url_apps = "<?=base_url();?>";
$(document).ready(function () {
    $("#detail").hide();
    $("#sumberLainnya").hide();
//----->
//Ambil semua data customer untuk select 2
  $("#kode_kavling_baru").select2({
    ajax: {
      url: url_apps + 'reg/ajax_select_kavling',
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
                    text: item.kode_kavling,
                    id: item.id_kavling
                }
            })
        };
      },
      cache: true
    },
    minimumInputLength: 1,
  });  

});  


  
  $('#kode_kavling_baru').on('change', function() {
  var idSiswa = $(this).val();
  $.ajax({
    url: url_apps + 'reg/get_rumah/' + $(this).val(),
    type: 'GET',
    dataType: 'json',
  })
  .done(function(data) {
    // alert(data.hrg_jual);
    $('#harga_rumah_baru').val(data.hrg_jual);
    
  })
  .fail(function() {
    console.log("error");
  })
  .always(function() {
    console.log("complete");
  });
  
});


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
               $('[name="id"]').val(data.id_spr);
               $('[name="nama_lengkap"]').val(data.nama_lengkap);
               $('[name="nomor_spr"]').val(data.nomor_spr);
               $('[name="no_ktp"]').val(data.nik);
               $('[name="alamat"]').val(data.alamat);
               $('[name="catatan"]').val(data.catatan);
               $('[name="no_telp"]').val(data.no_telp);
               $('[name="nama_saudara"]').val(data.nama_saudara);
               $('[name="no_hp_tidak_serumah"]').val(data.no_telp_saudara);

               $('#nama_lengkap').select2('data', {id: data.id_customer, text: data.nama_lengkap});
               $('[name="kode_kavling"]').val(data.kode_kavling);
               $('[name="harga_rumah"]').val(data.harga_rumah);
               $('[name="nomor_va"]').val(data.nomor_va);
               $('[name="nominal_booking"]').val(data.booking_fee_spr);

               $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
               $('.modal-title').text('Edit SPR'); // Set title to Bootstrap modal title

           },
           error: function (jqXHR, textStatus, errorThrown)
           {
               alert('Error get data from ajax');
           }
       });
   }



   function pindah(id)
   {
       $('#form_pindah')[0].reset(); // reset form on modals
       $('.form-group').removeClass('has-error'); // clear error class
       $('.help-block').empty(); // clear error string
    
       //Ajax Load data from ajax
       $.ajax({
           url : "<?php echo site_url($data_ref['uri_controllers'].'/ajax_pindah_tampil')?>/" + id,
           type: "GET",
           dataType: "JSON",
           success: function(data)
           {
               $('[name="id"]').val(data.id_spr);
               $('[name="nama_lengkap"]').val(data.nama_lengkap);
               $('[name="no_spr_lama"]').val(data.nomor_spr);
               $('[name="id_customer"]').val(data.id_customer);
               $('[name="no_ktp"]').val(data.nik);
               $('[name="alamat"]').val(data.alamat);
               $('[name="catatan"]').val(data.catatan);
               $('[name="no_telp"]').val(data.no_telp);
               $('[name="nama_saudara"]').val(data.nama_saudara);
               $('[name="no_hp_tidak_serumah"]').val(data.no_telp_saudara);

               $('#nama_lengkap').select2('data', {id: data.id_customer, text: data.nama_lengkap});
               $('[name="kode_kavling"]').val(data.kode_kavling);
               $('[name="id_kavling"]').val(data.id_kavling);
            //    $('[name="harga_rumah"]').val(data.harga_rumah);
               $('[name="harga_rumah"]').val(data.harga_rumah);
               $('[name="nomor_va"]').val(data.nomor_va);
               $('[name="nominal_booking"]').val(data.booking_fee_spr);

               $('#modal_form_pindah').modal('show'); // show bootstrap modal when complete loaded
               $('.modal-title').text('Pindah Kavling'); // Set title to Bootstrap modal title

           },
           error: function (jqXHR, textStatus, errorThrown)
           {
               alert('Error get data from ajax');
           }
       });
   }



   function ganti(id)
   {
       $('#form_ganti_nama')[0].reset(); // reset form on modals
       $('.form-group').removeClass('has-error'); // clear error class
       $('.help-block').empty(); // clear error string
    
       //Ajax Load data from ajax
       $.ajax({
           url : "<?php echo site_url($data_ref['uri_controllers'].'/ajax_ganti_nama')?>/" + id,
           type: "GET",
           dataType: "JSON",
           success: function(data)
           {
               $('[name="id"]').val(data.id_spr);
               $('[name="nama_lengkap"]').val(data.nama_lengkap);
               $('[name="no_spr"]').val(data.nomor_spr);
               $('[name="id_customer"]').val(data.id_customer);
               $('[name="no_ktp"]').val(data.nik);
               $('[name="alamat"]').val(data.alamat);
               $('[name="catatan"]').val(data.catatan);
               $('[name="no_telp"]').val(data.no_telp);
               $('[name="nama_saudara"]').val(data.nama_saudara);
               $('[name="no_hp_tidak_serumah"]').val(data.no_telp_saudara);

               $('#nama_lengkap').select2('data', {id: data.id_customer, text: data.nama_lengkap});
               $('[name="kode_kavling"]').val(data.kode_kavling);
               $('[name="id_kavling"]').val(data.id_kavling);
               $('[name="harga_rumah"]').val(data.harga_rumah);
               $('[name="nomor_va"]').val(data.nomor_va);
               $('[name="nominal_booking"]').val(data.booking_fee_spr);

               $('#modal_form_ganti').modal('show'); // show bootstrap modal when complete loaded
               $('.modal-title').text('Ganti Nama Legalitas'); // Set title to Bootstrap modal title

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
                   location.reload(); 
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



   function save_pindah()
   {
       $('#btnSave').text('Menyimpan...'); //change button text
       $('#btnSave').attr('disabled',true); //set button disable 
       var url;
    
      url = "<?php echo site_url($data_ref['uri_controllers'].'/ajax_pindah')?>";
    
       // ajax adding data to database
       var formData = new FormData($('#form_pindah')[0]);
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
                   $('#modal_form_pindah').modal('hide');
                   reload_table();
                   Lobibox.notify('success', {
                       size: 'mini',
                       msg: 'Data berhasil Disimpan'
                   });
                   location.reload(); 
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
   
   
    function save_ganti()
   {
       $('#btnSave').text('Menyimpan...'); //change button text
       $('#btnSave').attr('disabled',true); //set button disable 
       var url = "<?php echo site_url($data_ref['uri_controllers'].'/ajax_ganti')?>";
    
       // ajax adding data to database
       var formData = new FormData($('#form_ganti_nama')[0]);
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
                   $('#modal_form_ganti').modal('hide');
                   reload_table();
                   Lobibox.notify('success', {
                       size: 'mini',
                       msg: 'Data berhasil Disimpan'
                   });
                   location.reload(); 
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



   var url_apps = '<?=base_url();?>';

   function hapus(id){
    $.confirm({
      title: 'Confirm!',
      content: 'Apakah anda yakin akan membatalkan transaksi ini ?',
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
                location.reload(); 
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
    $('#no_ktp').val(data.nik);
    $('#alamat').val(data.alamat);
    $('#no_telp').val(data.no_telp);
    $('#no_hp_tidak_serumah').val(data.no_telp_saudara);
    $('#nama_saudara').val(data.nama_saudara);
    $('#nominal_booking').val(data.booking_fee);
    $('#kode_kavling').val(data.kode_kavling);
    $('#id_kavling').val(data.id_kavling);
    
  })
  .fail(function() {
    console.log("error");
  })
  .always(function() {
    console.log("complete");
  });
  
});




var harga_rumah_pindah = document.getElementById('harga_rumah_pindah');
    harga_rumah_pindah.addEventListener('keyup', function(e) {
    harga_rumah_pindah.value = formatRupiah(this.value);
});

// var harga_rumah_baru_pindah = document.getElementById('harga_rumah_baru_pindah');
//     harga_rumah_baru_pindah.addEventListener('keyup', function(e) {
//     harga_rumah_baru_pindah.value = formatRupiah(this.value);
// });

var biaya_pindah = document.getElementById('biaya_pindah');
    biaya_pindah.addEventListener('keyup', function(e) {
    biaya_pindah.value = formatRupiah(this.value);
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

function limitCharacter(event) {
  key = event.which || event.keyCode;
  if (key != 188 // Comma
    &&
    key != 8 // Backspace
    &&
    key != 17 && key != 86 & key != 67 // Ctrl c, ctrl v
    &&
    (key < 48 || key > 57) // Non digit
    // Dan masih banyak lagi seperti tombol del, panah kiri dan kanan, tombol tab, dll
  ) {
    event.preventDefault();
    return false;
  }
}

</script>


