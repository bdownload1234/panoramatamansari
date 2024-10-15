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
        <!--<a class="btn btn-success btn-sm" href="<?=base_url('legal/detail');?>">Detail Data</a>-->
        <a class="btn btn-success btn-sm" href="<?=base_url('legal/detailblok/0');?>">Detail Data</a>
      </div>
      <br>
      <hr>
        <div class="col-lg-12 col-12">

          


  

<!-- ================================================================================================== -->


<?php 
$this->load->view('master_svg/denah_spn_1');
?>



<style>
        /* Atur ukuran peta */
        #map-container {
            position: relative;
            height: 400px;
            width: 100%;
        }

        #map {
            height: 100%;
            width: 75%; /* Sesuaikan lebar peta sesuai kebutuhan */
            float: left;
        }

        /* Gaya untuk legenda */
        .legend {
            position: fixed;
            top: 80px;
            right: 30px;
            padding: 10px;
            font-size: 14px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.4);
        }

        .legend-item {
            display: flex;
            align-items: center;
            margin-bottom: 5px;
        }

        .legend-color {
            width: 20px;
            height: 20px;
            margin-right: 5px;
            border-radius: 50%;
            border: 2px solid #000;
        }
    </style>

<!-- Tambahkan legenda -->
<div class="legend">
    <div class="legend-item">
        <div class="legend-color" style="background-color: #FFFF;"></div>
        BELUM PROSES
    </div>
    <div class="legend-item">
        <div class="legend-color" style="background-color: #f58b0a;"></div>
        Sertifikat Induk
    </div>
    <div class="legend-item">
        <div class="legend-color" style="background-color: #f08cf5;"></div>
        Sertifikat Splitzing
    </div>
    <div class="legend-item">
        <div class="legend-color" style="background-color: #0ab6f5;"></div>
        Sertifikat Balik Nama
    </div>
    <div class="legend-item">
        <div class="legend-color" style="background-color: #ffff00;"></div>
        Status Legalitas Tidak Ditemukan
    </div>
    
</div>



<!-- ========================================================================================== -->
          </div>
        </div>
      </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php  $this->load->view('template/footer'); ?>

