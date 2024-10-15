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
            <form action="<?= base_url('transaksi/baru'); ?>" id="form" class="form-horizontal" method="POST">
              <input type="hidden" value="" name="id" />
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
                    <input name="harga_jual_int" id="harga_jual_int" class="form-control" type="hidden" value="<?= $kav['hrg_jual']; ?>">
                    <span class="help-block"></span>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="control-label col-md-4">Booking Fee</label>
                  <div class="col-md-8">
                    <input name="book_fee" class="form-control" id="book_fee" type="text" value="<?= rupiah($kav['book_fee']) ?>" readonly>
                    <input name="book_fee_int" id="book_fee_int" class="form-control" type="hidden" value="<?= $kav['book_fee']; ?>">
                    <span class="help-block"></span>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="control-label col-md-4">Tanggal Transaksi</label>
                  <div class="col-md-8">
                    <input name="tanggal" placeholder="" class="form-control" type="date" required>
                    <span class="help-block"></span>
                  </div>
                </div>


                <div class="form-group row">
                  <label class="control-label col-md-4">Jenis Transaksi</label>
                  <div class="col-md-8">
                    <select name="jenis" id="jenis" class="form-control" onchange="myFunction(); myRumus();">
                      <option value="0">Pilih</option>
                      <option value="2">Pembelian Cash Keras</option>
                      <option value="4">Pembelian Cash Bertahap</option>
                      <option value="3">Pembelian Kredit</option>
                    </select>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="control-label col-md-4">Cara Bayar</label>
                  <div class="col-md-8">
                    <input type="text" name="cara_bayar" class="form-control" id="cara_bayar">
                    <input name="harga_transaksi" class="form-control" id="harga_transaksi" type="hidden">
                    <input name="lama_pembayaran" class="form-control" id="lama_pembayaran" type="hidden">
                    <span class="help-block"></span>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="control-label col-md-4">Nomor SKP</label>
                  <div class="col-md-8">
                    <input name="nomor_skp" placeholder="" class="form-control" type="text" id="nomor_skp">
                    <span class="help-block"></span>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="control-label col-md-4">Nomor SKK</label>
                  <div class="col-md-8">
                    <input name="nomor_skk" placeholder="" class="form-control" type="text" id="nomor_skk">
                    <span class="help-block"></span>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="control-label col-md-4">Nama Customer</label>
                  <div class="col-md-8">
                    <input name="customer" placeholder="" class="form-control" type="text" id="customer" required>
                    <span class="help-block"></span>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="control-label col-md-4">No KTP</label>
                  <div class="col-md-8">
                    <input name="no_ktp" placeholder="" class="form-control" type="text" id="no_ktp" readonly>
                    <span class="help-block"></span>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="control-label col-md-4">Agent/Marketing</label>
                  <div class="col-md-8">
                    <input name="marketing" placeholder="" class="form-control" type="text" id="marketing" required>
                    <span class="help-block"></span>
                  </div>
                </div>

                <hr>

                <!-- CASH ==================================> -->
                <div id="trx_cash">


                  <div class="form-group row">
                    <label class="control-label col-md-4">DP / Uang Muka</label>
                    <div class="col-md-8">
                      <input name="dp" id="dp2" class="form-control" type="text" readonly>
                      <input name="dp2_int" id="dp2_int" class="form-control" type="hidden">
                      <span class="help-block"></span>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="control-label col-md-4">Lama Pembayaran</label>
                    <div class="col-md-8">
                      <!-- <input name="lama_cicilan" id="lama_cicilan" class="form-control" type="text" > -->
                      <select name="lama_cicilan" class="form-control" id="lama_cicilan2" onforminput="myBulan2()">
                        <option value=""></option>
                        <option value="1">1 Bulan</option>
                        <option value="2">2 Bulan</option>
                        <option value="3">3 Bulan</option>
                        <option value="4">4 Bulan</option>
                        <option value="5">5 Bulan</option>
                        <option value="6">6 Bulan</option>
                        <option value="7">7 Bulan</option>
                        <option value="8">8 Bulan</option>
                        <option value="9">9 Bulan</option>
                        <option value="10">10 Bulan</option>
                        <option value="11">11 Bulan</option>
                        <option value="12">12 Bulan</option>
                        <option value="13">13 Bulan</option>
                        <option value="14">14 Bulan</option>
                        <option value="15">15 Bulan</option>
                        <option value="16">16 Bulan</option>
                        <option value="17">17 Bulan</option>
                        <option value="18">18 Bulan</option>
                        <option value="19">19 Bulan</option>
                        <option value="20">20 Bulan</option>
                        <option value="21">21 Bulan</option>
                        <option value="22">22 Bulan</option>
                        <option value="23">23 Bulan</option>
                        <option value="24">24 Bulan</option>
                      </select>
                      <span class="help-block"></span>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="control-label col-md-4">Pembayaran Per Bulan</label>
                    <div class="col-md-8">
                      <input name="cicilan_per_bulan" id="cicilan_per_bulan2" class="form-control" type="text" readonly>
                      <input name="cicilan_per_bulan_int" id="cicilan_per_bulan2_int" class="form-control" type="hidden" readonly>
                      <span class="help-block"></span>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="control-label col-md-4">PPN (%)</label>
                    <div class="col-md-8">
                      <input name="trx_ppn" id="trx_ppn" class="form-control" type="text">
                      <span class="help-block"></span>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="control-label col-md-4">PPh (%)</label>
                    <div class="col-md-8">
                      <input name="trx_pph" id="trx_pph" class="form-control" type="text">
                      <span class="help-block"></span>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="control-label col-md-4">Tanggal Tempo Pembayaran Pertama</label>
                    <div class="col-md-8">
                      <input name="tanggal_tempo" placeholder="" class="form-control" type="date" required>
                      <span class="help-block"></span>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="control-label col-md-4">Bank</label>
                    <div class="col-md-8">
                      <input name="bank" placeholder="" class="form-control" type="text" id="bank2">
                      <span class="help-block"></span>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="control-label col-md-4">Bonus/Gimmick</label>
                    <div class="col-md-8">
                      <textarea name="bonus_gimmick" placeholder="" class="form-control" type="text" id="bonus_gimmick"></textarea>
                      <span class="help-block"></span>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="control-label col-md-4">Sumber Dana</label>
                    <div class="col-md-8">
                      <input name="sumber_dana" placeholder="" class="form-control" type="text" id="sumber_dana">
                      <span class="help-block"></span>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="control-label col-md-4">Tujuan Pembelian</label>
                    <div class="col-md-8">
                      <input name="tujuan_trx" placeholder="" class="form-control" type="text" id="tujuan_trx">
                      <span class="help-block"></span>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="control-label col-md-4">Fee Marketing</label>
                    <div class="col-md-8">
                      <input name="fee_marketing" id="fee_marketing" class="form-control" type="text">
                      <span class="help-block"></span>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="control-label col-md-4">Keterangan</label>
                    <div class="col-md-8">
                      <textarea name="keterangan_trx" id="keterangan_trx" class="form-control" type="text"></textarea>
                      <span class="help-block"></span>
                    </div>
                  </div>
                </div>


                <div class="form-group row">
                  <label class="control-label col-md-10"></label>
                  <div class="col-md-8">
                    <a href="javascript:history.back()" class="btn btn-danger btn-md"> Cancel</a>
                    <button class="btn btn-primary btn-md" type="submit" name="submit"> Proses Transaksi</button>
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


