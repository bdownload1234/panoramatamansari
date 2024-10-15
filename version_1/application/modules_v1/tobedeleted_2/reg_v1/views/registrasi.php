<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<style>
    body {
        background-image: url('<?php echo base_url("assets/gedung_property.png"); ?>');
        background-attachment: fixed;
        background-size: cover; /* Atur ukuran gambar latar belakang */
    }
</style>
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
            <form method="POST" enctype="multipart/form-data" id="myForm">

            <div class="form-group row">
                <label for="nama_lengkap" class="col-sm-2 col-form-label">Nama Lengkap</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" required>
                </div>
            </div>

        <div class="form-group row">
            <label for="nik" class="col-sm-2 col-form-label">NIK</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="nik" name="nik" required>
            </div>
        </div>


        <div class="form-group row">
            <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="alamat" name="alamat" required onfocus="next()">
            </div>
        </div>

        <div class="form-group row">
            <label for="foto_ktp" class="col-sm-2 col-form-label">Foto KTP</label>
            <div class="col-sm-10">
                <input type="file" class="form-control-file" id="foto_ktp" name="foto_ktp" accept="image/*" capture="camera" />
            </div>
        </div>

        <!-- NPWP -->
        <div class="form-group row">
            <label for="npwp" class="col-sm-2 col-form-label">NPWP</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="npwp" name="npwp" required>
            </div>
        </div>

        <!-- Foto NPWP -->
        <div class="form-group row">
            <label for="foto_npwp" class="col-sm-2 col-form-label">Foto NPWP</label>
            <div class="col-sm-10">
                <input type="file" class="form-control-file" id="foto_npwp" name="foto_npwp" accept="image/*" capture="camera" >
            </div>
        </div>

         <!-- Kartu Keluarga -->
         <div class="form-group row">
            <label for="kartu_keluarga" class="col-sm-2 col-form-label">Kartu Keluarga</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="kartu_keluarga" name="kartu_keluarga" required>
            </div>
        </div>

        <!-- Foto KK -->
        <div class="form-group row">
            <label for="foto_kk" class="col-sm-2 col-form-label">Foto Kartu Keluarga</label>
            <div class="col-sm-10">
                <input type="file" class="form-control-file" id="foto_kk" name="foto_kk" accept="image/*" capture="camera" >
            </div>
        </div>

        <!-- BPJS TK -->
        <div class="form-group row">
            <label for="bpjs_tk" class="col-sm-2 col-form-label">BPJS TK</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="bpjs_tk" name="bpjs_tk" required>
            </div>
        </div>

        <!-- Foto BPJS -->
        <div class="form-group row">
            <label for="foto_bpjs" class="col-sm-2 col-form-label">Foto BPJS TK</label>
            <div class="col-sm-10">
                <input type="file" class="form-control-file" id="foto_bpjs" name="foto_bpjs" accept="image/*" capture="camera" >
            </div>
        </div>


        <!-- Foto SUAMI -->
        <div class="form-group row">
            <label for="foto_ktp_suami" class="col-sm-2 col-form-label">Foto KTP Suami</label>
            <div class="col-sm-10">
                <input type="file" class="form-control-file" id="foto_ktp_suami" name="foto_ktp_suami" accept="image/*" capture="camera" >
            </div>
        </div>

        <!-- Foto ISTRI -->
        <div class="form-group row">
            <label for="foto_ktp_istri" class="col-sm-2 col-form-label">Foto KTP Istri</label>
            <div class="col-sm-10">
                <input type="file" class="form-control-file" id="foto_ktp_istri" name="foto_ktp_istri" accept="image/*" capture="camera" >
            </div>
        </div>

        <!-- Foto Selfie -->
        <div class="form-group row">
            <label for="foto_calon_pemilik" class="col-sm-2 col-form-label">Foto Calon Pemilik Rumah</label>
            <div class="col-sm-10">
                <input type="file" class="form-control-file" id="foto_calon_pemilik" name="foto_calon_pemilik" accept="image/*" capture="camera" >
            </div>
        </div>

            <hr>



        <div class="form-group row">
            <label for="nama_perusahaan" class="col-sm-2 col-form-label">Nama Perusahaan</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="nama_perusahaan" name="nama_perusahaan" required>
            </div>
        </div>

        <div class="form-group row">
            <label for="alamat_kantor" class="col-sm-2 col-form-label">Alamat Kantor</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="alamat_kantor" name="alamat_kantor" required>
            </div>
        </div>

        <div class="form-group row">
            <label for="telp_kantor" class="col-sm-2 col-form-label">Telp Kantor</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="telp_kantor" name="telp_kantor" required>
            </div>
        </div>


        <hr>

        <!-- Booking Fee -->
        <div class="form-group row">
            <label for="booking_fee" class="col-sm-2 col-form-label">Booking Fee</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="booking_fee" name="booking_fee" required>
            </div>
        </div>

        <div class="form-group row">
            <label for="bukti_transfer" class="col-sm-2 col-form-label">Bukti Transfer</label>
            <div class="col-sm-10">
                <input type="file" class="form-control-file" id="bukti_transfer" name="bukti_transfer" accept="image/*" />
            </div>
        </div>

        <!-- Nama Marketing -->
        <div class="form-group row">
            <label for="nama_marketing" class="col-sm-2 col-form-label">Nama Marketing</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="nama_marketing" name="nama_marketing" required>
            </div>
        </div>

        <!-- Email -->
        <div class="form-group row">
            <label for="email" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-6">
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
        </div>

        <!-- Nomor Telepon -->
        <div class="form-group row">
            <label for="no_telp" class="col-sm-2 col-form-label">Nomor Telepon</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="no_telp" name="no_telp" required>
            </div>
        </div>

        <!-- Nomor Telepon Saudara -->
        <div class="form-group row">
            <label for="nama_saudara" class="col-sm-2 col-form-label">Nama Saudara tidak serumah</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="nama_saudara" name="nama_saudara" required>
            </div>
        </div>

        <div class="form-group row">
            <label for="no_telp_saudara" class="col-sm-2 col-form-label">Nomor Telepon Saudara Tidak Serumah</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="no_telp_saudara" name="no_telp_saudara" required>
            </div>
        </div>

        <!-- Lokasi Kavling -->
        <div class="form-group row">
            <label for="lokasi_kavling" class="col-sm-2 col-form-label">Lokasi Unit Rumah</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="lokasi_kavling" name="lokasi_kavling" required>
            </div>
        </div>

        <!-- Tipe Unit -->
        <div class="form-group row">
            <label for="tipe_unit" class="col-sm-2 col-form-label">Tipe Unit</label>
            <div class="col-sm-3">
                <select class="form-control" id="tipe_unit" name="tipe_unit" required>
                    <option>-</option>
                    <option value="36">Tipe 36</option>
                    <option value="45">Tipe 45</option>
                    <option value="60">Tipe 60</option>
                    <option value="90">Tipe 90</option>
                    <option value="120">Tipe 120</option>
                </select>
            </div>
        </div>

     
        <!-- Pengalaman Interaksi -->
        <div class="form-group row">
            <label for="pengalaman_interaksi" class="col-sm-2 col-form-label">Pengalaman Interaksi</label>
            <div class="col-sm-3">
                <select class="form-control" id="pengalaman_interaksi" name="pengalaman_interaksi" required>
                    <option>-</option>
                    <option value="Iklan">Iklan</option>
                    <option value="Referensi Teman">Referensi Teman</option>
                    <option value="Media Sosial">Media Sosial</option>
                    <option value="Sumber Lainnya">Sumber Lainnya</option>
                </select>
            </div>
        </div>


        <div class="form-group row">
            <label for="persetujuan" class="col-sm-2 col-form-label">Persetujuan</label>
            <div class="col-sm-10">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="persetujuan" name="persetujuan" required>
                    <label class="form-check-label" for="persetujuan">
                        Saya menyetujui syarat dan ketentuan yang berlaku.
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-10 offset-sm-2">
                <button id="submitButton" class="btn btn-primary">Kirim Data</a>
            </div>
        </div>



        

    </form>
