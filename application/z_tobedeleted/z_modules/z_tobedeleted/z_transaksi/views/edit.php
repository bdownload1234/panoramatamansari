<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark"><a class="btn" id="btn-custom">Transaksi Pembelian</a></h1>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->




  <!-- Main content -->
  <section class="content">
    <div class="card">

      <!-- /.card-header -->
      <div class="card-body">

        <div class="row">
          <div class="col-md-6">
            <form action="<?= base_url('transaksi/update'); ?>" id="form" class="form-horizontal" method="POST">
              <input type="hidden" value="<?= $kav['id_pembelian'] ?>" name="id" />
              <div class="form-body">

                <div class="form-group row">
                  <label class="control-label col-md-4">Kode Kavling</label>
                  <div class="col-md-8">
                    <input name="kode_kavling" value="<?= $kav['kode_kavling']; ?>" class="form-control" type="text" readonly>
                    <input name="id_kavling" value="<?= $kav['id_kavling']; ?>" class="form-control" type="hidden" readonly>
                    <span class="help-block"></span>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="control-label col-md-4">Harga Jual</label>
                  <div class="col-md-8">
                    <input name="harga_jual" id="harga_jual" class="form-control" type="text" value="<?= rupiah($kav['hrg_jual']); ?>" readonly>
                    <span class="help-block"></span>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="control-label col-md-4">Booking Fee</label>
                  <div class="col-md-8">
                    <input name="book_fee" class="form-control" id="book_fee" type="text" value="<?= rupiah($kav['book_fee']) ?>" readonly>
                    <span class="help-block"></span>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="control-label col-md-4">Tanggal Transaksi</label>
                  <div class="col-md-8">
                    <input name="tanggal" placeholder="" class="form-control" type="date" value="<?= $kav['tgl_pembelian'] ?>" required>
                    <span class="help-block"></span>
                  </div>
                </div>


                <div class="form-group row">
                  <label class="control-label col-md-4">Jenis Transaksi</label>
                  <div class="col-md-8">
                    <select name="jenis" id="jenis" class="form-control" onchange="myFunction(); myRumus();">
                      <option value="0">Pilih</option>
                      <option value="2" <?php echo $kav['jenis_pembelian'] == 2 ? ' selected' : ''; ?>>Pembelian Cash Keras</option>
                      <option value="4" <?php echo $kav['jenis_pembelian'] == 4 ? ' selected' : ''; ?>>Pembelian Cash Bertahap</option>
                      <option value="3" <?php echo $kav['jenis_pembelian'] == 3 ? ' selected' : ''; ?>>Pembelian Kredit</option>
                      <option value="5" <?php echo $kav['jenis_pembelian'] == 5 ? ' selected' : ''; ?>>Pembelian Kredit (Akad)</option>
                    </select>
                  </div>
                </div>


                <div class="form-group row">
                  <label class="control-label col-md-4">Cara Bayar</label>
                  <div class="col-md-8">
                    <select name="cara_bayar" id="cara_bayar" class="form-control" disabled>
                      <?php foreach ($kav as $kavling) {
                        $selected = ($kav['id_jenis_pembayaran'] == $id_jenis_pembayaran) ? 'selected' : '';
                      ?>
                        <option value="<?= $kav['id_jenis_pembayaran']; ?>" <?php echo $selected; ?>><?php echo $kav['cara_bayar']; ?></option>
                      <?php } ?>
                    </select>
                    <input name="id_jenis_pembayaran" class="form-control" id="id_jenis_pembayaran" value="<?= $kav['id_jenis_pembayaran']; ?>" type="hidden">
                    <span class="help-block"></span>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="control-label col-md-4">Nomor SKP</label>
                  <div class="col-md-8">
                    <input name="nomor_skp" class="form-control" type="text" value="<?= $kav['nomor_skp']; ?>" id="nomor_skp" readonly>
                    <span class="help-block"></span>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="control-label col-md-4">Nomor SKK</label>
                  <div class="col-md-8">
                    <input name="nomor_skk" class="form-control" type="text" id="nomor_skk" value="<?= $kav['nomor_skk']; ?>">
                    <span class="help-block"></span>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="control-label col-md-4">Nama Customer</label>
                  <div class="col-md-8">
                    <select name="customer" id="customer" class="form-control" disabled>
                      <?php foreach ($kav as $kavling) {
                        $selected = ($kav['id_customer'] == $id_customer) ? 'selected' : '';
                      ?>
                        <option value="<?= $kav['id_customer']; ?>" <?php echo $selected; ?>><?php echo $kav['nama_lengkap']; ?></option>
                      <?php } ?>
                    </select>
                    <input name="id_customer" class="form-control" type="hidden" id="id_customer" value="<?= $kav['id_customer']; ?>">
                    <span class="help-block"></span>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="control-label col-md-4">Agent/Marketing</label>
                  <div class="col-md-8">
                    <select name="marketing" id="marketing" class="form-control" disabled>
                      <?php foreach ($kav as $kavling) {
                        $selected = ($kav['id_marketing'] == $id_marketing) ? 'selected' : '';
                      ?>
                        <option value="<?= $kav['id_marketing']; ?>" <?php echo $selected; ?>><?php echo $kav['nama_marketing']; ?></option>
                      <?php } ?>
                    </select>
                    <input name="id_marketing" class="form-control" type="hidden" id="id_marketing" value="<?= $kav['id_marketing']; ?>">
                    <span class="help-block"></span>
                  </div>
                </div>

                <hr>

                <!-- CASH ==================================> -->
                <div id="trx_cash">


                  <div class="form-group row">
                    <label class="control-label col-md-4">DP / Uang Muka</label>
                    <div class="col-md-8">
                      <select name="dp" id="dp" class="form-control" disabled>
                        <?php foreach ($kav as $kavling) {
                          $selected = ($kav['jumlah_dp'] == $jumlah_dp) ? 'selected' : '';
                        ?>
                          <option value="<?= $kav['jumlah_dp']; ?>" <?php echo $selected; ?>><?php echo rupiah($kav['jumlah_dp']); ?></option>
                        <?php } ?>
                      </select>
                      <input name="jumlah_dp" class="form-control" type="hidden" id="jumlah_dp" value="<?= $kav['jumlah_dp']; ?>">
                      <span class="help-block"></span>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="control-label col-md-4">Lama Pembayaran</label>
                    <div class="col-md-8">
                      <select name="lama_cicilan" id="lama_cicilan" class="form-control" disabled>
                        <?php foreach ($kav as $kavling) {
                          $selected = ($kav['lama_cicilan'] == $lama_cicilan) ? 'selected' : '';
                        ?>
                          <option value="<?= $kav['lama_cicilan']; ?>" <?php echo $selected; ?>><?php echo $kav['lama_cicilan']; ?> Bulan</option>
                        <?php } ?>
                      </select>
                      <input name="lama_cicilan" class="form-control" type="hidden" id="lama_cicilan" value="<?= $kav['lama_cicilan']; ?>">
                      <span class="help-block"></span>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="control-label col-md-4">Pembayaran Per Bulan</label>
                    <div class="col-md-8">
                      <input name="cicilan_per_bulan" id="cicilan_per_bulan2" class="form-control" type="text" value="<?= rupiah($kav['cicilan_per_bulan']); ?>" readonly>
                      <span class="help-block"></span>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="control-label col-md-4">PPN (%)</label>
                    <div class="col-md-8">
                      <input name="trx_ppn" id="trx_ppn" class="form-control" type="text" value="<?= $kav['trx_ppn']; ?>">
                      <span class="help-block"></span>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="control-label col-md-4">PPh (%)</label>
                    <div class="col-md-8">
                      <input name="trx_pph" id="trx_pph" class="form-control" type="text" value="<?= $kav['trx_pph']; ?>">
                      <span class="help-block"></span>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="control-label col-md-4">Tanggal Tempo Pembayaran Pertama</label>
                    <div class="col-md-8">
                      <input name="tanggal_tempo" placeholder="" class="form-control" type="date" value="<?= $kav['tgl_mulai_cicilan']; ?>" required>
                      <span class="help-block"></span>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="control-label col-md-4">Bank</label>
                    <div class="col-md-8">
                      <select name="bank" id="bank" class="form-control" disabled>
                        <?php foreach ($kav as $kavling) {
                          $selected = ($kav['bank_id'] == $bank_id) ? 'selected' : '';
                        ?>
                          <option value="<?= $kav['bank_id']; ?>" <?php echo $selected; ?>><?php echo $kav['bank_nama']; ?>-<?php echo $kav['bank_nomor']; ?></option>
                        <?php } ?>
                      </select>
                      <input name="bank_id" class="form-control" type="hidden" id="bank_id" value="<?= $kav['bank_id']; ?>">
                      <span class="help-block"></span>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="control-label col-md-4">Bonus/Gimmick</label>
                    <div class="col-md-8">
                      <textarea name="bonus_gimmick" placeholder="" class="form-control" type="text" id="bonus_gimmick"><?= $kav['bonus_gimmick']; ?></textarea>
                      <span class="help-block"></span>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="control-label col-md-4">Sumber Dana</label>
                    <div class="col-md-8">
                      <input name="sumber_dana" placeholder="" class="form-control" type="text" id="sumber_dana" value="<?= $kav['sumber_dana']; ?>">
                      <span class="help-block"></span>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="control-label col-md-4">Tujuan Pembelian</label>
                    <div class="col-md-8">
                      <input name="tujuan_trx" placeholder="" class="form-control" type="text" id="tujuan_trx" value="<?= $kav['tujuan_trx']; ?>">
                      <span class="help-block"></span>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="control-label col-md-4">Fee Marketing</label>
                    <div class="col-md-8">
                      <input name="fee_marketing" id="fee_marketing" class="form-control" type="text" value="<?= $kav['fee_marketing']; ?>">
                      <span class="help-block"></span>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="control-label col-md-4">Keterangan</label>
                    <div class="col-md-8">
                      <textarea name="keterangan_trx" id="keterangan_trx" class="form-control" type="text"><?= $kav['keterangan_trx']; ?></textarea>
                      <span class="help-block"></span>
                    </div>
                  </div>
                </div>


                <div class="form-group row">
                  <label class="control-label col-md-10"></label>
                  <div class="col-md-8">
                    <a href="javascript:history.back()" class="btn btn-danger btn-md"> Cancel</a>
                    <button class="btn btn-primary btn-md" type="submit" name="submit"> Update Data</button>
                  </div>
                </div>
              </div>
            </form>
          </div>


          <div class="col-md-4">
            <ul class="nav flex-column">
              <li class="nav-item">
                <a href="#" class="nav-link">
                  Luas Tanah <span class="float-right badge bg-info"><?= $kav['luas_tanah']; ?></span>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  Luas Bangunan <span class="float-right badge bg-info"><?= $kav['luas_bangunan']; ?></span>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  Harga Jual <span class="float-right badge bg-info"><?= rupiah($kav['hrg_jual']); ?></span>
                </a>
              </li>
            </ul>
          </div>


        </div>


      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>


