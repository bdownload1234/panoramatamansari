  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Pengaturan Password</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard'); ?>">Home</a></li>
              <li class="breadcrumb-item active">Password</li>
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
          <h3 class="card-title">Ubah Password</h3>
        </div>

        <!-- /.card-header -->
        <div class="card-body">

            <form id="form">
                <input type="hidden" name="id" value="<?php echo $pengguna[0]['id'] ?>">
              <div class="form-group row">
                <label class="col-sm-3 control-label">New Password </label>
                <div class="col-md-5">
                  <div class="input-group mb-3">
                      <input name="password" type="password" class="form-control" id="password" value="">
                      <div class="input-group-append">
                        <span class="input-group-text" onclick="password_show_hide();">
                          <i class="fas fa-eye" id="show_eye"></i>
                          <i class="fas fa-eye-slash d-none" id="hide_eye"></i>
                        </span>
                      </div>
                    </div>
                  <span class="help-block"></span>
                </div>
              </div>
              
            </form>
              <button type="button" class="btn btn-primary" id="btnSave">Save</button>

        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </section>
    
<?php  $this->load->view('template/footer'); ?>



<script type="text/javascript">
function password_show_hide() {
  var x = document.getElementById("password");
  var show_eye = document.getElementById("show_eye");
  var hide_eye = document.getElementById("hide_eye");
  hide_eye.classList.remove("d-none");
  if (x.type === "password") {
    x.type = "text";
    show_eye.style.display = "none";
    hide_eye.style.display = "block";
  } else {
    x.type = "password";
    show_eye.style.display = "block";
    hide_eye.style.display = "none";
  }
}
    $('#btnSave').on('click', function(){
        if($('#password').val() == ''){
            alert('Password is required!');
        }else{
            // ajax adding data to database
           $.ajax({
               url : "<?php echo site_url($data_ref['uri_controllers'].'/ubah')?>",
               type: "POST",
               data: $('#form').serialize(),
               dataType: "JSON",
               success: function(data)
               {
        
                   if(data.status) //if success close modal and reload ajax table
                   {
                       location.reload(true)
                       Lobibox.notify('success', {
                           size: 'mini',
                           msg: 'Data berhasil Disimpan'
                       });
                   }
                   else
                   {
                       alert('Error')
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
    })
</script>