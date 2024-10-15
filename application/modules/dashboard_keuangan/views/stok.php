<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <!-- <h1 class="m-0 text-dark">Dashboard
          <?php echo $this->encryption->decrypt($this->session->userdata('id')); ?>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->

      <div class="row">
        <div class="col-lg-12 col-12">
        

<!-- ================================================================================================== -->
<?php 

$unit = $this->db->query("SELECT COUNT(*) as jum FROM kavling_peta")->row_array();
$hold = $this->db->query("SELECT COUNT(*) as jum FROM kavling_peta WHERE stt_kavling='0'")->row_array();
$avaiable = $this->db->query("SELECT COUNT(*) as jum FROM kavling_peta WHERE stt_kavling='1'")->row_array();
$nup = $this->db->query("SELECT COUNT(*) as jum FROM kavling_peta WHERE stt_kavling='2'")->row_array();
// $ready = $this->db->query("SELECT COUNT(*) as jum FROM kavling_peta WHERE stt_kavling='3'")->row_array();

$terboking = $this->db->query("SELECT COUNT(*) as jum FROM kavling_peta WHERE stt_kavling='3'")->row_array();
$sudahAkad = $this->db->query("SELECT COUNT(*) as jum FROM kavling_peta WHERE stt_kavling='4'")->row_array();
$standart = $this->db->query("SELECT COUNT(*) as jum FROM kavling_peta WHERE stt_kavling='5'")->row_array();
$khusus = $this->db->query("SELECT COUNT(*) as jum FROM kavling_peta WHERE stt_kavling='6'")->row_array();

?>

<!-- Small boxes (Stat box) -->

