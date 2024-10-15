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
          <h3 class="card-title">Berhasil</h3>
        </div>

        <!-- /.card-header -->
        <div class="card-body">

        <div class="row">
            <div class="col-lg-7">
            
            <div class="alert alert-success" role="alert">
                Password telah berhasil dirubah.
                </div>


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