</div>

<!-- Include Bootstrap JS (optional) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>

<script src="<?php echo base_url('theme_admin/plugins/select2/select2.min.js')?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('theme_admin/plugins/select2/select2.css') ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('theme_admin/plugins/select2/select2-bootstrap.css') ?>">

<script type="text/javascript">
var url_apps = "<?=base_url();?>";
$(document).ready(function () {
    $("#detail").hide();
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
    // alert(data.kode_kavling);
    // $("#nama_cust").val(data.nama_lengkap);    
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

<script type="text/javascript">


    $('#booking_fee').on('change', function() {
        var myStr = $(this).val();
        var newStr = myStr.replace(/\D/g,'');
        $('#booking_fee_int').val(newStr);

    });


var harga_jual = document.getElementById('booking_fee');
booking_fee.addEventListener('keyup', function(e) {
    booking_fee.value = formatRupiah(this.value);
});

    
/* Fungsi */
function formatRupiah(bilangan, prefix) {
var number_string = bilangan.replace(/[^,\d]/g, '').toString(),
  split = number_string.split(','),
  sisa = split[0].length % 3,
  rupiah = split[0].substr(0, sisa),
  ribuan = split[0].substr(sisa).match(/\d{1,3}/gi);

if (ribuan) {
  separator = sisa ? '.' : '';
  rupiah += separator + ribuan.join('.');
}

rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
}

function limitCharacter(event) {
  key = event.which || event.keyCode;
  if (key != 188 // Comma
    &&
    key != 8 // Backspace
    &&
    key != 17 && key != 86 & key != 67 // Ctrl c, ctrl v
    &&
    (key < 48 || key > 57) // Non digit
    // Dan masih banyak lagi seperti tombol del, panah kiri dan kanan, tombol tab, dll
  ) {
    event.preventDefault();
    return false;
  }
}



$(document).ready(function() {
    
    // --- upload KTP ------------------------------------------------------------------------------>>>
    $('#foto_ktp').on('change', function() {
        var nik = document.getElementById('nik').value;
        var formData = new FormData();
        formData.append('foto_ktp', $('#foto_ktp')[0].files[0]);
        var linkurl = '<?=base_url();?>';
        $.ajax({
            url: linkurl + 'reg/do_upload_ktp/' + nik, // Sesuaikan dengan URL route yang Anda tentukan
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                console.log(response); // Tanggapan dari server
                // Lakukan tindakan lain sesuai kebutuhan
            },
            error: function(xhr, status, error) {
                console.error(error); // Tampilkan error jika terjadi masalah
            }
        });
    });


    // --- upload NPWP ------------------------------------------------------------------------------>>>
    $('#foto_npwp').on('change', function() {
        var nik = document.getElementById('nik').value;
        var formData = new FormData();
        formData.append('foto_npwp', $('#foto_npwp')[0].files[0]);
        var linkurl = '<?=base_url();?>';
        $.ajax({
            url: linkurl + 'reg/do_upload_npwp/' + nik, // Sesuaikan dengan URL route yang Anda tentukan
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                console.log(response); // Tanggapan dari server
                // Lakukan tindakan lain sesuai kebutuhan
            },
            error: function(xhr, status, error) {
                console.error(error); // Tampilkan error jika terjadi masalah
            }
        });
    });

    // --- upload Foto KK ------------------------------------------------------------------------------>>>
    $('#foto_kk').on('change', function() {
        var nik = document.getElementById('nik').value;
        var formData = new FormData();
        formData.append('foto_kk', $('#foto_kk')[0].files[0]);
        var linkurl = '<?=base_url();?>';
        $.ajax({
            url: linkurl + 'reg/do_upload_kk/' + nik, // Sesuaikan dengan URL route yang Anda tentukan
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                console.log(response); // Tanggapan dari server
                // Lakukan tindakan lain sesuai kebutuhan
            },
            error: function(xhr, status, error) {
                console.error(error); // Tampilkan error jika terjadi masalah
            }
        });
    });

    // --- upload Foto BPJS ------------------------------------------------------------------------------>>>
    $('#foto_bpjs').on('change', function() {
        var nik = document.getElementById('nik').value;
        var formData = new FormData();
        formData.append('foto_bpjs', $('#foto_bpjs')[0].files[0]);
        var linkurl = '<?=base_url();?>';
        $.ajax({
            url: linkurl + 'reg/do_upload_bpjs/' + nik, // Sesuaikan dengan URL route yang Anda tentukan
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                console.log(response); // Tanggapan dari server
                // Lakukan tindakan lain sesuai kebutuhan
            },
            error: function(xhr, status, error) {
                console.error(error); // Tampilkan error jika terjadi masalah
            }
        });
    });

    // --- upload KTP Suami ------------------------------------------------------------------------------>>>
    $('#foto_ktp_suami').on('change', function() {
        var nik = document.getElementById('nik').value;
        var formData = new FormData();
        formData.append('foto_ktp_suami', $('#foto_ktp_suami')[0].files[0]);
        var linkurl = '<?=base_url();?>';
        $.ajax({
            url: linkurl + 'reg/upload_image_method/' + nik, // Sesuaikan dengan URL route yang Anda tentukan
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                console.log(response); // Tanggapan dari server
                // Lakukan tindakan lain sesuai kebutuhan
            },
            error: function(xhr, status, error) {
                console.error(error); // Tampilkan error jika terjadi masalah
            }
        });
    });

    // --- upload KTP ISTRI ------------------------------------------------------------------------------>>>
    $('#foto_ktp_istri').on('change', function() {
        var nik = document.getElementById('nik').value;
        var formData = new FormData();
        formData.append('foto_ktp_istri', $('#foto_ktp_istri')[0].files[0]);
        var linkurl = '<?=base_url();?>';
        $.ajax({
            url: linkurl + 'reg/do_upload_ktp_istri/' + nik, // Sesuaikan dengan URL route yang Anda tentukan
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                console.log(response); // Tanggapan dari server
                // Lakukan tindakan lain sesuai kebutuhan
            },
            error: function(xhr, status, error) {
                console.error(error); // Tampilkan error jika terjadi masalah
            }
        });
    });


    // --- upload Calon Pemilik ------------------------------------------------------------------------------>>>
    $('#foto_calon_pemilik').on('change', function() {
        var nik = document.getElementById('nik').value;
        var formData = new FormData();
        formData.append('foto_calon_pemilik', $('#foto_calon_pemilik')[0].files[0]);
        var linkurl = '<?=base_url();?>';
        $.ajax({
            url: linkurl + 'reg/do_upload_calon_pemilik/' + nik, // Sesuaikan dengan URL route yang Anda tentukan
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                console.log(response); // Tanggapan dari server
                // Lakukan tindakan lain sesuai kebutuhan
            },
            error: function(xhr, status, error) {
                console.error(error); // Tampilkan error jika terjadi masalah
            }
        });
    });


    // --- upload Bukti Transfer ------------------------------------------------------------------------------>>>
    $('#bukti_transfer').on('change', function() {
        var nik = document.getElementById('nik').value;
        var formData = new FormData();
        formData.append('bukti_transfer', $('#bukti_transfer')[0].files[0]);
        var linkurl = '<?=base_url();?>';
        $.ajax({
            url: linkurl + 'reg/do_upload_bukti_transfer/' + nik, // Sesuaikan dengan URL route yang Anda tentukan
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                console.log(response); // Tanggapan dari server
                // Lakukan tindakan lain sesuai kebutuhan
            },
            error: function(xhr, status, error) {
                console.error(error); // Tampilkan error jika terjadi masalah
            }
        });
    });



});


