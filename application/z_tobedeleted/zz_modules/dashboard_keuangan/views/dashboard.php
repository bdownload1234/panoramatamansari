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

$kavling = $this->db->query("SELECT COUNT(*) as jum FROM kavling_peta")->row_array();
$book = $this->db->query("SELECT COUNT(*) as jum FROM kavling_peta WHERE status='1'")->row_array();
$cash = $this->db->query("SELECT COUNT(*) as jum FROM kavling_peta WHERE status='2'")->row_array();
$kredit = $this->db->query("SELECT COUNT(*) as jum FROM kavling_peta WHERE status='3'")->row_array();
$ready = $this->db->query("SELECT COUNT(*) as jum FROM kavling_peta WHERE status='0'")->row_array();

?>

<div class="row">

          <div class="col-md-12">
            <div class="row">
          <div class="col-lg-4 col-4">
            <!-- small box -->
            <div class="small-box bg-primary">
              <div class="inner">
                <h3><?=$kavling['jum'];?> / <?=$ready['jum'];?></h3>

                <p>HOLD</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="#" class="small-box-footer">Detail Data <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-4 col-4">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?=$cash['jum'];?></h3>

                <p>AVAIABLE</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">Detail Data <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          
          <div class="col-lg-4 col-4">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><?=$book['jum'];?></h3>

                <p>PRE ORDER / NUP</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->

          <div class="col-lg-4 col-4">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?=$kredit['jum'];?></h3>

                <p>TERBOOKIN</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->

          <div class="col-lg-4 col-4">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?=$kreditProses['jum'];?></h3>

                <p>SUDAH AKAD</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->

          <div class="col-lg-4 col-4">
            <!-- small box -->
            <div class="small-box bg-secondary">
              <div class="inner">
                <h3><?=$kreditSelesai['jum'];?></h3>

                <p>STANDART</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->

          <div class="col-lg-4 col-4">
            <!-- small box -->
            <div class="small-box bg-secondary">
              <div class="inner">
                <h3><?=$kreditSelesai['jum'];?></h3>

                <p>KHUSUS</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->

        </div>
        <!-- /.row -->



          </div>
          
          <!-- /.col -->
        </div>
        
      </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->






<?php  $this->load->view('template/footer'); ?>