<script type="text/javascript">
  $('#harga_jual').on('change', function() {

    var myStr = $(this).val();
    var newStr = myStr.replace(/\D/g, '');
    $('#harga_jual_int').val(newStr);

  });

  $('#dp2').on('change', function() {

    var myStr = $(this).val();
    var newStr = myStr.replace(/\D/g, '');
    $('#dp2_int').val(newStr);

  });

  $('#cicilan_per_bulan2').on('change', function() {

    var myStr = $(this).val();
    var newStr = myStr.replace(/\D/g, '');
    $('#cicilan_per_bulan2_int').val(newStr);

  });

  $('#pem_booking').on('change', function() {

    var myStr = $(this).val();
    var newStr = myStr.replace(/\D/g, '');
    $('#pem_booking_int').val(newStr);

  });

  $('#pem_cash').on('change', function() {

    var myStr = $(this).val();
    var newStr = myStr.replace(/\D/g, '');
    $('#pem_cash_int').val(newStr);

  });


  $('#fee_marketing').on('change', function() {

    var myStr = $(this).val();
    var newStr = myStr.replace(/\D/g, '');
    $('#fee_marketing_int').val(newStr);

  });
</script>

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
    }
  }

  $(document).ready(function() {

    $('#trx_kredit').hide();
    $('#trx_cash').show();
    $('#trx_booking').hide();

    //----->
    //Ambil semua data customer untuk select 2
    $("#customer").select2({
      ajax: {
        url: url_apps + 'transaksi/ajax_select_customer',
        dataType: 'json',
        delay: 250,
        data: function(params) {
          return {
            q: params, // search term
          };
        },
        results: function(data, params) {
          console.log(data);
          return {
            results: $.map(data, function(item) {
              return {
                text: item.nama_lengkap,
                id: item.id_customer
              }
            })
          };
        },
        cache: true
      },
      minimumInputLength: 1,
    });

    //Ambil semua data marketing untuk select 2
    $("#marketing").select2({
      ajax: {
        url: url_apps + 'transaksi/ajax_select_marketing',
        dataType: 'json',
        delay: 250,
        data: function(params) {
          return {
            q: params, // search term
          };
        },
        results: function(data, params) {
          console.log(data);
          return {
            results: $.map(data, function(item) {
              return {
                text: item.nama_marketing,
                id: item.id_marketing
              }
            })
          };
        },
        cache: true
      },
      minimumInputLength: 1,
    });

    //Ambil semua data bank untuk select 2
    $("#bank").select2({
      ajax: {
        url: url_apps + 'transaksi/ajax_select_bank',
        dataType: 'json',
        delay: 250,
        data: function(params) {
          return {
            q: params, // search term
          };
        },
        results: function(data, params) {
          console.log(data);
          return {
            results: $.map(data, function(item) {
              return {
                text: item.bank_nama + '-' + item.bank_nomor,
                id: item.bank_id
              }
            })
          };
        },
        cache: true
      },
      minimumInputLength: 1,
    });

    //Ambil semua data cara bayar
    $("#cara_bayar").select2({
      ajax: {
        url: url_apps + 'transaksi/ajax_select_cara_bayar',
        dataType: 'json',
        delay: 250,
        data: function(params) {
          return {
            q: params, // search term
          };
        },
        results: function(data, params) {
          console.log(data);
          return {
            results: $.map(data, function(item) {
              return {
                text: item.cara_bayar,
                id: item.id_jenis_pembayaran
              }
            })
          };
        },
        cache: true
      },
      minimumInputLength: 1,
    });

    //Ambil Data Bank
    $("#bank2").select2({
      ajax: {
        url: url_apps + 'transaksi/ajax_select_bank',
        dataType: 'json',
        delay: 250,
        data: function(params) {
          return {
            q: params, // search term
          };
        },
        results: function(data, params) {
          console.log(data);
          return {
            results: $.map(data, function(item) {
              return {
                text: item.bank_nama + '-' + item.bank_nomor,
                id: item.bank_id
              }
            })
          };
        },
        cache: true
      },
      minimumInputLength: 1,
    });

  });

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

      function fillDp() {
        var hargaJual = document.getElementById("harga_jual_int").value;
        var hargaTransaksi = document.getElementById("harga_transaksi").value;
        var bookFee = document.getElementById("book_fee_int").value;
        var JmlDp = (hargaJual / 100) * hargaTransaksi;
        var dp = parseInt(JmlDp) + parseInt(bookFee);

        // jika tiga digit terakhir bukan 000, tambahkan 1000 - digit terakhir ke dp
        var lastThreeDigits = dp % 1000;
        if (lastThreeDigits != 0) {
          dp += (1000 - lastThreeDigits);
        }

        document.getElementById("dp2").value = dp.toLocaleString("id-ID");
        document.getElementById("dp2_int").value = dp;
      }

      function fillLamaCicilan() {
        var lama_pembayaran = document.getElementById("lama_pembayaran").value;
        document.getElementById("lama_cicilan2").value = lama_pembayaran;
      }

      function fillCicilanPerBulan() {
        var hargaJual = document.getElementById("harga_jual_int").value;
        var hargaTransaksi = document.getElementById("harga_transaksi").value;
        var bookFee = document.getElementById("book_fee_int").value;
        var dp = document.getElementById("dp2_int").value;
        var sisa = hargaJual - dp;
        var lama_pembayaran = document.getElementById("lama_pembayaran").value;
        var cicilan_per_bulan = sisa / lama_pembayaran;

        // jika tiga digit terakhir bukan 000, tambahkan 1000 - digit terakhir ke cicilan_pe_bulan
        var lastThreeDigits = cicilan_per_bulan % 1000;
        if (lastThreeDigits != 0) {
          cicilan_per_bulan += (1000 - lastThreeDigits);
        }

        document.getElementById("cicilan_per_bulan2").value = cicilan_per_bulan.toLocaleString("id-ID");
        document.getElementById("cicilan_per_bulan2_int").value = cicilan_per_bulan;
      }
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

      function fillDp() {
        var hargaJual = document.getElementById("harga_jual_int").value;
        var hargaTransaksi = document.getElementById("harga_transaksi").value;
        var bookFee = document.getElementById("book_fee_int").value;
        var JmlDp = (hargaJual / 100) * hargaTransaksi;
        // var dp = parseInt(JmlDp) - parseInt(bookFee);
        var dp = parseInt(JmlDp) - parseInt(bookFee);
        var roundedDp = Math.ceil(dp / 1000) * 1000;
        document.getElementById("dp2").value = roundedDp.toLocaleString("id-ID");
        document.getElementById("dp2_int").value = roundedDp;

      }

      function fillLamaCicilan() {
        var lama_pembayaran = document.getElementById("lama_pembayaran").value;
        document.getElementById("lama_cicilan2").value = lama_pembayaran;
      }

      function fillCicilanPerBulan() {
        var hargaJual = document.getElementById("harga_jual_int").value;
        var hargaTransaksi = document.getElementById("harga_transaksi").value;
        var bookFee = document.getElementById("book_fee_int").value;
        var JmlDp = (hargaJual / 100) * hargaTransaksi;
        var dp = parseInt(JmlDp) - parseInt(bookFee);
        var roundedDp = Math.ceil(dp / 1000) * 1000;
        var lama_pembayaran = document.getElementById("lama_pembayaran").value;
        var cicilan_bulan = roundedDp / lama_pembayaran;
        var cicilan_per_bulan = Math.ceil(cicilan_bulan / 1000) * 1000;
        document.getElementById("cicilan_per_bulan2").value = cicilan_per_bulan.toLocaleString("id-ID");
        document.getElementById("cicilan_per_bulan2_int").value = cicilan_per_bulan;
      }
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

      function fillDp() {
        var hargaJual = document.getElementById("harga_jual_int").value;
        var hargaTransaksi = document.getElementById("harga_transaksi").value;
        var bookFee = document.getElementById("book_fee_int").value;
        var JmlDp = (hargaJual / 100) * hargaTransaksi;
        var dp = parseInt(JmlDp) + parseInt(bookFee);

        // jika tiga digit terakhir bukan 000, tambahkan 1000 - digit terakhir ke dp
        var lastThreeDigits = dp % 1000;
        if (lastThreeDigits != 0) {
          dp += (1000 - lastThreeDigits);
        }

        document.getElementById("dp2").value = dp.toLocaleString("id-ID");
        document.getElementById("dp2_int").value = dp;
      }

      function fillLamaCicilan() {
        var lama_pembayaran = document.getElementById("lama_pembayaran").value;
        document.getElementById("lama_cicilan2").value = lama_pembayaran;
      }

      function fillCicilanPerBulan() {
        var hargaJual = document.getElementById("harga_jual_int").value;
        var hargaTransaksi = document.getElementById("harga_transaksi").value;
        var bookFee = document.getElementById("book_fee_int").value;
        var dp = document.getElementById("dp2_int").value;
        var sisa = hargaJual - dp;
        var lama_pembayaran = document.getElementById("lama_pembayaran").value;
        var cicilan_per_bulan = sisa / lama_pembayaran;

        // jika tiga digit terakhir bukan 000, tambahkan 1000 - digit terakhir ke cicilan_per_bulan
        var lastThreeDigits = cicilan_per_bulan % 1000;
        if (lastThreeDigits != 0) {
          cicilan_per_bulan += (1000 - lastThreeDigits);
        }

        document.getElementById("cicilan_per_bulan2").value = cicilan_per_bulan.toLocaleString("id-ID");
        document.getElementById("cicilan_per_bulan2_int").value = cicilan_per_bulan;
      }
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
    var kodeKavling = document.getElementsByName('kode_kavling')[0].value.replace('-', '/');
    var kodeKavlingParts = kodeKavling.split('/');
    if (kodeKavlingParts.length === 1) {
      kodeKavling = 'E1/' + kodeKavlingParts[0].padStart(2, '0');
    } else {
      kodeKavling = kodeKavlingParts[0] + '/' + kodeKavlingParts[1].padStart(2, '0');
    }

    // Mengisi nilai pada form nomor_skp
    document.getElementById('nomor_skp').value = 'MAS-KS/' + tanggalFormatted + '/' + bulan + '/' + tahun + '/' + kodeKavling;
  }

  // Menambahkan event listener untuk form tanggal
  document.getElementsByName('tanggal')[0].addEventListener('change', function() {
    fillNomorSkp();
  });

  $(document).ready(function() {
    // Mengambil data ketika pilihan cara bayar berubah
    $('#customer').on('change', function() {
      var customer = $(this).val();

      if (customer !== '') {
        $.ajax({
          url: '<?php echo site_url('transaksi/get_data_by_customer'); ?>',
          type: 'post',
          data: {
            customer: customer
          },
          dataType: 'json',
          success: function(response) {
            // Mengisi nilai pada form
            $('#no_ktp').val(response.no_ktp);
          }
        });
      } else {
        $('#no_ktp').val('');
      }
    });
  });
</script>