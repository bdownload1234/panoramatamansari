<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?=konf()['nama_perusahaan'];?></title>

    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">


        <!-- Font Awesome -->   
        <link rel="icon" type="image/png" href="<?=base_url('assets/aplikasi/'.konfigMedia('Vavicon')['nama_file']);?>"/>
        <link rel="stylesheet" href="<?= base_url('theme_admin/'); ?>plugins/fontawesome-free/css/all.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!-- SweetAlert2 -->
        <link rel="stylesheet" href="<?= base_url('theme_admin/'); ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
        <!-- Toastr -->
        <link rel="stylesheet" href="<?= base_url('theme_admin/'); ?>plugins/toastr/toastr.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?= base_url('theme_admin/'); ?>dist/css/adminlte.min.css">
        <!-- Google Font: Source Sans Pro -->
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

      
        <link href="<?=base_url('theme_admin/plugins/datatables/jquery.dataTables.min.css');?>" rel="stylesheet">
        <link href="<?=base_url('theme_admin/dist/css/Lobibox.min.css');?>" rel="stylesheet" />
        <link href="<?=base_url('theme_admin/dist/css/jquery-confirm.min.css'); ?>" rel="stylesheet">





</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">

<?php 
$menuAktif = $this->uri->segment(1);
?>
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-blue navbar-dark">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                </li>

            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="<?=base_url();?>">
                    <?php echo $this->encryption->decrypt($this->session->userdata('email'));?>
                    </a>

                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <?php 
            $konf = $this->db->get_where('konfigurasi', array('id'=>'1'))->row_array();
            ?>
            <a href="<?= base_url(); ?>" class="brand-link">
                <img src="<?=base_url('assets/aplikasi/'.konfigMedia('Vavicon')['nama_file']);?>" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light"><strong>Customer</strong></span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user (optional) -->

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">


                        <li class="nav-item">
                            <a href="<?= base_url('dashboardcustomer'); ?>" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="<?= base_url('profile'); ?>" class="nav-link">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    Profile
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="<?= base_url('logincustomer/logout'); ?>" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    Keluar
                                </p>
                            </a>
                        </li>

                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>