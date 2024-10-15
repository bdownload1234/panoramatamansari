<?php
//import koneksi ke database
?>
<html>

<head>
    <title>Laporan AJB</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url('assets/admin/'); ?>plugins/fontawesome-free/css/all.min.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
</head>



<body>
    <div class="card-header">
        <div class="float-center">
            <h2><a href="<?= base_url('dashboard'); ?>" class="btn btn-primary btn-md"><i class="fas fa-arrow-left"></i> Back</a> Laporan AJB</h2>
        </div>



        <div class="card-body">
            <div class="row">
                <div class="col">
                    <form action="<?php echo site_url('laporan_ajb/filter'); ?>" method="post">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="start_date">Tanggal Awal:</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date">
                                </div>
                                <div class="col-md-4">
                                    <label for="end_date">Tanggal Akhir:</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8">
                                <div class="float-right">
                                    <a href="<?= base_url('laporan_ajb'); ?>" class="btn btn-secondary">Clear</a>
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="data-tables datatable-dark">

            <!-- Masukkan table nya disini, dimulai dari tag TABLE -->
            <table id="mauexport" class="dataTable table-bordered table-hover table-condensed" style="margin-bottom: 10px">

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
                            <td><?php echo $ajb->nomor_skp ?> </td>
                            <td><?php echo $ajb->tanggal_ajb ?> </td>
                            <td><?php echo $ajb->nama_lengkap ?> <br>KTP-<?php echo $ajb->no_ktp ?></td>
                            <td><?php echo $ajb->notaris ?> </td>
                            <td><?php echo $ajb->keterangan_ajb ?> </td>
                        </tr>

                    <?php
                        }
                    ?>
                </tbody>
            </table>

        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#mauexport').DataTable({
                "pageLength": 1000,
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'excelHtml5',
                        orientation: 'landscape',
                        exportOptions: {
                            modifier: {
                                page: 'current'
                            }
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        orientation: 'landscape',
                        exportOptions: {
                            modifier: {
                                page: 'current'
                            }
                        }
                    },
                    {
                        extend: 'print',
                        orientation: 'landscape',
                        customize: function(win) {
                            $(win.document.body).find('table').addClass('display').css('font-size', '12px');
                            $(win.document.body).find('tr:nth-child(even) td').each(function(index) {
                                $(this).css('background-color', '#f5f5f5');
                            });
                            $(win.document.body).find('h1').css('text-align', 'center');
                        },
                        exportOptions: {
                            modifier: {
                                page: 'current'
                            }
                        }
                    }
                ]
            });
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>



</body>

</html>