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
$hold = $this->db->query("SELECT COUNT(*) as jum FROM kavling_peta WHERE stt_stok='0'")->row_array();
$avaiable = $this->db->query("SELECT COUNT(*) as jum FROM kavling_peta WHERE stt_stok='1'")->row_array();
$nup = $this->db->query("SELECT COUNT(*) as jum FROM kavling_peta WHERE stt_stok='2'")->row_array();
$ready = $this->db->query("SELECT COUNT(*) as jum FROM kavling_peta WHERE stt_stok='3'")->row_array();

$terboking = $this->db->query("SELECT COUNT(*) as jum FROM kavling_peta WHERE stt_stok='4'")->row_array();
$sudahAkad = $this->db->query("SELECT COUNT(*) as jum FROM kavling_peta WHERE stt_stok='5'")->row_array();
$standart = $this->db->query("SELECT COUNT(*) as jum FROM kavling_peta WHERE stt_stok='6'")->row_array();
$khusus = $this->db->query("SELECT COUNT(*) as jum FROM kavling_peta WHERE stt_stok='7'")->row_array();

?>

<!-- Small boxes (Stat box) -->

<div class="row">
    <div class="col-md-12">
        <div class="row">


          <div class="col-lg-3 col-4">
            <!-- small box -->
            <div class="small-box bg-primary">
              <div class="inner">
                <h3><?=$unit['jum'];?></h3>

                <p>UNIT</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="#" class="small-box-footer">Detail Data <i class="fas fa-arrow-circle-right"></i></a>
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
                <i class="ion ion-bag"></i>
              </div>
              <a href="#" class="small-box-footer">Detail Data <i class="fas fa-arrow-circle-right"></i></a>
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
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">Detail Data <i class="fas fa-arrow-circle-right"></i></a>
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
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
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
                <i class="ion ion-person-add"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
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
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->

          <div class="col-lg-3 col-4">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?=$standart['jum'];?></h3>

                <p>STANDART</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->

          <div class="col-lg-3 col-4">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?=$khusus['jum'];?></h3>

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


<script type="text/javascript">

function lihatdetail(id)
   {
       $('#modal_form').modal('show'); // show bootstrap modal
       $('.modal-title').text('Tambah Konten'); // Set Title to Bootstrap modal title
       $("#detail").load('<?php echo base_url('dashboard_keuangan/detail/');?>'+ id);
   }
</script>


<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">header</h3>
            </div>
            <div class="modal-body form">
                <div id="detail"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->