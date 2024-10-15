  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Data Customer</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->




    <!-- Main content -->
    <section class="content">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Detail Data Customer</h3>
        </div>

        <!-- /.card-header -->
        <div class="card-body">

        <div class="row">
            <div class="col-lg-7">
            <form action="<?=base_url('customer/update_data');?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" class="form-control" id="id_customer" name="id_customer" value="<?=$cust['idCust'];?>">


            <div class="form-group row">
                <label for="nama_lengkap" class="col-sm-3 col-form-label">Nama Lengkap</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="<?=$cust['nama_lengkap'];?>">
                </div>
            </div>
         
        <div class="form-group row">
            <label for="nik" class="col-sm-3 col-form-label">NIK</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="nik" name="nik"  value="<?=$cust['ktp'];?>">
            </div>
        </div>

        <div class="form-group row">
            <label for="alamat" class="col-sm-3 col-form-label">Alamat</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="alamat" name="alamat"  value="<?=$cust['alamat'];?>">
            </div>
        </div>

        <!-- NPWP -->
        <!-- <div class="form-group row">
            <label for="npwp" class="col-sm-3 col-form-label">NPWP</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="npwp" name="npwp"  value="<?=$cust['npwp'];?>">
            </div>
        </div> -->

        <!-- Kartu Keluarga -->
        <!-- <div class="form-group row">
            <label for="kartu_keluarga" class="col-sm-3 col-form-label">Kartu Keluarga</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="kartu_keluarga" name="kartu_keluarga"  value="<?=$cust['kartu_keluarga'];?>">
            </div>
        </div> -->

        <!-- BPJS TK -->
        <!-- <div class="form-group row">
            <label for="bpjs_tk" class="col-sm-3 col-form-label">BPJS TK</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="bpjs_tk" name="bpjs_tk"  value="<?=$cust['bpjs_tk'];?>">
            </div>
        </div> -->

        <!-- Email -->
        <div class="form-group row">
            <label for="email" class="col-sm-3 col-form-label">Email</label>
            <div class="col-sm-6">
                <input type="email" class="form-control" id="email" name="email"  value="<?=$cust['email'];?>">
            </div>
        </div>

        <!-- Nomor Telepon -->
        <div class="form-group row">
            <label for="no_telp" class="col-sm-3 col-form-label">Nomor Telepon</label>
            <div class="col-sm-4">
                <input type="tel" class="form-control" id="no_telp" name="no_telp"  value="<?=$cust['no_telp'];?>">
            </div>
        </div>


        <hr>

        <div class="form-group row">
            <label for="nama_perusahaan" class="col-sm-3 col-form-label">Nama Perusahaan</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="nama_perusahaan" name="nama_perusahaan"  value="<?=$cust['nama_perusahaan'];?>">
            </div>
        </div>

        <div class="form-group row">
            <label for="alamat_kantor" class="col-sm-3 col-form-label">Alamat Kantor</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="alamat_kantor" name="alamat_kantor"  value="<?=$cust['alamat_kantor'];?>">
            </div>
        </div>

        <div class="form-group row">
            <label for="telp_kantor" class="col-sm-3 col-form-label">Telp Kantor</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="telp_kantor" name="telp_kantor"  value="<?=$cust['telp_kantor'];?>">
            </div>
        </div>

        <hr>


        
        <!-- Nomor Telepon Saudara -->
        <div class="form-group row">
            <label for="nama_saudara" class="col-sm-3 col-form-label">Nama Saudara Tidak Serumah</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="nama_saudara" name="nama_saudara"  value="<?=$cust['nama_saudara'];?>">
            </div>
        </div>

        <div class="form-group row">
            <label for="hubungan_saudara" class="col-sm-3 col-form-label">Hubungan Saudara</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="hubungan_saudara" name="hubungan_saudara"  value="<?=$cust['hubungan_saudara'];?>">
            </div>
        </div>

        <div class="form-group row">
            <label for="no_telp_saudara" class="col-sm-3 col-form-label">Nomor Telepon Saudara</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="no_telp_saudara" name="no_telp_saudara"  value="<?=$cust['no_telp_saudara'];?>">
            </div>
        </div>

        <hr>

        

        <!-- Nama Marketing -->
        <div class="form-group row">
            <label for="nama_marketing" class="col-sm-3 col-form-label">Nama Marketing</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="nama_marketing" name="nama_marketing"  value="<?=$cust['nama_marketing'];?>">
            </div>
        </div>

        <!-- Lokasi Kavling -->
        <div class="form-group row">
            <label for="lokasi_kavling" class="col-sm-3 col-form-label">Lokasi Kavling</label>
            <div class="col-sm-3">
                <!-- <input type="text" class="form-control" id="lokasi_kavling" name="lokasi_kavling"> -->
                <input type="text" class="form-control" id="lokasi_kavling_text" name="lokasi_kavling_text" value="<?=$cust['lokasi_kavling'];?>" readonly>
                <input type="hidden" class="form-control" id="lokasi_kavling_id" name="lokasi_kavling_id" value="<?=$cust['id_kavling'];?>">
            </div>
        </div>

        
        <!-- Booking Fee -->
        <div class="form-group row">
            <label for="booking_fee" class="col-sm-3 col-form-label">Booking Fee</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="booking_fee" name="booking_fee"  value="<?=rupiah($cust['booking_fee']);?>" readonly>
            </div>
        </div>

        <!-- Tipe Unit -->
        <div class="form-group row">
            <label for="tipe_unit" class="col-sm-3 col-form-label">Tipe Unit</label>
            <div class="col-sm-3">
            <input type="text" class="form-control" id="tipe_unit" name="tipe_unit"  value="<?=$cust['tipe_unit'];?>" readonly>
                <!-- <select class="form-control" id="tipe_unit" name="tipe_unit" >
                    <option>-</option>
                    <option value="36" <?php if ($cust['tipe_unit'] == '36') echo 'selected'; ?>>Tipe 36</option>
                    <option value="45" <?php if ($cust['tipe_unit'] == '45') echo 'selected'; ?>>Tipe 45</option>
                    <option value="60" <?php if ($cust['tipe_unit'] == '60') echo 'selected'; ?>>Tipe 60</option>
                    <option value="90" <?php if ($cust['tipe_unit'] == '90') echo 'selected'; ?>>Tipe 90</option>
                    <option value="120" <?php if ($cust['tipe_unit'] == '120') echo 'selected'; ?>>Tipe 120</option>
                </select> -->
            </div>
        </div>

        <!-- Pengalaman Interaksi -->
        <div class="form-group row">
            <label for="pengalaman_interaksi" class="col-sm-3 col-form-label">Pengalaman Interaksi</label>
            <div class="col-sm-3">
                <select class="form-control" id="pengalaman_interaksi" name="pengalaman_interaksi" >
                    <option>-</option>
                    <option <?php if ($cust['pengalaman_interaksi'] == 'Iklan') echo 'selected'; ?> value="Iklan">Iklan</option>
                    <option <?php if ($cust['pengalaman_interaksi'] == 'Referensi Teman') echo 'selected'; ?> value="Referensi Teman">Referensi Teman</option>
                    <option <?php if ($cust['pengalaman_interaksi'] == 'Media Sosial') echo 'selected'; ?> value="Media Sosial">Media Sosial</option>
                    <option <?php if ($cust['pengalaman_interaksi'] == 'Sumber Lainnya') echo 'selected'; ?> value="Sumber Lainnya">Sumber Lainnya</option>
                </select>
            </div>
        </div>


        <div class="form-group row">
            <label for="pekerjaan" class="col-sm-3 col-form-label">Password</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="password" name="password" value="">
            </div>
        </div>


        <div class="form-group row">
            <div class="col-sm-10 offset-sm-3">
                <button type="submit" name="submit" class="btn btn-primary">Update Data</button>
            </div>
        </div>

    </form>

            </div>


            <div class="col-lg-5">
                <div class="row">
                    <div class="col-lg-4">
                        <h6>FOTO KTP <a href="<?=base_url('customer/lampiran/'.$cust['foto_ktp']);?>" target="_blank" class="btn btn-info btn-xs float-right"> Download</a></h6>
                        <img src="<?=base_url('lampiran_registrasi/'.$cust['foto_ktp']);?>" alt="" width="100%">
                    </div>

                    <div class="col-lg-4">
                        <h6>FOTO NPWP <a href="<?=base_url('customer/lampiran/'.$cust['foto_npwp']);?>" target="_blank" class="btn btn-info btn-xs float-right"> Download</a></h6>
                        <img src="<?=base_url('lampiran_registrasi/'.$cust['foto_npwp']);?>" alt="" width="100%">
                    </div>

                    <div class="col-lg-4">
                        <h6>FOTO KK <a href="<?=base_url('customer/lampiran/'.$cust['foto_kk']);?>" target="_blank" class="btn btn-info btn-xs float-right"> Download</a></h6>
                        <img src="<?=base_url('lampiran_registrasi/'.$cust['foto_kk']);?>" alt="" width="100%">
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-lg-4">
                        <h6>FOTO BPJS <a href="<?=base_url('customer/lampiran/'.$cust['foto_bpjs']);?>" target="_blank" class="btn btn-info btn-xs float-right"> Download</a></h6>
                        <img src="<?=base_url('lampiran_registrasi/'.$cust['foto_bpjs']);?>" alt="" width="100%">
                    </div>

                    <div class="col-lg-4">
                        <h6>FOTO KTP SUAMI <a href="<?=base_url('customer/lampiran/'.$cust['foto_ktp_suami']);?>" target="_blank" class="btn btn-info btn-xs float-right"> Download</a></h6>
                        <img src="<?=base_url('lampiran_registrasi/'.$cust['foto_ktp_suami']);?>" alt="" width="100%">
                    </div>

                    <div class="col-lg-4">
                        <h6>FOTO KTP ISTRI <a href="<?=base_url('customer/lampiran/'.$cust['foto_ktp_istri']);?>" target="_blank" class="btn btn-info btn-xs float-right"> Download</a></h6>
                        <img src="<?=base_url('lampiran_registrasi/'.$cust['foto_ktp_istri']);?>" alt="" width="100%">
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-lg-4">
                        <h6>FOTO CALON PEMILIK <a href="<?=base_url('customer/lampiran/'.$cust['foto_calon_pemilik']);?>" target="_blank" class="btn btn-info btn-xs float-right"> Download</a></h6>
                        <img src="<?=base_url('lampiran_registrasi/'.$cust['foto_calon_pemilik']);?>" alt="" width="100%">
                    </div>

                    <div class="col-lg-4">
                        <h6>BUKTI TRANSFER <a href="<?=base_url('customer/lampiran/'.$cust['bukti_transfer']);?>" target="_blank" class="btn btn-info btn-xs float-right"> Download</a></h6>
                        <img src="<?=base_url('lampiran_registrasi/'.$cust['bukti_transfer']);?>" alt="" width="100%">
                    </div>

                    <div class="col-lg-4">

                    </div>
                </div>
            </div>
        </div>
            
            
</div>


<?php  $this->load->view('template/footer'); ?>

<!-- Include Bootstrap JS (optional) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>

<script src="<?php echo base_url('theme_admin/plugins/select2/select2.min.js')?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('theme_admin/plugins/select2/select2.css') ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('theme_admin/plugins/select2/select2-bootstrap.css') ?>">

<script type="text/javascript">
var url_apps = "<?=base_url();?>";
$(document).ready(function () {
//----->
//Ambil semua data customer untuk select 2
  $("#lokasi_kavling").select2({
    ajax: {
      url: url_apps + 'reg/ajax_select_kavling',
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

  $('#lokasi_kavling').on('change', function() {
  var idSiswa = $(this).val();
  $.ajax({
    url: url_apps + 'reg/get/' + $(this).val(),
    type: 'GET',
    dataType: 'json',
  })
  .done(function(data) {
    //alert(data.ALAMAT);
    // alert('asd' + data.nama_lengkap);
    $("#nama_cust").val(data.nama_lengkap);

    
  })
  .fail(function() {
    console.log("error");
  })
  .always(function() {
    console.log("complete");
  });
  
});

});

</script>

