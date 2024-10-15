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
$this->load->view('master_svg/denah_spn_2');
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
        <div class="legend-color" style="background-color: #F5BC4C;"></div>
        TERBIT SPK
    </div>
    <div class="legend-item">
        <div class="legend-color" style="background-color: #00a123;"></div>
        100% PEMBANGUNAN
    </div>
    <div class="legend-item">
        <div class="legend-color" style="background-color: #418bf2;"></div>
        SUDAH AKAD
    </div>
    <!--<div class="legend-item">-->
    <!--    <div class="legend-color" style="background-color: #92969c;"></div>-->
    <!--    STANDART-->
    <!--</div>-->
    <!--<div class="legend-item">-->
    <!--    <div class="legend-color" style="background-color: #ff38d1;"></div>-->
    <!--    KHUSUS-->
    <!--</div>-->
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
                            <label class="control-label col-md-3">Model Rumah</label>
                            <div class="col-md-4">
                                <input name="model_rumah" placeholder="" class="form-control" type="text" readonly>
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
                                <!--<input name="status" placeholder="" class="form-control" type="text" readonly>-->
                                <select class="form-control" name="status" id="status">
                                    <option value="0">Terbit SPK</option>
                                    <option value="1">100% Pembangunan</option>
                                    <option value="2">Sudah AKAD</option>
                                </select>
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
                <button type="button" class="btn btn-success" onClick="update()">Update</button>
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
           url : "<?php echo site_url('dashboard_pembangunan/ajax_edit/')?>" + id,
           type: "GET",
           dataType: "JSON",
           success: function(data)
           {
               $('[name="id"]').val(id)
               $('[name="kode"]').val(data.kode_kavling);
               $('[name="tipe_bangunan"]').val(data.tipe_bangunan);
               $('[name="model_rumah"]').val(data.model_rumah);
               $('[name="luas"]').val(data.luas_tanah);
               $('[name="harga_jual"]').val(data.harga_jual);
               $('[name="nama_marketing"]').val(data.nama_marketing);
               $('[name="nama_lengkap"]').val(data.nama_lengkap);
               $('[name="status"]').val(data.status_pembangunan);
               
              
               $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
               $('.modal-title').text('Detail Kavling'); // Set title to Bootstrap modal title
              
           },
           error: function (jqXHR, textStatus, errorThrown)
           {
               alert('Error get data from ajax');
           }
       });
   }
   
   function update(){
        var form = document.getElementById('form'); 
        var formData = new FormData(form); 
        
        $.ajax({ 
            url: "<?php echo site_url('dashboard_pembangunan/ajax_update')?>",
            method: 'POST', 
            data: formData, 
            processData: false, 
            contentType: false, 
            success: function (response) {                       
                alert('Success'); 
                location.reload(true);
            }, 
            error: function (xhr, status, error) {                        
                alert('Error process data'); 
                console.error(error); 
            } 
        }); 
   }


</script>
