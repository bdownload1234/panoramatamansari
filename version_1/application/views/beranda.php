<!DOCTYPE html>
<html lang="en">
<head>
<title><?=$konfig['nama_perusahaan'];?></title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" href="<?=base_url('assets/aplikasi/'.konfigMedia('Vavicon')['nama_file']);?>"/>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link rel="stylesheet" href="assets/styles.css">
  
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">
      <span class="navbar-brand"><?=$konfig['nama_perusahaan'];?></span>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="#beranda">Beranda</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#profil">Profil</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#fasilitas">Fasilitas</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#denah">Denah</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#marketing">Marketing</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <section id="beranda" class="section">
    <div class="jumbotron">
      <h1 class="display-4"><?=$jumbotron['judul'];?></h1>
      <p class="lead"><?=$jumbotron['sub_judul'];?></p>
      <p><?=$jumbotron['deskripsi'];?></p>
    </div>
  </section>

  <section id="profil" class="section bg-cream py-4">
    <div class="container">
      <h2 class="section-title text-center"><?=$profil['judul'];?></h2>
      <p class="section-subtitle text-center"><?=$profil['sub_judul'];?></p>
      <div class="section-description text-center">
        <p><?=$profil['deskripsi'];?></p>
      </div>
    </div>
  </section>
  
  

  <section id="fasilitas" class="section">
    <div class="container">
        <h2 class="text-center"><?=$fasilitas['judul'];?></h2>
        <h6  class="text-center"><?=$fasilitas['sub_judul'];?></h6>
        <br>
        <br>
        
        <div class="row justify-content-center">
        <?php 
        $fasilitas = $this->db->query("SELECT * FROM fasilitas order by id_fasilitas ASC")->result();
        foreach($fasilitas as $fs){
        ?>

            <div class="col-md-4">
                <div class="fasilitas-item text-center">
                    <h3><i class="fas <?=$fs->icon;?>"></i> <?=$fs->judul;?></h3>
                    <p><?=$fs->deskripsi;?></p>
                </div>
            </div>

            <?php } ?>
            
        </div>
    </div>
</section>

<section id="denah" class="section">
  <div class="container">
    <div class="section-content text-center">
      <h2 class="section-title"><?=$denah['judul'];?></h2>
      <p class="section-subtitle"><?=$denah['sub_judul'];?></p>
      <div class="denah-svg">

      <div class="row"  style="text-align:center;">
  <div class="col-md-12">
    <center>  


    <!-- ===================== Denah SVG ======================= -->

    <?php $this->load->view('master_svg/denah_spn_1');?>

  <?php 
  // $peta = $this->db->query("SELECT * FROM kavling_peta")->result();

  // foreach ($peta as $pt) {
  //   if($pt->status == '0'){
  //     $warna = '#ffffff';
  //   }elseif($pt->status == '1'){
  //     $warna = '#FFF693';
  //   }elseif($pt->status == '2'){
  //     $warna = '#3DBEF0';
  //   }elseif($pt->status == '3'){
  //     $warna = '#F08519';
  //   }elseif($pt->status == '5'){
  //     $warna = '#606161';
  //   }



  //   if($pt->jenis_map == 'polygon'){
  //       echo '<a href="#bawah" onclick="add('.$pt->id_kavling.')">
  //       <g id="_1976507580336">
  //       <polygon class="fil3" points="'.$pt->map.'" style="fill:'.$warna.'"/>
  //       <g transform="'.$pt->matrik.'">
  //         <text x="14850" y="10500"  class="fil4 fnt2">'.$pt->kode_kavling.'</text>
  //       </g>
  //       </g>
  //     </a>';
  //   }

  //   if($pt->jenis_map == 'path'){
  //   echo '<a href="#bawah" onclick="add('.$pt->id_kavling.')">
  //       <g id="_1976507876576">
  //     <path class="fil3" d="'.$pt->map.'" style="fill:'.$warna.'"/>
  //     <g transform="'.$pt->matrik.'">
  //       <text x="14850" y="10500"  class="fil4 fnt2">'.$pt->kode_kavling.'</text>
  //     </g>
  //     </g>
  //  </a>';
  //   }

  // } 
  
  
  // //Hitung statistik
  // $stt_1 = $this->db->query("SELECT * FROM kavling_peta WHERE status='1'")->num_rows();
  // $stt_2 = $this->db->query("SELECT * FROM kavling_peta WHERE status='2'")->num_rows();
  // $stt_3 = $this->db->query("SELECT * FROM kavling_peta WHERE status='3'")->num_rows();
  // $stt_0 = $this->db->query("SELECT * FROM kavling_peta")->num_rows();

  // $kosong = $stt_0 - ($stt_1 + $stt_2 + $stt_3);
  ?>

  <h4>Klik tombol dibawah untuk menghitung skema cicilan</h4> 
