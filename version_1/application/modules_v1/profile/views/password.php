  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Ganti Password</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->




    <!-- Main content -->
    <section class="content">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Ganti Password Pengguna</h3>
        </div>

        <!-- /.card-header -->
        <div class="card-body">

        <div class="row">
            <div class="col-lg-7">
            
            <form id="passwordForm" onsubmit="return validateForm()" action="<?=base_url('profile/gantipassword');?>" method="POST">
                <div class="form-group row">
                    <label for="password" class="col-sm-3 col-form-label">Password</label>
                    <div class="col-sm-4">
                        <input type="password" class="form-control" id="password" name="password" value="">
                        <small class="form-text text-muted">
                            <input type="checkbox" onclick="togglePasswordVisibility('password')"> Show Password
                        </small>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="re_password" class="col-sm-3 col-form-label">Ulangi Password</label>
                    <div class="col-sm-4">
                        <input type="password" class="form-control" id="re_password" name="re_password" value="">
                        <small class="form-text text-muted">
                            <input type="checkbox" onclick="togglePasswordVisibility('re_password')"> Show Password
                        </small>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-4 offset-sm-3">
                        <button type="submit" class="btn btn-primary">Ganti Password</button>
                    </div>
                </div>
            </form>


            </div>
        </div>
            
            
</div>


<?php  $this->load->view('template/footer'); ?>
<script>
        function validateForm() {
            const password = document.getElementById("password").value;
            const rePassword = document.getElementById("re_password").value;

            if (password !== rePassword) {
                alert("Password harus sama pada kedua kolom.");
                return false;
            }

            if (password.length < 8 || !/[A-Za-z]/.test(password) || !/\d/.test(password)) {
                alert("Password harus minimal 8 karakter dan mengandung kombinasi huruf dan angka.");
                return false;
            }

            return true;
        }

        function togglePasswordVisibility(inputId) {
            const inputElement = document.getElementById(inputId);
            if (inputElement.type === "password") {
                inputElement.type = "text";
            } else {
                inputElement.type = "password";
            }
        }
    </script>