function next(){
    var namaLengkap = document.getElementById('nama_lengkap').value;
    var nik = document.getElementById('nik').value;

    if (namaLengkap === '' || nik === '') {
        alert('Mohon lengkapi Nama Lengkap dan NIK.');
        $('#nik').focus();
    } else {
        
        // var alamatInput = document.getElementById('alamat');
        // alamatInput.removeAttribute('readonly');
        // Tambahkan kode lanjutan di sini jika inputan telah terisi

        var linkurl = '<?=base_url();?>';
        $.ajax({
            url: linkurl + 'reg/simpan_nik/' + nik, // Sesuaikan dengan URL route yang Anda tentukan
            type: 'POST',
            contentType: false,
            processData: false,
            success: function(response) {
                console.log(response); // Tanggapan dari server
                // Lakukan tindakan lain sesuai kebutuhan
            },
            error: function(xhr, status, error) {
                console.error(error); // Tampilkan error jika terjadi masalah
            }
        });
    }
   }

   $("#submitButton").click(function() {
    var nama_lengkap = $("#nama_lengkap").val();
    var nik = $("#nik").val();
    var alamat = $("#alamat").val();
    url = "<?php echo base_url('reg/ajax_add')?>";

    if (nama_lengkap === '' || nik === '' || alamat === '') {
      alert("Silahkan lengkapi isian.");
      return;
    }

    $.ajax({
      type: "POST",
      url: url, // Ganti dengan URL yang sesuai untuk memproses form
      data: $("#myForm").serialize(),
      success: function(response) {
        // Lakukan tindakan lain setelah pengiriman sukses
        window.location.replace("<?php echo base_url('reg/berhasil/')?>" + nik);
      },
      error: function() {
        alert("Gagal mengirim data.");
      }
    });
  });


  

           
    


</script>


</body>
</html>
