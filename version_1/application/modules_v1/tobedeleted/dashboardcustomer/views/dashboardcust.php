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
                            <label class="control-label col-md-3">Kode Kavling</label>
                            <div class="col-md-3">
                                <input name="kode" class="form-control" type="text" readonly>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Panjang Kanan</label>
                            <div class="col-md-2">
                                <input name="panjang_kanan" class="form-control" type="text" readonly>
                                <span class="help-block"></span>
                            </div>
                            <label class="control-label col-md-2">Panjang Kiri</label>
                            <div class="col-md-2">
                                <input name="panjang_kiri" class="form-control" type="text" readonly>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Lebar Depan</label>
                            <div class="col-md-2">
                                <input name="lebar_depan" class="form-control" type="text" readonly>
                                <span class="help-block"></span>
                            </div>
                            <label class="control-label col-md-2">Lebar Belakang</label>
                            <div class="col-md-2">
                                <input name="lebar_belakang" class="form-control" type="text" readonly>
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
