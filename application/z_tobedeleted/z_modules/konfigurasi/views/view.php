  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Konfigurasi</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard'); ?>">Home</a></li>
              <li class="breadcrumb-item active">Konfigurasi</li>
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
          <h3 class="card-title">Pengaturan Aplikasi</h3>
        </div>

        <!-- /.card-header -->
        <div class="card-body">
          <div class="row">
          <div class="col-md-12">

          <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id"/> 
                    <div class="form-body">

                        <div class="form-group row">
                            <label class="control-label col-md-3">Nama Perusahaan</label>
                            <div class="col-md-6">
                                <input name="nama_perusahaan" placeholder="" class="form-control" type="text" value="<?=$nama_perusahaan;?>">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Nama Kavling</label>
                            <div class="col-md-6">
                                <input name="nama_kavling" placeholder="" class="form-control" type="text" value="<?=$nama_kavling;?>">
                                <span class="help-block"></span>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="control-label col-md-3">Alamat</label>
                            <div class="col-md-8">
                                <input name="alamat" placeholder="" class="form-control" type="text" value="<?=$alamat;?>">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Email</label>
                            <div class="col-md-6">
                                <input name="email" placeholder="" class="form-control" type="text" value="<?=$email;?>">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">No. Telp</label>
                            <div class="col-md-6">
                                <input name="no_telp" placeholder="" class="form-control" type="text" value="<?=$telp;?>">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">No. HP</label>
                            <div class="col-md-6">
                                <input name="no_hp" placeholder="" class="form-control" type="text" value="<?=$hape;?>">
                                <span class="help-block"></span>
                            </div>
                        </div>           
                        
                        <div class="form-group row">
                            <label class="control-label col-md-3">Kota Penandatanganan</label>
                            <div class="col-md-6">
                                <input name="kota_penandatanganan" placeholder="" class="form-control" type="text" value="<?=$kota_penandatanganan;?>">
                                <span class="help-block"></span>
                            </div>
                        </div>    

                        <div class="form-group row">
                            <label class="control-label col-md-3">Nama Penanda Tangan</label>
                            <div class="col-md-6">
                                <input name="nama_penandatangan" placeholder="" class="form-control" type="text" value="<?=$nama_penandatangan;?>">
                                <span class="help-block"></span>
                            </div>
                        </div>    



                        <div class="form-group row">
                            <label class="control-label col-md-3">Nama Menyetujui</label>
                            <div class="col-md-6">
                                <input name="nama_menyetujui" placeholder="" class="form-control" type="text" value="<?=$nama_mengetahui;?>">
                                <span class="help-block"></span>
                            </div>
                        </div>    
                        
                        <hr>
                        
                        <div class="form-group row">
                            <label class="control-label col-md-3">Nama Bank</label>
                            <div class="col-md-6">
                                <input name="nama_bank" placeholder="" class="form-control" type="text" value="<?=$nama_bank;?>">
                                <span class="help-block"></span>
                            </div>
                        </div>    
                        
                        <div class="form-group row">
                            <label class="control-label col-md-3">No. Rekening</label>
                            <div class="col-md-6">
                                <input name="no_rekening" placeholder="" class="form-control" type="text" value="<?=$no_rekening;?>">
                                <span class="help-block"></span>
                            </div>
                        </div>   
                        
                        <div class="form-group row">
                            <label class="control-label col-md-3">Nama Pemilik</label>
                            <div class="col-md-6">
                                <input name="nama_pemilik_rek" placeholder="" class="form-control" type="text" value="<?=$nama_pemilik_rek;?>">
                                <span class="help-block"></span>
                            </div>
                        </div>   


                        <hr>
                        
                        <div class="form-group row">
                            <label class="control-label col-md-3">Template Kwitansi</label>
                            <div class="col-md-2">
                                <select name="template_kwitansi" id="template_kwitansi"  class="form-control">
                                    <option value="kwitansi_1" <?=$a = $template_kwitansi=='kwitansi_1'?'selected':'';?>>Kwitansi 1</option>
                                    <option value="kwitansi_2" <?=$a = $template_kwitansi=='kwitansi_2'?'selected':'';?>>Kwitansi 2</option>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>    

                        <div class="form-group row">
                            <label class="control-label col-md-3">Halaman Front Page</label>
                            <div class="col-md-2">
                                <select name="front_page" id="front_page"  class="form-control">
                                    <option value="0" <?=$a = $front_page=='0'?'selected':'';?>>Non Aktif</option>
                                    <option value="1" <?=$a = $front_page=='1'?'selected':'';?>>Aktif</option>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>    

                        <div class="form-group row">
                            <label class="control-label col-md-3">Template Login</label>
                            <div class="col-md-3">
                            <select name="template_login" id="template_login"  class="form-control">
                                    <option value="login_v1" <?=$a = $template_login=='login_v1'?'selected':'';?>>Template Login Model 1</option>
                                    <option value="login_v2" <?=$a = $template_login=='login_v2'?'selected':'';?>>Template Login Model 2</option>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>   




                        <div class="form-group row">
                            <label class="control-label col-md-3"></label>
                            <div class="col-md-9">
                                <button type="button" id="btnSave" onclick="update()" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>


                        
                    </div>
                

              </div>


            </div>


            </form>


          </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
</div>



</body>
</html>





<?php  $this->load->view('template/footer'); ?>


<script type="text/javascript">

  var save_method; //for save method string
  var table;
  var url = "<?php echo site_url(); ?>";


   function update(){

           url = "<?php echo site_url('konfigurasi/ajax_update')?>";

    
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


</script>


