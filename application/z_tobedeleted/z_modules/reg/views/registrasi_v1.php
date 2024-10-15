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
            <form action="<?=base_url('reg/save');?>" method="POST" enctype="multipart/form-data">

            <div class="form-group row">
                <label for="nama_lengkap" class="col-sm-2 col-form-label">Nama Lengkap</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="tempat_lahir" class="col-sm-2 col-form-label">Tempat Lahir</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="tanggal_lahir" class="col-sm-2 col-form-label">Tanggal Lahir</label>
                <div class="col-sm-4">
                    <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
                </div>
            </div>
            <div class="form-group row">
            <label for="jenis_kelamin" class="col-sm-2 col-form-label">Jenis Kelamin</label>
            <div class="col-sm-4">
                <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
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
                <input type="text" class="form-control" id="alamat" name="alamat" required>
            </div>
        </div>

        <div class="form-group row">
            <label for="foto_ktp" class="col-sm-2 col-form-label">Foto KTP</label>
            <div class="col-sm-10">
                <input type="file" class="form-control-file" id="foto_ktp" name="foto_ktp" accept="image/*" capture="camera" />
                <!-- <input type="file" class="form-control-file" id="foto_ktp" name="foto_ktp" accept="image/*" required> -->
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
                <input type="file" class="form-control-file" id="foto_npwp" name="foto_npwp" accept="image/*" capture="camera" required>
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
                <input type="file" class="form-control-file" id="foto_kk" name="foto_kk" accept="image/*" capture="camera" required>
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
            <label for="foto_bpjs" class="col-sm-2 col-form-label">Foto BPJS</label>
            <div class="col-sm-10">
                <input type="file" class="form-control-file" id="foto_bpjs" name="foto_bpjs" accept="image/*" capture="camera" required>
            </div>
        </div>

        <!-- Foto Selfie -->
        <div class="form-group row">
            <label for="foto_selfie" class="col-sm-2 col-form-label">Foto Selfie</label>
            <div class="col-sm-10">
                <input type="file" class="form-control-file" id="foto_selfie" name="foto_selfie" accept="image/*" capture="camera" required>
            </div>
        </div>

        <!-- Foto Customer -->
        <div class="form-group row">
            <label for="foto_customer" class="col-sm-2 col-form-label">Foto Customer</label>
            <div class="col-sm-10">
                <input type="file" class="form-control-file" id="foto_customer" name="foto_customer" accept="image/*" capture="camera" required>
            </div>
        </div>

        <!-- Anggaran DP -->
        <div class="form-group row">
            <label for="anggaran_dp" class="col-sm-2 col-form-label">Anggaran DP</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="anggaran_dp" name="anggaran_dp" required>
            </div>
        </div>

        <!-- Booking Fee -->
        <div class="form-group row">
            <label for="booking_fee" class="col-sm-2 col-form-label">Booking Fee</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="booking_fee" name="booking_fee" required>
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
                <input type="tel" class="form-control" id="no_telp" name="no_telp" required>
            </div>
        </div>

        <!-- Nomor Telepon Saudara -->
        <div class="form-group row">
            <label for="no_telp_saudara" class="col-sm-2 col-form-label">Nomor Telepon Saudara</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="no_telp_saudara" name="no_telp_saudara" required>
            </div>
        </div>

        <!-- Lokasi Kavling -->
        <div class="form-group row">
            <label for="lokasi_kavling" class="col-sm-2 col-form-label">Lokasi Kavling</label>
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

        <!-- Status Kepemilikan -->
        <div class="form-group row">
            <label for="status_kepemilikan" class="col-sm-2 col-form-label">Status Kepemilikan</label>
            <div class="col-sm-3">
                <select class="form-control" id="status_kepemilikan" name="status_kepemilikan" required>
                    <option>-</option>
                    <option value="Pemilik Rumah">Pemilik Rumah</option>
                    <option value="Penyewa">Penyewa</option>
                    <option value="Calon Pembeli Pertama">Calon Pembeli Pertama</option>
                </select>
            </div>
        </div>

        <!-- Pekerjaan -->
        <div class="form-group row">
            <label for="pekerjaan" class="col-sm-2 col-form-label">Pekerjaan</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="pekerjaan" name="pekerjaan" required>
            </div>
        </div>


        <!-- Pendapatan Bulanan -->
        <div class="form-group row">
            <label for="pendapatan_bulanan" class="col-sm-2 col-form-label">Pendapatan Bulanan</label>
            <div class="col-sm-2">
                <input type="text" class="form-control" id="pendapatan_bulanan" name="pendapatan_bulanan" required>
            </div>
        </div>

        <!-- Jumlah Anggota Keluarga -->
        <div class="form-group row">
            <label for="jumlah_anggota_keluarga" class="col-sm-2 col-form-label">Jumlah Anggota Keluarga</label>
            <div class="col-sm-2">
                <select class="form-control" id="jumlah_anggota_keluarga" name="jumlah_anggota_keluarga" required>
                    <option>-</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                </select>
            </div>
        </div>

        <!-- Status Perkawinan -->
        <div class="form-group row">
            <label for="status_perkawinan" class="col-sm-2 col-form-label">Status Perkawinan</label>
            <div class="col-sm-3">
                <select class="form-control" id="status_perkawinan" name="status_perkawinan" required>
                    <option>-</option>
                    <option value="Singel">Singel</option>
                    <option value="Menikah">Menikah</option>
                    <option value="Cerai">Cerai</option>
                    <option value="Duda / Janda">Duda / Janda</option>
                </select>
            </div>
        </div>

        <!-- Waktu Pemindahan -->
        <div class="form-group row">
            <label for="waktu_pemindahan" class="col-sm-2 col-form-label">Waktu Pemindahan</label>
            <div class="col-sm-4">
                 <select class="form-control" id="waktu_pemindahan" name="waktu_pemindahan" required>
                    <option>-</option>
                    <option value="Segera">Segera</option>
                    <option value="Dalam beberapa bulan">Dalam beberapa bulan</option>
                    <option value="Dalam setahun">Dalam setahun</option>
                </select>
            </div>
        </div>

        <!-- Pilihan Investasi -->
        <div class="form-group row">
            <label for="pilihan_investasi" class="col-sm-2 col-form-label">Pilihan Investasi</label>
            <div class="col-sm-4">
                <select class="form-control" id="pilihan_investasi" name="pilihan_investasi" required>
                    <option>-</option>
                    <option value="Tempat Tinggal">Tempat Tinggal</option>
                    <option value="Investasi">Investasi</option>
                </select>
            </div>
        </div>

        <!-- Pengalaman Membeli Rumah -->
        <div class="form-group row">
            <label for="pengalaman_membeli_rumah" class="col-sm-2 col-form-label">Pengalaman Membeli Rumah</label>
            <div class="col-sm-3">
                <select class="form-control" id="pengalaman_membeli_rumah" name="pengalaman_membeli_rumah" required>
                    <option>-</option>
                    <option value="Sudah pernah membeli rumah sebelumnya">Sudah pernah membeli rumah sebelumnya</option>
                    <option value="Pembelian Pertama">Pembelian Pertama</option>
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
                <button type="submit" class="btn btn-primary">Submit</button>
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

<script type="text/javascript">

    $('#anggaran_dp').on('change', function() {
        var myStr = $(this).val();
        var newStr = myStr.replace(/\D/g,'');
        $('#anggaran_dp_int').val(newStr);

    });

    $('#booking_fee').on('change', function() {
        var myStr = $(this).val();
        var newStr = myStr.replace(/\D/g,'');
        $('#booking_fee_int').val(newStr);

    });

    

var harga_jual = document.getElementById('anggaran_dp');
anggaran_dp.addEventListener('keyup', function(e) {
    anggaran_dp.value = formatRupiah(this.value);
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


</script>


</body>
</html>
