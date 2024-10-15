  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Data Profil</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->




    <!-- Main content -->
    <section class="content">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Data Permohonan</h3>
        </div>

        <!-- /.card-header -->
        <div class="card-body">

        <div class="row">
            <div class="col-lg-7">
            <form action="<?=base_url('registrasi/proses_registrasi');?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" class="form-control" id="id_registrasi" name="id_registrasi" value="<?=$reg['id_registrasi'];?>">

            <input type="hidden" class="form-control" id="foto_ktp" name="foto_ktp" value="<?=$reg['foto_ktp'];?>">
            <input type="hidden" class="form-control" id="foto_npwp" name="foto_npwp" value="<?=$reg['foto_npwp'];?>">
            <input type="hidden" class="form-control" id="foto_kk" name="foto_kk" value="<?=$reg['foto_kk'];?>">
            <input type="hidden" class="form-control" id="foto_bpjs" name="foto_bpjs" value="<?=$reg['foto_bpjs'];?>">
            <input type="hidden" class="form-control" id="foto_ktp_suami" name="foto_ktp_suami" value="<?=$reg['foto_ktp_suami'];?>">
            <input type="hidden" class="form-control" id="foto_ktp_istri" name="foto_ktp_istri" value="<?=$reg['foto_ktp_istri'];?>">
            <input type="hidden" class="form-control" id="foto_calon_pemilik" name="foto_calon_pemilik" value="<?=$reg['foto_calon_pemilik'];?>">
            <input type="hidden" class="form-control" id="bukti_transfer" name="bukti_transfer" value="<?=$reg['bukti_transfer'];?>">

            <div class="form-group row">
                <label for="nama_lengkap" class="col-sm-3 col-form-label">Nama Lengkap</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="<?=$reg['nama_lengkap'];?>" readonly>
                </div>
            </div>
         
        <div class="form-group row">
            <label for="nik" class="col-sm-3 col-form-label">NIK</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="nik" name="nik"  value="<?=$reg['nik'];?>" readonly>
            </div>
        </div>

        <div class="form-group row">
            <label for="alamat" class="col-sm-3 col-form-label">Alamat</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="alamat" name="alamat"  value="<?=$reg['alamat'];?>" readonly>
            </div>
        </div>

        <!-- NPWP -->
        <!--<div class="form-group row">-->
        <!--    <label for="npwp" class="col-sm-3 col-form-label">NPWP</label>-->
        <!--    <div class="col-sm-4">-->
        <!--        <input type="text" class="form-control" id="npwp" name="npwp"  value="<?=$reg['npwp'];?>" readonly>-->
        <!--    </div>-->
        <!--</div>-->

        <!-- Kartu Keluarga -->
        <!--<div class="form-group row">-->
        <!--    <label for="kartu_keluarga" class="col-sm-3 col-form-label">Kartu Keluarga</label>-->
        <!--    <div class="col-sm-4">-->
        <!--        <input type="text" class="form-control" id="kartu_keluarga" name="kartu_keluarga"  value="<?=$reg['kartu_keluarga'];?>" readonly>-->
        <!--    </div>-->
        <!--</div>-->

        <!-- BPJS TK -->
        <!--<div class="form-group row">-->
        <!--    <label for="bpjs_tk" class="col-sm-3 col-form-label">BPJS TK</label>-->
        <!--    <div class="col-sm-4">-->
        <!--        <input type="text" class="form-control" id="bpjs_tk" name="bpjs_tk"  value="<?=$reg['bpjs_tk'];?>" readonly>-->
        <!--    </div>-->
        <!--</div>-->

        <!-- Booking Fee -->
        <div class="form-group row">
            <label for="booking_fee" class="col-sm-3 col-form-label">Booking Fee</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="booking_fee" name="booking_fee"  value="<?=rupiah($reg['booking_fee']);?>" readonly>
            </div>
        </div>

        <!-- Nama Marketing -->
        <div class="form-group row">
            <label for="nama_marketing" class="col-sm-3 col-form-label">Nama Marketing</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="nama_marketing" name="nama_marketing"  value="<?=$reg['nama_marketing'];?>" readonly>
            </div>
        </div>

        <!-- Email -->
        <div class="form-group row">
            <label for="email" class="col-sm-3 col-form-label">Email</label>
            <div class="col-sm-6">
                <input type="email" class="form-control" id="email" name="email"  value="<?=$reg['email'];?>" readonly>
            </div>
        </div>

        <!-- Nomor Telepon -->
        <div class="form-group row">
            <label for="no_telp" class="col-sm-3 col-form-label">Nomor Telepon</label>
            <div class="col-sm-4">
                <input type="tel" class="form-control" id="no_telp" name="no_telp"  value="<?=$reg['no_telp'];?>" readonly>
            </div>
        </div>

        <!-- Nomor Telepon Saudara -->
        <div class="form-group row">
            <label for="nama_saudara" class="col-sm-3 col-form-label">Nama Saudara Tidak Serumah</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="nama_saudara" name="nama_saudara"  value="<?=$reg['nama_saudara'];?>" readonly>
            </div>
        </div>
        
         <div class="form-group row">
            <label for="hubungan_saudara" class="col-sm-3 col-form-label">Hubungan Saudara</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="hubungan_saudara" name="hubungan_saudara"  value="<?=$reg['hubungan_saudara'];?>" readonly>
            </div>
        </div>

        <div class="form-group row">
            <label for="no_telp_saudara" class="col-sm-3 col-form-label">Nomor Telepon Saudara</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="no_telp_saudara" name="no_telp_saudara"  value="<?=$reg['no_telp_saudara'];?>" readonly>
            </div>
        </div>

        <!-- Lokasi Kavling -->
        <div class="form-group row">
            <label for="lokasi_kavling" class="col-sm-3 col-form-label">Lokasi Kavling</label>
            <div class="col-sm-3">
                <!-- <input type="text" class="form-control" id="lokasi_kavling" name="lokasi_kavling"> -->
                <input type="text" class="form-control" id="lokasi_kavling_text" name="lokasi_kavling_text" value="<?=$reg['lokasi_kavling'];?>" readonly>
                <input type="hidden" class="form-control" id="lokasi_kavling_id" name="lokasi_kavling_id" value="<?=$reg['lokasi_kavling'];?>">
            </div>
        </div>

        <!-- Tipe Unit -->
        <div class="form-group row">
            <label for="lokasi_kavling" class="col-sm-3 col-form-label">Tipe Unit</label>
            <div class="col-sm-3">
                <!-- <input type="text" class="form-control" id="lokasi_kavling" name="lokasi_kavling"> -->
                <input type="text" class="form-control" id="tipe_unit" name="tipe_unit" value="<?=$reg['tipe_unit'];?>" readonly>
            </div>
        </div>


        <!-- Pengalaman Interaksi -->
        <div class="form-group row">
            <label for="pengalaman_interaksi" class="col-sm-3 col-form-label">Pengalaman Interaksi</label>
            <div class="col-sm-3">
                <select class="form-control" id="pengalaman_interaksi" name="pengalaman_interaksi" disabled>
                    <option>-</option>
                    <option <?php if ($reg['pengalaman_interaksi'] == 'Iklan') echo 'selected'; ?> value="Iklan">Iklan</option>
                    <option <?php if ($reg['pengalaman_interaksi'] == 'Referensi Teman') echo 'selected'; ?> value="Referensi Teman">Referensi Teman</option>
                    <option <?php if ($reg['pengalaman_interaksi'] == 'Media Sosial') echo 'selected'; ?> value="Media Sosial">Media Sosial</option>
                    <option <?php if ($reg['pengalaman_interaksi'] == 'Sumber Lainnya') echo 'selected'; ?> value="Sumber Lainnya">Sumber Lainnya</option>
                </select>
            </div>
        </div>

    </form>

            </div>


            <div class="col-lg-5">
                <div class="row">
                    <div class="col-lg-4">
                        <h6>FOTO KTP</h6>
                        <img src="<?=base_url('lampiran_registrasi/'.$reg['foto_ktp']);?>" alt="" width="100%">
                    </div>

                    <div class="col-lg-4">
                        <h6>FOTO NPWP</h6>
                        <img src="<?=base_url('lampiran_registrasi/'.$reg['foto_npwp']);?>" alt="" width="100%">
                    </div>

                    <div class="col-lg-4">
                        <h6>FOTO KK</h6>
                        <img src="<?=base_url('lampiran_registrasi/'.$reg['foto_kk']);?>" alt="" width="100%">
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-lg-4">
                        <h6>FOTO BPJS</h6>
                        <img src="<?=base_url('lampiran_registrasi/'.$reg['foto_bpjs']);?>" alt="" width="100%">
                    </div>

                    <div class="col-lg-4">
                        <h6>KTP PASANGAN</h6>
                        <img src="<?=base_url('lampiran_registrasi/'.$reg['foto_ktp_istri']);?>" alt="" width="100%">
                    </div>

                    <div class="col-lg-4">
                        <h6>CALON PEMILIK</h6>
                        <img src="<?=base_url('lampiran_registrasi/'.$reg['foto_calon_pemilik']);?>" alt="" width="100%">
                    </div>
                </div>

                <hr>

                 <div class="row">
                    <!--<div class="col-lg-4">-->
                    <!--    <h6>FOTO CALON PEMILIK</h6>-->
                    <!--    <img src="<?=base_url('lampiran_registrasi/'.$reg['foto_calon_pemilik']);?>" alt="" width="100%">-->
                    <!--</div>-->

                    <div class="col-lg-4">
                        <h6>BUKTI TRANSFER</h6>
                        <img src="<?=base_url('lampiran_registrasi/'.$reg['bukti_transfer']);?>" alt="" width="100%">
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

