  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard Pembelian</h1>
          </div>
        </div>
      </div>
    </div> -->
    <!-- /.content-header -->



  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->

      <div class="row">
        <div class="col-lg-8 col-12">
  <!-- <a href="<?=base_url('dashboard/cetak');?>" target="_blank" class="btn btn-info btn-sm">Cetak Denah</a>
  <a href="<?=base_url('dashboard/cetak_rekap');?>" target="_blank" class="btn btn-warning btn-sm">Cetak Rencana Penagihan</a> -->

<!-- <br> -->
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
        HOLD
    </div>
    <div class="legend-item">
        <div class="legend-color" style="background-color: #00a123;"></div>
        AVAILALBE
    </div>
    <div class="legend-item">
        <div class="legend-color" style="background-color: #f5bc4c;"></div>
        NUP
    </div>
    <div class="legend-item">
        <div class="legend-color" style="background-color: #fc5012;"></div>
        TERBOOKING
    </div>
    <div class="legend-item">
        <div class="legend-color" style="background-color: #418bf2;"></div>
        SUDAH AKAD
    </div>
    <div class="legend-item">
        <div class="legend-color" style="background-color: #92969c;"></div>
        STANDART
    </div>
    <div class="legend-item">
        <div class="legend-color" style="background-color: #ff38d1;"></div>
        KHUSUS
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
                            <label class="control-label col-md-3">Lokasi Kavling</label>
                            <div class="col-md-3">
                                <input name="kode" class="form-control" type="text" readonly>
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
                            <label class="control-label col-md-3">Tipe Bangunan</label>
                            <div class="col-md-4">
                                <input name="tipe_bangunan" placeholder="" class="form-control" type="text" readonly>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Harga Jual</label>
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

                        <hr>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Nama Pembeli</label>
                            <div class="col-md-4">
                                <input name="nama_lengkap" placeholder="" class="form-control" type="text" id="nama_lengkap" readonly>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Nama Marketing</label>
                            <div class="col-md-4">
                                <input name="nama_marketing" placeholder="" class="form-control" type="text" id="nama_marketing" readonly>
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
               $('[name="tipe_bangunan"]').val(data.tipe_bangunan);
               $('[name="luas"]').val(data.luas_tanah);
               $('[name="harga_jual"]').val(data.harga_jual);
               $('[name="nama_marketing"]').val(data.nama_marketing);
               $('[name="nama_lengkap"]').val(data.nama_lengkap);
               
               if(data.stt_kavling == '0'){
                  $('[name="status"]').val('HOLD');
               }else if(data.stt_kavling == '1'){
                  $('[name="status"]').val('AVAIABLE');
               }else if(data.stt_kavling == '2'){
                  $('[name="status"]').val('NUP');
               }else if(data.stt_kavling == '3'){
                  $('[name="status"]').val('TERBOOKING');
               }else if(data.stt_kavling == '4'){
                  $('[name="status"]').val('SUDAH AKAD');
               }else if(data.stt_kavling == '5'){
                  $('[name="status"]').val('STANDART');
               }else if(data.stt_kavling == '6'){
                  $('[name="status"]').val('KHUSUS');
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
