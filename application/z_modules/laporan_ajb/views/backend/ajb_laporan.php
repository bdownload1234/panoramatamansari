<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"><?= $title; ?></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard'); ?>">Home</a></li>
                        <li class="breadcrumb-item active"><?= $title; ?></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->



    <!-- Main content -->
    <section class="content">
        <div class="card">
            <div class="card-header">

                <h3 class="card-title">Laporan AJB</h3>
                <div class="card-tools">
                    <a href="<?= base_url('ajb_laporan/export'); ?>" class="btn btn-info btn-sm" onclick="add()"><i class="fa fa-print"></i> Excel</a>&nbsp;
                </div>

                <div class="ibox-title">
                    <?php if ($this->session->userdata('message') != '') { ?>
                        <div class="alert alert-success alert-dismissable">
                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                            <?= $this->session->userdata('message') ?> <a class="alert-link" href="#"></a>
                        </div>
                    <?php } ?>
                </div>

                <!-- /.card-tools -->
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <form action="<?php echo site_url('ajb_laporan/filter'); ?>" method="post">
                            <div class="form-group">
                                <div class="col-md-4">
                                    <label for="start_date">Tanggal Awal:</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date">
                                </div>
                                <div class="col-md-4">
                                    <label for="end_date">Tanggal Akhir:</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-4">
                                    <div class="float-right">
                                        <a href="<?= base_url('ajb_laporan'); ?>" class="btn btn-secondary">Clear</a>
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <!-- /.card-header -->
            <div class="card-body">

                <table id="Table" class="dataTable table-bordered table-hover table-condensed" style="margin-bottom: 10px">
                    <thead class="thead-light">
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">SKP</th>
                            <th class="text-center">Tanggal</th>
                            <th class="text-center">Customer</th>
                            <th class="text-center">Notaris</th>
                            <th class="text-center">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody><?php
                            foreach ($ajb_data as $ajb) {
                            ?>
                            <tr>
                                <td style="text-align:center" width="40px"><?php echo ++$start ?></td>
                                <td><?php echo $ajb->nomor_skp ?></td>
                                <td><?php echo $ajb->tanggal_ajb ?></td>
                                <td><?php echo $ajb->nama_lengkap ?></td>
                                <td><?php echo $ajb->notaris ?></td>
                                <td><?php echo $ajb->keterangan_ajb ?></td>
                            </tr>

                        <?php
                            }
                        ?>
                    </tbody>
                </table>

            </div>
        </div>
</div>


<!-- End Bootstrap modal -->