</body>

</html>





<?php $this->load->view('template/footer'); ?>



<script src="<?php echo base_url('assets/admin/plugins/select2/select2.min.js') ?>">
</script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/admin/plugins/select2/select2.css') ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/admin/plugins/select2/select2-bootstrap.css') ?>">

<script>
  var url_apps = "<?= base_url(); ?>"


  function myFunction() {
    var jenis = document.getElementById("jenis").value;
    if (jenis == '0') {
      $('#trx_kredit').hide();
      $('#trx_cash').hide();
      $('#trx_booking').hide();
    } else if (jenis == '1') {
      $('#trx_kredit').hide();
      $('#trx_cash').hide();
      $('#trx_booking').show();
    } else if (jenis == '2') {
      $('#trx_kredit').hide();
      $('#trx_cash').show();
      $('#trx_booking').hide();
    } else if (jenis == '3') {
      $('#trx_kredit').hide();
      $('#trx_cash').show();
      $('#trx_booking').hide();
    } else if (jenis == '4') {
      $('#trx_kredit').hide();
      $('#trx_cash').show();
      $('#trx_booking').hide();
    } else if (jenis == '5') {
      $('#trx_kredit').hide();
      $('#trx_cash').show();
      $('#trx_booking').hide();
    }
  }


  function myRumus() {
    var x = document.getElementById("jenis").value;
    if (x === "2") {
      $(document).ready(function() {
        // Mengambil data ketika pilihan cara bayar berubah
        $('#cara_bayar').on('change', function() {
          var cara_bayar = $(this).val();

          if (cara_bayar !== '') {
            $.ajax({
              url: '<?php echo site_url('transaksi/get_data_by_cara_bayar'); ?>',
              type: 'post',
              data: {
                cara_bayar: cara_bayar
              },
              dataType: 'json',
              success: function(response) {
                // Mengisi nilai pada form
                $('#harga_transaksi').val(response.harga_transaksi);
                $('#lama_pembayaran').val(response.lama_pembayaran);
                $('#lama_cicilan2').val(response.lama_pembayaran);
                fillDp();
                fillLamaCicilan();
                fillCicilanPerBulan();
              }
            });
          } else {
            $('#harga_transaksi').val('');
            $('#lama_pembayaran').val('');
            $('#lama_cicilan2').val('');
            fillDp();
            fillLamaCicilan();
            fillCicilanPerBulan();
          }
        });
      });

    } else if (x === "3") {
      $(document).ready(function() {
        // Mengambil data ketika pilihan cara bayar berubah
        $('#cara_bayar').on('change', function() {
          var cara_bayar = $(this).val();

          if (cara_bayar !== '') {
            $.ajax({
              url: '<?php echo site_url('transaksi/get_data_by_cara_bayar'); ?>',
              type: 'post',
              data: {
                cara_bayar: cara_bayar
              },
              dataType: 'json',
              success: function(response) {
                // Mengisi nilai pada form
                $('#harga_transaksi').val(response.harga_transaksi);
                $('#lama_pembayaran').val(response.lama_pembayaran);
                $('#lama_cicilan2').val(response.lama_pembayaran);
              }
            });
          } else {
            $('#harga_transaksi').val('');
            $('#lama_pembayaran').val('');
            $('#lama_cicilan2').val('');

          }
        });
      });
    } else if (x === "4") {
      $(document).ready(function() {
        // Mengambil data ketika pilihan cara bayar berubah
        $('#cara_bayar').on('change', function() {
          var cara_bayar = $(this).val();

          if (cara_bayar !== '') {
            $.ajax({
              url: '<?php echo site_url('transaksi/get_data_by_cara_bayar'); ?>',
              type: 'post',
              data: {
                cara_bayar: cara_bayar
              },
              dataType: 'json',
              success: function(response) {
                // Mengisi nilai pada form
                $('#harga_transaksi').val(response.harga_transaksi);
                $('#lama_pembayaran').val(response.lama_pembayaran);
                $('#lama_cicilan2').val(response.lama_pembayaran);
                fillDp();
                fillLamaCicilan();
                fillCicilanPerBulan();
              }
            });
          } else {
            $('#harga_transaksi').val('');
            $('#lama_pembayaran').val('');
            $('#lama_cicilan2').val('');
            fillDp();
            fillLamaCicilan();
            fillCicilanPerBulan();
          }
        });
      });
    } else if (x === "5") {
      $(document).ready(function() {
        // Mengambil data ketika pilihan cara bayar berubah
        $('#cara_bayar').on('change', function() {
          var cara_bayar = $(this).val();

          if (cara_bayar !== '') {
            $.ajax({
              url: '<?php echo site_url('transaksi/get_data_by_cara_bayar'); ?>',
              type: 'post',
              data: {
                cara_bayar: cara_bayar
              },
              dataType: 'json',
              success: function(response) {
                // Mengisi nilai pada form
                $('#harga_transaksi').val(response.harga_transaksi);
                $('#lama_pembayaran').val(response.lama_pembayaran);
                $('#lama_cicilan2').val(response.lama_pembayaran);
              }
            });
          } else {
            $('#harga_transaksi').val('');
            $('#lama_pembayaran').val('');
            $('#lama_cicilan2').val('');

          }
        });
      });
    }
  }

  function myBulan2() {
    fillCicilanPerBulan();
  }


  // Fungsi untuk mendapatkan bulan dalam format angka romawi
  function getMonthNumber(date) {
    var months = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
    return months[date.getMonth()];
  }

  // Fungsi untuk mendapatkan 2 angka terakhir tahun
  function getYearLastTwo(date) {
    return date.getFullYear().toString().substr(-2);
  }

  // Fungsi untuk mengisi nilai pada form nomor_skp
  function fillNomorSkp() {
    // Mendapatkan nilai tanggal dari form
    var tanggal = new Date(document.getElementsByName('tanggal')[0].value);

    // Mendapatkan bulan, 2 angka terakhir tahun, dan kode kavling dari form
    var bulan = getMonthNumber(tanggal);
    var tahun = getYearLastTwo(tanggal);
    var tanggalFormatted = tanggal.getDate().toString().padStart(2, '0');
    var kodeKavling = document.getElementsByName('kode_kavling')[0].value;

    // Mengisi nilai pada form nomor_skp
    document.getElementById('nomor_skp').value = 'MAS-KS/' + tanggalFormatted + '/' + bulan + '/' + tahun + '/' + kodeKavling;
  }

  // Menambahkan event listener untuk form tanggal
  document.getElementsByName('tanggal')[0].addEventListener('change', function() {
    fillNomorSkp();
  });
</script>