<script src="<?php echo base_url('theme_admin/plugins/select2/select2.min.js')?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('theme_admin/plugins/select2/select2.css') ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('theme_admin/plugins/select2/select2-bootstrap.css') ?>">

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
    $("#blok").val(data.blok);

    
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
       $('#form_isi, #form_edit')[0].reset(); // reset form on modals
       $('.form-group').removeClass('has-error'); // clear error class
       $('.help-block').empty(); // clear error string
       $('#modal_form_legal').modal('show'); // show bootstrap modal
       $('.modal-title').text('Input Data Legal'); // Set Title to Bootstrap modal title
       $('.file').remove();
   }


   function add(id)
   {
       
       $('#form_edit, #form_isi')[0].reset(); // reset form on modals
       $('.form-group').removeClass('has-error'); // clear error class
       $('.help-block').empty(); // clear error string
       $('#modal_form').modal('show'); // show bootstrap modal
       $('.file').remove();

       //Ajax Load data from ajax
       $.ajax({
           url : "<?php echo site_url('legal/ajax_tampil/')?>" + id,
           type: "GET",
           dataType: "JSON",
           success: function(data)
           {
               if(data == null){
                   
               }else{
                   $('#id_edit').val(data.id_legal);
                   $('#kode_kavling_edit').val(data.kode_kavling);
                   $('#blok_edit').val(data.id_kavling);
                   $('#nama_cust_edit').val(data.nama_lengkap);
                   $('#status_edit').val(data.stt_legal);
                   var ajb = '';
                   if(data.doc_ajb !== null){
                       ajb = `<a href="/legalitas/ajb/`+data.doc_ajb+`" target="_blank" class="file">`+data.doc_ajb+`</a>`;
                   }
                   var sertifikat = '';
                   if(data.doc_sertifikat !== null){
                       sertifikat = `<a href="/legalitas/sertifikat/`+data.doc_sertifikat+`" target="_blank" class="file">`+data.doc_sertifikat+`</a>`;
                   }
                   var pbb = '';
                   if(data.doc_pbb !== null){
                       pbb = `<a href="/legalitas/pbb/`+data.doc_pbb+`" target="_blank" class="file">`+data.doc_pbb+`</a>`;
                   }
                   var imb = '';
                   if(data.doc_imb !== null){
                       imb = `<a href="/legalitas/imb/`+data.doc_imb+`" target="_blank" class="file">`+data.doc_imb+`</a>`;
                   }
                   $('#doc_ajb_edit').after(ajb)
                   $('#doc_sertifikat_edit').after(sertifikat)
                   $('#doc_pbb_edit').after(pbb)
                   $('#doc_imb_edit').after(imb)
               }
               
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
   
   function update()
   {
       $('#btnUpdate').text('Menyimpan...'); //change button text
       $('#btnUpdate').attr('disabled',true); //set button disable 
       var url;
       
       url = "<?php echo site_url($data_ref['uri_controllers'].'/ajax_update')?>";
    
       // ajax adding data to database
       var formData = new FormData($('#form_edit')[0]);
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
               $('#btnUpdate').text('Simpan'); //change button text
               $('#btnUpdate').attr('disabled',false); //set button enable 
    
    
           },
           error: function (jqXHR, textStatus, errorThrown)
           {
               alert('Error adding / update data');
               $('#btnUpdate').text('Simpan'); //change button text
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
                <form action="#" id="form_edit" class="form-horizontal">
                    <input type="hidden" value="" name="id" id="id_edit"/> 
                    <div class="form-body">

    
                        <div class="form-group row">
                            <label class="control-label col-md-3">Blok Kavling</label>
                            <div class="col-md-5">
                                <input name="kode_kavling" id="kode_kavling_edit" class="form-control" type="text" readonly>
                                <input name="blok" id="blok_edit" class="form-control" type="hidden" readonly>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Nama Pembeli</label>
                            <div class="col-md-5">
                                <input name="nama_cust" placeholder="" class="form-control" type="text" id="nama_cust_edit" readonly>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row" style="display: none">
                            <label class="control-label col-md-3">Ukuran Tanah</label>
                            <div class="col-md-5">
                                <input name="ukuran_tanah" placeholder="" class="form-control" type="text" >
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row" style="display: none">
                            <label class="control-label col-md-3">Nomor SHM</label>
                            <div class="col-md-5">
                                <input name="no_shm" placeholder="" class="form-control" type="text" >
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Status Legalitas</label>
                            <div class="col-md-5">
                              <select name="status" id="status_edit"  class="form-control" >
                              <option value="">-- Pilih --</option>
                                <option value="Sertifikat Induk">Sertifikat Induk</option>
                                <option value="Sertifikat Splitzing">Sertifikat Splitzing</option>
                                <option value="Sertifikat Balik Nama">Sertifikat Balik Nama</option>
                              </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="control-label col-md-3">Upload AJB</label>
                            <div class="col-md-5">
                                <input name="doc_ajb" placeholder="" class="form-control" type="file" id="doc_ajb_edit">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="control-label col-md-3">Upload Sertifikat</label>
                            <div class="col-md-5">
                                <input name="doc_sertifikat" placeholder="" class="form-control" type="file" id="doc_sertifikat_edit">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="control-label col-md-3">Upload PBB</label>
                            <div class="col-md-5">
                                <input name="doc_pbb" placeholder="" class="form-control" type="file" id="doc_pbb_edit">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="control-label col-md-3">Upload IMB</label>
                            <div class="col-md-5">
                                <input name="doc_imb" placeholder="" class="form-control" type="file" id="doc_imb_edit">
                                <span class="help-block"></span>
                            </div>
                        </div>



                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnUpdate" onclick="update()" class="btn btn-primary">Update</button>
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
                            <label class="control-label col-md-3">Blok Kavling</label>
                            <div class="col-md-5">
                                <input name="kode_kavling" id="kode_kavling" class="form-control" type="text" >
                                <input name="blok" id="blok" class="form-control" type="hidden" >
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Nama Pembeli</label>
                            <div class="col-md-5">
                                <input name="nama_cust" placeholder="" class="form-control" type="text" id="nama_cust" readonly>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row" style="display: none">
                            <label class="control-label col-md-3">Ukuran Tanah</label>
                            <div class="col-md-5">
                                <input name="ukuran_tanah" placeholder="" class="form-control" type="text" >
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row" style="display: none">
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
                                <option value="Sertifikat Induk">Sertifikat Induk</option>
                                <option value="Sertifikat Splitzing">Sertifikat Splitzing</option>
                                <option value="Sertifikat Balik Nama">Sertifikat Balik Nama</option>
                              </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="control-label col-md-3">Upload AJB</label>
                            <div class="col-md-5">
                                <input name="doc_ajb" placeholder="" class="form-control" type="file" id="doc_ajb">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="control-label col-md-3">Upload Sertifikat</label>
                            <div class="col-md-5">
                                <input name="doc_sertifikat" placeholder="" class="form-control" type="file" id="doc_sertifikat">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="control-label col-md-3">Upload PBB</label>
                            <div class="col-md-5">
                                <input name="doc_pbb" placeholder="" class="form-control" type="file" id="doc_pbb">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="control-label col-md-3">Upload IMB</label>
                            <div class="col-md-5">
                                <input name="doc_imb" placeholder="" class="form-control" type="file" id="doc_imb">
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