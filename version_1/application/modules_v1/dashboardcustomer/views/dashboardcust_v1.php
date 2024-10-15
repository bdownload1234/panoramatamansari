  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard Customer</h1>
            <hr>
          </div>
        </div>
      </div>
    </div>
    <!-- /.content-header -->



  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->

      <div class="row">
        <div class="col-lg-12 col-12">

        <div class="callout callout-info">
            <?php 
            $cust = $this->db->get_where('customer', ['email' => $this->encryption->decrypt($this->session->userdata('email'))])->row_array();
            ?>
                  <h5>Hi, <?=$cust['nama_lengkap'];?></h5>

                  <p>Status proses pembelian rumah anda. <br>
                  <span class="badge badge-warning">Proses Verifikasi</span>
                </p>
                </div>

                <div class="row">
            <div class="col-lg-4"></div>
            <div class="col-lg-4"><img src="<?=base_url('assets/TIPE_MEZANINE .jpg');?>" alt="" width="100%"></div>
            </div>
                

          </div>
        </div>
      </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->






<script type="text/javascript">
   function add(id)
   {
       save_method = 'add';
       $('#form')[0].reset(); // reset form on modals
       $('.form-group').removeClass('has-error'); // clear error class
       $('.help-block').empty(); // clear error string
       $('#modal_form').modal('show'); // show bootstrap modal
       $('.modal-title').text('Detail Kavling' + id); // Set Title to Bootstrap modal title
       $('#photo-preview').hide(); // hide photo preview modal

       //Ajax Load data from ajax
       $.ajax({
           url : "<?php echo site_url('dashboard/ajax_edit/')?>" + id,
           type: "GET",
           dataType: "JSON",
           success: function(data)
           {
               $('[name="kode"]').val(data.kode_kavling);
               $('[name="panjang_kanan"]').val(data.panjang_kanan);
               $('[name="panjang_kiri"]').val(data.panjang_kiri);
               $('[name="lebar_depan"]').val(data.lebar_depan);
               $('[name="lebar_belakang"]').val(data.lebar_belakang);
               $('[name="luas"]').val(data.luas_tanah);
               $('[name="harga_jual"]').val(data.harga_jual);
               $('[name="nama_marketing"]').val(data.nama_marketing);
               $('[name="nama_lengkap"]').val(data.nama_lengkap);
               
               if(data.status == '0'){
                  $('[name="status"]').val('Kosong');
               }else if(data.status == '1'){
                  $('[name="status"]').val('Booking');
               }else if(data.status == '2'){
                  $('[name="status"]').val('Terjual Cash');
               }else if(data.status == '3'){
                  $('[name="status"]').val('Terjual Kredit');
               }else if(data.status == '5'){
                  $('[name="status"]').val('Terjual Kredit # LUNAS');
               }
              
               $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
               $('.modal-title').text('Detail Kavling'); // Set title to Bootstrap modal title
              
           },
           error: function (jqXHR, textStatus, errorThrown)
           {
               alert('Error get data from ajax');
           }
       });
   }


</script>
