<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <!-- <h1 class="m-0 text-dark">Dashboard
          <?php echo $this->encryption->decrypt($this->session->userdata('id')); ?>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->

      <div class="row">
      <div class="col-lg-12 col-12">
        <a class="btn btn-info btn-sm" href="#" onclick="tambah()">Tambah Data Legal</a>
        <a class="btn btn-success btn-sm" href="<?=base_url('legal/detail');?>">Detail Data</a>
      </div>
      <br>
      <hr>
        <div class="col-lg-12 col-12">

          


  

<!-- ================================================================================================== -->


<?php 
$this->load->view('master_svg/denah_spn_1');
?>



<!-- ========================================================================================== -->
          </div>
        </div>
      </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php  $this->load->view('template/footer'); ?>
<script src="<?php echo base_url('assets/admin/plugins/select2/select2.min.js')?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/admin/plugins/select2/select2.css') ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/admin/plugins/select2/select2-bootstrap.css') ?>">

<script type="text/javascript">
var url_apps = "<?=base_url();?>";
$(document).ready(function () {
//----->
//Ambil semua data customer untuk select 2
  $("#kode_kavling").select2({
    ajax: {
      url: url_apps+'legal/ajax_select_kavling',
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

  $('#kode_kavling').on('change', function() {
  var idSiswa = $(this).val();
  $.ajax({
    url: url_apps + 'legal/get/' + $(this).val(),
    type: 'GET',
    dataType: 'json',
  })
  .done(function(data) {
    //alert(data.ALAMAT);
    // alert('asd' + data.nama_lengkap);
    $("#nama_cust").val(data.nama_lengkap);

    
  })
  .fail(function() {
    console.log("error");
  })
  .always(function() {
    console.log("complete");
  });
  
});

});




function tambah()
   {
      //  save_method = 'tambah';
       save_method = 'add';
       $('#form')[0].reset(); // reset form on modals
       $('.form-group').removeClass('has-error'); // clear error class
       $('.help-block').empty(); // clear error string
       $('#modal_form_legal').modal('show'); // show bootstrap modal
       $('.modal-title').text('Input Data Legal'); // Set Title to Bootstrap modal title
   }


   function add(id)
   {
       
       $('#form')[0].reset(); // reset form on modals
       $('.form-group').removeClass('has-error'); // clear error class
       $('.help-block').empty(); // clear error string
       $('#modal_form').modal('show'); // show bootstrap modal

       //Ajax Load data from ajax
       $.ajax({
           url : "<?php echo site_url('legal/ajax_tampil/')?>" + id,
           type: "GET",
           dataType: "JSON",
           success: function(data)
           {
               $('[name="kode"]').val(data.kode_kavling);
               $('[name="luas"]').val(data.luas_tanah);
               $('[name="harga_jual"]').val(data.harga_jual);
               $('[name="nama_lengkap"]').val(data.nama_lengkap);
               $('[name="no_shm"]').val(data.no_shm);
               $('[name="status"]').val(data.stt_legal);
              
               $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
               $('.modal-title').text('Detail Legal Kavling'); // Set title to Bootstrap modal title

           },
           error: function (jqXHR, textStatus, errorThrown)
           {
               alert('Error get data from ajax');
           }
       });
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
       var formData = new FormData($('#form_isi')[0]);
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
                   $('#modal_form_legal').modal('hide');
                   location.reload(); 
                  //  reload_table();
                  //  Lobibox.notify('success', {
                  //      size: 'mini',
                  //      msg: 'Data berhasil Disimpan'
                  //  });
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


</script>


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
                            <label class="control-label col-md-3">Kode Kavling</label>
                            <div class="col-md-3">
                                <input name="kode" placeholder="" class="form-control" type="text" readonly>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Luas Tanah</label>
                            <div class="col-md-4">
                                <input name="luas" placeholder="" class="form-control" type="text" readonly>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Harga Cash</label>
                            <div class="col-md-4">
                                <input name="harga_jual" placeholder="" class="form-control" type="text" readonly>
                                <span class="help-block"></span>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="control-label col-md-3">Status Kavling</label>
                            <div class="col-md-4">
                                <input name="status" placeholder="" class="form-control" type="text" readonly>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Nama Pembeli</label>
                            <div class="col-md-4">
                                <input name="nama_lengkap" placeholder="" class="form-control" type="text" id="nama_lengkap" readonly>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">No. SHM</label>
                            <div class="col-md-4">
                                <input name="no_shm" class="form-control" type="text" id="no_shm" readonly>
                                <span class="help-block"></span>
                            </div>
                        </div>


                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->








<div class="modal fade" id="modal_form_legal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">header</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form_isi" class="form-horizontal">
                    <input type="hidden" value="" name="id"/> 
                    <div class="form-body">

    
                        <div class="form-group row">
                            <label class="control-label col-md-3">Kode Kavling</label>
                            <div class="col-md-5">
                                <input name="kode_kavling" id="kode_kavling" class="form-control" type="text" >
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Nama Pembeli</label>
                            <div class="col-md-5">
                                <input name="nama_cust" placeholder="" class="form-control" type="text" id="nama_cust">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Ukuran Tanah</label>
                            <div class="col-md-5">
                                <input name="ukuran_tanah" placeholder="" class="form-control" type="text" >
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Nomor SHM</label>
                            <div class="col-md-5">
                                <input name="no_shm" placeholder="" class="form-control" type="text" >
                                <span class="help-block"></span>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="control-label col-md-3">Status Legalitas</label>
                            <div class="col-md-5">
                              <select name="status" id="status"  class="form-control">
                              <option value="">-- Pilih --</option>
                                <option value="Selesai">Selesai</option>
                                <option value="Proses">Proses</option>
                                <option value="Serah Terima">Serah Terima</option>
                              </select>
                                <span class="help-block"></span>
                            </div>
                        </div>

                       


                    </div>
                </form>
            </div>
            <div class="modal-footer">
            <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->