<br>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Kalkulator Perhitungan Skema Cicilan</button>

  

</center>
  </div>
      </div>


      </div>
    </div>
  </div>
</section>



  <section id="marketing" class="section">
    <div class="container">
      <h2 class="section-title text-center"><?=$marketing['judul'];?></h2>
      <p class="section-subtitle text-center"><?=$marketing['sub_judul'];?></p>
      <div class="row justify-content-center">
        <?php 
        $marketing = $this->db->query("SELECT * FROM marketing order by id_marketing ASC")->result();
        foreach($marketing as $mr){

        ?>
        <div class="col-md-3 col-sm-12">
          <div class="marketing-block">
            <?php 
          if($mr->foto == ''){
            if($mr->jenis_kelamin == 'Laki-laki'){
              echo '<img src="'.base_url('assets/images/pria.jpg').'" alt="Foto" class="marketing-photo">';
            }else if($mr->jenis_kelamin == 'Perempuan'){
              echo '<img src="'.base_url('assets/images/wanita.jpg').'" alt="Foto" class="marketing-photo">';
            }
          }else{
            echo '<img src="'.base_url('berkas_user/'.$mr->foto).'" alt="Foto" class="marketing-photo">';
          }
            ?>
            <h4 class="marketing-name"><?=$mr->nama_marketing;?></h4>
            <p class="marketing-phone"><?=$mr->no_telp;?></p>
          </div>
        </div>
        <?php } ?>
        
      </div>
    </div>
  </section>
  


  <footer class="footer">
    <div class="container">
      <div class="row">
        <div class="col">
          <p class="text-center">&copy; 2023 Hak Cipta Terpelihara</p>
        </div>
      </div>
    </div>
  </footer>




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
                            <label class="control-label col-md-3">No. Kavling</label>
                            <div class="col-md-3">
                                <input name="kode" class="form-control" type="text" readonly>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Luas Tanah</label>
                            <div class="col-md-2">
                                <input name="luas" class="form-control" type="text" readonly>
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
                            <label class="control-label col-md-3">Status Unit</label>
                            <div class="col-md-4">
                                <input name="status" placeholder="" class="form-control" type="text" readonly>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <hr>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Nama Pembeli</label>
                            <div class="col-md-8">
                                <input name="nama_lengkap" placeholder="" class="form-control" type="text" id="nama_lengkap" readonly>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Nama Marketing</label>
                            <div class="col-md-8">
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





  <!-- Skrip JavaScript Bootstrap -->
  <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script> -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

  <script>
    $(document).ready(function() {
      // Tambahkan efek smooth scroll ke setiap tautan dengan hash
      $('a[href*="#"]').on('click', function(e) {
        e.preventDefault();
  
        $('html, body').animate({
          scrollTop: $($(this).attr('href')).offset().top
        }, 500);
      });
    });
  </script>




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
           url : "<?php echo site_url('beranda/ajax_edit/')?>" + id,
           type: "GET",
           dataType: "JSON",
           success: function(data)
           {
                $('[name="kode"]').val(data.kode_kavling);
                $('[name="luas"]').val(data.luas_tanah);
                $('[name="harga_jual"]').val(data.hrg_jual);
                $('[name="luas"]').val(data.luas_tanah);
                $('[name="nama_lengkap"]').val(data.nama_lengkap);
                $('[name="nama_marketing"]').val(data.nama_marketing);
               
               if(data.status == '0'){
                  $('[name="status"]').val('BELUM TERJUAL');
               }else if(data.status == '1'){
                  $('[name="status"]').val('HOLD');
               }else if(data.status == '2'){
                  $('[name="status"]').val('TERJUAL');
               }else if(data.status == '3'){
                  $('[name="status"]').val('TERJUAL');
               }else if(data.status == '4'){
                  $('[name="status"]').val('TERJUAL');
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


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Kalkulator Skema Cicilan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id"/> 
                    <div class="form-body">


                        <div class="form-group row">
                            <label class="control-label col-md-4">No. Kavling</label>
                            <div class="col-md-7">
                                <input type="text" class="form-control" name="harga_pokok" id="harga_pokok" value="">
                                <input type="hidden" class="form-control" name="harga_pokok_int" id="harga_pokok_int" value="">
                                <span class="help-block"></span>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="control-label col-md-4">Harga Jual</label>
                            <div class="col-md-7">
                                <input name="harga_jual" placeholder="" class="form-control" type="text" id="harga_jual" readonly="">
                                <span class="help-block"></span>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="control-label col-md-4">Jumlah DP</label>
                            <div class="col-md-7">
                                <input type="text" class="form-control" name="uang_muka" id="uang_muka" value="">
                                <input type="hidden" class="form-control" name="uang_muka_int" id="uang_muka_int" value="">
                                <span class="help-block"></span>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="control-label col-md-4">Lama Cicilan (Bulan)</label>
                            <div class="col-md-7">
                                <select name="bulan" class="form-control" id="bulan" onchange="myBulan()">
                                  <option value="">-- pilih --</option>
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
                                  <option value="25">25 Bulan</option>
                                  <option value="26">26 Bulan</option>
                                  <option value="27">27 Bulan</option>
                                  <option value="28">28 Bulan</option>
                                  <option value="29">29 Bulan</option>
                                  <option value="30">30 Bulan</option>
                                  <option value="31">31 Bulan</option>
                                  <option value="32">32 Bulan</option>
                                  <option value="33">33 Bulan</option>
                                  <option value="34">34 Bulan</option>
                                  <option value="35">35 Bulan</option>
                                  <option value="36">36 Bulan</option>
                                </select>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="control-label col-md-4">Cicilan Per Bulan</label>
                            <div class="col-md-7">
                                <input name="cicilan" placeholder="" class="form-control" type="text" id="cicilan" readonly>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-4">Total Hutang</label>
                            <div class="col-md-7">
                                <input name=" " placeholder="" class="form-control" type="text" id="sisa_hutang" readonly>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        
                    </div>
                </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>



<script>


        $('#uang_muka').on('change', function() {

          var myStr = $(this).val();
          var newStr = myStr.replace(/\D/g,'');

          // alert(newStr);
          $('#uang_muka_int').val(newStr);
          var hargaJual = parseInt($('#luas_tanah').val()) * parseInt($('#harga_per_meter_int').val());
          $('#bulan').val('');
          $('#cicilan').val('');
          $('#sisa_hutang').val('');
          $('#harga_jual').val('');

          // alert(hargaJual);
          if (newStr > hargaJual) {
            alert('Uang muka melebihi harga.!');
            $('#uang_muka').val('0');
            $('#uang_muka_int').val('0');
          }
        });


        $('#harga_pokok').on('change', function() {

          var myStr = $(this).val();
          var newStr = myStr.replace(/\D/g,'');

          $('#harga_pokok_int').val(newStr);

        });


         /* Tanpa Rupiah */
        var harga_pokok = document.getElementById('harga_pokok');
        harga_pokok.addEventListener('keyup', function(e) {
          harga_pokok.value = formatRupiah(this.value);
        });

        harga_pokok.addEventListener('keydown', function(event) {
          limitCharacter(event);
        });

        /* Tanpa Rupiah */
        var uang_muka = document.getElementById('uang_muka');
        uang_muka.addEventListener('keyup', function(e) {
          uang_muka.value = formatRupiah(this.value);
        });

        uang_muka.addEventListener('keydown', function(event) {
          limitCharacter(event);
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


        // $('#uang_muka').on('change', function() {

        //   var myStr = $(this).val();
        //   var newStr = myStr.replace(/\D/g,'');

        //   alert(newStr);
        //   $('#uang_muka_int').val(newStr);
        //   // var minDp = parseInt(data.hrg_jual) * 0.3;

        //   // if ($('#uang_muka').val() < minDp) {
        //   //   alert('coba');
        //   // }
        // });


        /* Tanpa Rupiah */
        // var uang_muka = document.getElementById('uang_muka');
        //   uang_muka.addEventListener('keyup', function(e) {
        //   uang_muka.value = formatRupiah(this.value);
        // });

        // uang_muka.addEventListener('keydown', function(event) {
        //   limitCharacter(event);
        // });



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


        function myBulan() {

          // alert("as");
          var x = document.getElementById("bulan").value;
          var harga_pokok = document.getElementById("harga_pokok_int").value;
          var uang_muka_int = document.getElementById("uang_muka_int").value;

          var keuntungan = document.getElementById("keuntungan").value;
          var keuntunga_percent = (harga_pokok - uang_muka_int) * keuntungan;


          var cicilan_pokok = parseInt(((harga_pokok - uang_muka_int) / x));
          document.getElementById("cicilan_pokok").value = formatRupiah(cicilan_pokok.toString());

          
          var cicilan = parseInt(((harga_pokok - uang_muka_int) / x) + keuntunga_percent);

          var sisa_hutang = cicilan * x;
          var harga_jual = parseInt(sisa_hutang) + parseInt(uang_muka_int);


          document.getElementById("sisa_hutang").value = formatRupiah(sisa_hutang.toString());
          document.getElementById("cicilan").value = formatRupiah(cicilan.toString());
          document.getElementById("harga_jual").value = formatRupiah(harga_jual.toString());

        }
  


        function bukaForm() {
          var x = document.getElementById("myDIV");
          if (x.style.display === "none") {
            x.style.display = "block";
          } else {
            x.style.display = "none";
          }
        }
      </script>



  
</body>
</html>
