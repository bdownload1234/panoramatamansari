<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

        <div class="container">
<br>
<section class="content">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Form Registrasi</h4>
        </div>

        <!-- /.card-header -->
        <div class="card-body">
            <center>
                <b>PANORAMA TAMANSARI</b>
                <br>
                <br>
                Registrasi atas nama :<br>
                <b><?=$nama;?></b><br>
                Telah kami terima, kami akan segera memproses permohonan anda.
                <br> 
                <br> 
                <br>
                <b>ADMIN PANORAMA TAMANSARI</b> 
            </center>
            
        </div>
      </div>
</section>
        </div>


<?php  $this->load->view('template/footer_kosong'); ?>

<script type="text/javascript">

  $(document).ready(function() {

    var url = "<?php echo base_url(); ?>";
    setTimeout(function() {
      $.ajax({
                url : url + "reg/ajax_kirim/",
                type: "POST",
                dataType: "JSON",
                success: function(data)
                {
                  // alert('Periksa pesan WhtsApp');
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Gagal mengirim pesan');
                }
            });
      }, 1500); // Menunda eksekusi selama 3 detik (3000 milidetik)

  });


  </script>
</body>
</html>