<div class="row">
    <div class="col-md-12">
        <h4>Data Stok</h4>
        <div class="row">


          <div class="col-lg-3 col-4">
            <!-- small box -->
            <div class="small-box bg-primary">
              <div class="inner">
                <h3><?=$unit['jum'];?></h3>

                <p>UNIT</p>
              </div>
              <div class="icon">
                <i class="ion ion-home"></i>
              </div>
              <a href="/dashboard_keuangan/detail_data/all" class="small-box-footer">Detail Data <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->

          <div class="col-lg-3 col-4">
            <!-- small box -->
            <div class="small-box bg-secondary">
              <div class="inner">
                <h3><?=$hold['jum'];?></h3>

                <p>HOLD</p>
              </div>
              <div class="icon">
                <i class="ion ion-pause"></i>
              </div>
              <a href="/dashboard_keuangan/detail_data/0" class="small-box-footer">Detail Data <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->


          <div class="col-lg-3 col-4">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?=$avaiable['jum'];?></h3>

                <p>AVAIABLE</p>
              </div>
              <div class="icon">
                <i class="ion ion-checkmark"></i>
              </div>
              <a href="/dashboard_keuangan/detail_data/1" class="small-box-footer">Detail Data <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          
          <div class="col-lg-3 col-4">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?=$nup['jum'];?></h3>

                <p>PRE ORDER / NUP</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="/dashboard_keuangan/detail_data/2" class="small-box-footer">Detail Data <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->




          <div class="col-lg-3 col-4">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?=$terboking['jum'];?></h3>

                <p>TERBOKING</p>
              </div>
              <div class="icon">
                <i class="ion ion-bookmark"></i>
              </div>
              <a href="/dashboard_keuangan/detail_data/3" class="small-box-footer">Detail Data <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->

          <div class="col-lg-3 col-4">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?=$sudahAkad['jum'];?></h3>

                <p>SUDAH AKAD</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="/dashboard_keuangan/detail_data/4" class="small-box-footer">Detail Data <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->

          <!--<div class="col-lg-3 col-4">-->
            <!-- small box -->
          <!--  <div class="small-box bg-warning">-->
          <!--    <div class="inner">-->
          <!--      <h3><?=$standart['jum'];?></h3>-->

          <!--      <p>STANDART</p>-->
          <!--    </div>-->
          <!--    <div class="icon">-->
          <!--      <i class="ion ion-person-add"></i>-->
          <!--    </div>-->
          <!--    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>-->
          <!--  </div>-->
          <!--</div>-->
          <!-- ./col -->

          <!--<div class="col-lg-3 col-4">-->
            <!-- small box -->
          <!--  <div class="small-box bg-success">-->
          <!--    <div class="inner">-->
          <!--      <h3><?=$khusus['jum'];?></h3>-->

          <!--      <p>KHUSUS</p>-->
          <!--    </div>-->
          <!--    <div class="icon">-->
          <!--      <i class="ion ion-person-add"></i>-->
          <!--    </div>-->
          <!--    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>-->
          <!--  </div>-->
          <!--</div>-->
          <!-- ./col -->

        </div>
        <!-- /.row -->

        <?php
        $spr = $this->db->query("SELECT * FROM spr WHERE status_spr='0'")->num_rows();
        $pindah = $this->db->query("SELECT * FROM spr WHERE status_spr='12'")->num_rows();
        $gantiNama = $this->db->query("SELECT * FROM spr WHERE status_spr='14'")->num_rows();
        $pembatalan = $this->db->query("SELECT * FROM pembatalan")->num_rows();
        ?>

  <div class="row" style="margin-top: 3%">
  <div class="col-lg-12 col-12">
  <h4>Data Penjualan</h4>
  <div class="row">
      <div class="col-lg-3 col-4">
        <!-- small box -->
        <div class="small-box bg-primary">
          <div class="inner">
            <h3><?=$spr;?></h3>
    
            <p>SPR</p>
          </div>
          <div class="icon">
            <i class="ion ion-home"></i>
          </div>
          <a href="/dashboard_keuangan/detail_penjualan/spr" class="small-box-footer">Detail Data <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      
      <div class="col-lg-3 col-4">
        <!-- small box -->
        <div class="small-box bg-warning">
          <div class="inner">
            <h3><?=$pindah;?></h3>
    
            <p>Pindah Kavling</p>
          </div>
          <div class="icon">
            <i class="ion ion-home"></i>
          </div>
          <a href="/dashboard_keuangan/detail_penjualan/pindah_kavling" class="small-box-footer">Detail Data <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      
      <div class="col-lg-3 col-4">
        <!-- small box -->
        <div class="small-box bg-success">
          <div class="inner">
            <h3><?=$gantiNama;?></h3>
    
            <p>Ganti Nama</p>
          </div>
          <div class="icon">
            <i class="ion ion-home"></i>
          </div>
          <a href="/dashboard_keuangan/detail_penjualan/ganti_nama" class="small-box-footer">Detail Data <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      
      <div class="col-lg-3 col-4">
        <!-- small box -->
        <div class="small-box bg-secondary">
          <div class="inner">
            <h3><?=$pembatalan;?></h3>
    
            <p>Pembatalan</p>
          </div>
          <div class="icon">
            <i class="ion ion-home"></i>
          </div>
          <a href="/dashboard_keuangan/detail_penjualan/batal" class="small-box-footer">Detail Data <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      
      
      
  <!--<table class="table table-bordered">-->
  <!--        <tr>-->
  <!--          <td width="10%">#</td>-->
  <!--          <td width="70%">Deskripsi</td>-->
  <!--          <td width="20%" align="center">Jumlah</td>-->
  <!--          <td width="20%" align="center">Action</td>-->
  <!--        </tr>-->
  <!--        <tr>-->
  <!--          <td width="10%">1</td>-->
  <!--          <td width="70%">SPR</td>-->
  <!--          <td width="20%" align="center"><?=$spr;?></td>-->
  <!--          <td width="20%" align="center"><a href="/dashboard_keuangan/detail_penjualan/spr"> Detail Data <i class="fas fa-arrow-circle-right"></i></a></td>-->
  <!--        </tr>-->
  <!--        <tr>-->
  <!--          <td width="10%">2</td>-->
  <!--          <td width="70%">Pindah Kavling</td>-->
  <!--          <td width="20%" align="center"><?=$pindah;?></td>-->
  <!--          <td width="20%" align="center"><a href="/dashboard_keuangan/detail_penjualan/pindah_kavling"> Detail Data <i class="fas fa-arrow-circle-right"></i></a></td>-->
  <!--        </tr>-->
  <!--        <tr>-->
  <!--          <td width="10%">3</td>-->
  <!--          <td width="70%">Ganti Nama</td>-->
  <!--          <td width="20%" align="center"><?=$gantiNama;?></td>-->
  <!--          <td width="20%" align="center"><a href="/dashboard_keuangan/detail_penjualan/ganti_nama"> Detail Data <i class="fas fa-arrow-circle-right"></i></a></td>-->
  <!--        </tr>-->
  <!--        <tr>-->
  <!--          <td width="10%">4</td>-->
  <!--          <td width="70%">Pembatalan</td>-->
  <!--          <td width="20%" align="center"><?=$pembatalan;?></td>-->
  <!--          <td width="20%" align="center"><a href="/dashboard_keuangan/detail_penjualan/batal"> Detail Data <i class="fas fa-arrow-circle-right"></i></a></td>-->
  <!--        </tr>-->
  <!--        <tr>-->
  <!--          <td colspan="2" align="right">Total</td>-->
  <!--          <td colspan="2" width="20%" align="center"><?=$pembatalan + $gantiNama + $pindah + $spr;?></td>-->
  <!--        </tr>-->
  <!--      </table>-->
</div>
</div>
</div>
        



          </div>
          
          <!-- /.col -->
        </div>
        
      </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->




<?php  $this->load->view('template/footer'); ?>

