  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Realisasi MK</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard'); ?>">Home</a></li>
              <li class="breadcrumb-item active">Customer</li>
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
              <h3 class="card-title">Realisasi MK</h3>
                  <div class="card-tools">
                      <!-- make a daterange picker for export to excel  -->
                    <input type="text" name="export_range" id="export_range">
                    &nbsp;
                    <!-- <a href="<?=base_url('realisasi_mk/excel');?>" target="_blank" class="btn btn-info btn-sm" >Download Data Excel</a>&nbsp; -->
                    <button type="button" class="btn btn-info btn-sm" id="btnExport">Download Data Excel</button>
                    <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modalAdd">
                        Tambah Data
                    </button>
                    &nbsp;
                  </div>
                  <!-- /.card-tools -->
            </div>
    
            <!-- /.card-header -->
            <div class="card-body">
            <div class="table-responsive">
            
               <table id="table" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Nomor Akad</th>
                            <th>Tanggal Akad</th>
                            <th width="20%">Nama Customer</th>
                            <th>Nama Bank</th>
                            <th>Blok Kavling</th>
                            <th>Realisasi MK</th>
                            <th>Pencairan</th>
                            <th>Dana Blokir Progress Bangunan 1</th>
                            <th>Dana Blokir Progress Bangunan 2</th>
                            <th>Dana Blokir Sertifikat</th>
                            <th>Dana Blokir IMB</th>
                            <th>Dana Blokir Bestek</th>
                            <th>Dana Blokir Listrik</th>
                            <th>Dana Blokir PPJB</th>
                            <th>Dana Blokir BPHTB</th>
                            <th>Dana Blokir PBB</th>
                            <th>Dana Lain-Lain</th>
                            <th>Status</th>
                            <th width="10%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $no = 1;
                            foreach($data as $key => $datax){
                                if(($datax->realisasi_mk-$datax->pencairan) == 0){
                                    $status = 'Lunas';
                                }else{
                                    $status = 'Belum Lunas';
                                }
                                echo '
                                    <tr>
                                        <td>'.$datax->no_akad.'</td>
                                        <td>'.$datax->tanggal_akad.'</td>
                                        <td>'.$datax->nama_lengkap.'</td>
                                        <td>'.$datax->nama_bank.'</td>
                                        <td>'.$datax->kode_kavling.'</td>
                                        <td>'.number_format($datax->realisasi_mk, 2).'</td>
                                        <td>'.number_format($datax->pencairan, 2).'</td>
                                        <td>'.number_format($datax->dana_blokir_progress_bangunan_1, 2).'</td>
                                        <td>'.number_format($datax->dana_blokir_progress_bangunan_2, 2).'</td>
                                        <td>'.number_format($datax->dana_blokir_sertifikat, 2).'</td>
                                        <td>'.number_format($datax->dana_blokir_imb, 2).'</td>
                                        <td>'.number_format($datax->dana_blokir_bestek, 2).'</td>
                                        <td>'.number_format($datax->dana_blokir_listrik, 2).'</td>
                                        <td>'.number_format($datax->dana_blokir_ppjb, 2).'</td>
                                        <td>'.number_format($datax->dana_blokir_bphtb, 2).'</td>
                                        <td>'.number_format($datax->dana_blokir_pbb, 2).'</td>
                                        <td>'.number_format($datax->dana_dll, 2).'</td>
                                        <td>'.$status.'</td>
                                        <td><button type="button" class="btn btn-warning btnEdit" data-id="'.$datax->id.'">Edit</button></td>
                                    </tr>
                                ';
                                $no++;
                            }
                        ?>
                    </tbody>
                </table>
    
              </div>
              </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
    </section>
    
<!-- Modal -->
<div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Data Realisasi MK</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form id="formRealisasiMk">
                <div class="form-group">
                    <label for="">Nama Customer</label>
                    <input name="id_customer" id="id_customer" class="form-control" type="text" required>
                </div>
                <div class="form-group">
                    <label for="">Tanggal Akad</label>
                    <input type="date" class="form-control" name="tanggal_akad" id="tanggal_akad" disabled>
                </div>
                <div class="form-group">
                    <label for="">Harga Jual Cash</label>
                    <input type="text" class="form-control" name="harga_jual_cash" id="harga_jual_cash" value="0" disabled>
                </div>
                <div class="form-group">
                    <label for="">Harga Jual Kredit</label>
                    <input type="text" class="form-control" name="harga_jual_kredit" id="harga_jual_kredit" value="0" disabled>
                </div>
                <div class="form-group">
                    <label for="">Blok Kavling</label>
                    <input type="hidden" class="form-control" name="id_blok" id="id_blok" readonly>
                    <input type="text" class="form-control" name="kode_blok" id="kode_blok" readonly>
                </div>
                <div class="form-group">
                    <label for="">Bank</label>
                    <select name="bank" id="bank" class="form-control" required>
                        <option value="">Pilih Bank</option>
                        <?php
                            foreach($bank as $key => $datax){
                                echo '<option value="'.$datax->id_bank.'">'.$datax->nama_bank.'</option>';
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Realisasi MK</label>
                    <input type="text" class="form-control" name="realisasi_mk" id="realisasi_mk" value="0" required>
                </div>
                <table id="table_pencairan" class="table table-bordered">
                    <thead>
                        <tr>
                            <th><button type="button" class="btn btn-sm btn-success" id="btnTambahPencairan" title="tambah">Tambah</button></th>
                            <th>Jenis Pencairan</th>
                            <th>Nominal</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td>
                                <select name="jenis_pencairan[]" id="jenis_pencairan" class="form-control jenis_pencairan" required>
                                    <option value="">Pilih Jenis Pencairan</option>
                                    <option value="1">Progress Bangunan 1</option>
                                    <option value="2">Progress Bangunan 2</option>
                                    <option value="3">Sertifikat</option>
                                    <option value="4">IMB</option>
                                    <option value="5">Bestek</option>
                                    <option value="6">Listrik</option>
                                    <option value="7">PPJB</option>
                                    <option value="8">BPHTB</option>
                                    <option value="9">PBB</option>
                                    <option value="10">Lain-lain</option>
                                </select>

                                <input type="text" name="jenis_pencairan_lain[]" id="jenis_pencairan_lain" class="form-control jenis_pencairan_lain" style="display:none;" placeholder="Tulis Jenis Pencairan Lain">
                            </td>
                            <td><input type="text" class="form-control pencairan" name="pencairan[]" id="pencairan1" value="0" required></td>
                            <td><input type="date" class="form-control tanggal_pencairan" name="tanggal_pencairan[]" id="tanggal_pencairan1" required></td>
                        </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <label for="">Dana Blokir Progress Bangunan 1</label>
                    <input type="text" class="form-control" name="dana_blokir_progress_bangunan_1" id="dana_blokir_progress_bangunan_1" value="0" required>
                </div>
                <div class="form-group">
                    <label for="">Dana Blokir Progress Bangunan 2</label>
                    <input type="text" class="form-control" name="dana_blokir_progress_bangunan_2" id="dana_blokir_progress_bangunan_2" value="0" required>
                </div>
                <div class="form-group">
                    <label for="">Dana Blokir Sertifikat</label>
                    <input type="text" class="form-control" name="dana_blokir_sertifikat" id="dana_blokir_sertifikat" value="0" required>
                </div>
                <div class="form-group">
                    <label for="">Dana Blokir IMB</label>
                    <input type="text" class="form-control" name="dana_blokir_imb" id="dana_blokir_imb" value="0" required>
                </div>
                <div class="form-group">
                    <label for="">Dana Blokir Bestek</label>
                    <input type="text" class="form-control" name="dana_blokir_bestek" id="dana_blokir_bestek" value="0" required>
                </div>
                <div class="form-group">
                    <label for="">Dana Blokir Listrik</label>
                    <input type="text" class="form-control" name="dana_blokir_listrik" id="dana_blokir_listrik" value="0" required>
                </div>
                <div class="form-group">
                    <label for="">Dana Blokir PPJB</label>
                    <input type="text" class="form-control" name="dana_blokir_ppjb" id="dana_blokir_ppjb" value="0" required>
                </div>
                <div class="form-group">
                    <label for="">Dana Blokir BPHTB</label>
                    <input type="text" class="form-control" name="dana_blokir_bphtb" id="dana_blokir_bphtb" value="0" required>
                </div>
                <div class="form-group">
                    <label for="">Dana Blokir PBB</label>
                    <input type="text" class="form-control" name="dana_blokir_pbb" id="dana_blokir_pbb" value="0" required>
                </div>
                <div class="form-group">
                    <label for="">Dana Lain-lain</label>
                    <input type="text" class="form-control" name="dana_dll" id="dana_dll" value="0" required>
                </div>
            </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btnSave">Save</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Data Realisasi MK</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form id="formRealisasiMkEdit">
                <div class="form-group">
                    <label for="">Nama Customer</label>
                    <input name="id_customer" id="id_customer_edit" class="form-control" type="text" required>
                </div>
                <div class="form-group">
                    <label for="">Tanggal Akad</label>
                    <input type="date" class="form-control" name="tanggal_akad" id="tanggal_akad_edit" disabled>
                </div>
                <div class="form-group">
                    <label for="">Harga Jual Cash</label>
                    <input type="text" class="form-control" name="harga_jual_cash_edit" id="harga_jual_cash_edit" value="0" disabled>
                </div>
                <div class="form-group">
                    <label for="">Harga Jual Kredit</label>
                    <input type="text" class="form-control" name="harga_jual_kredit_edit" id="harga_jual_kredit_edit" value="0" disabled>
                </div>
                <div class="form-group">
                    <label for="">Blok Kavling</label>
                    <input type="hidden" class="form-control" name="id_blok" id="id_blok_edit" readonly>
                    <input type="text" class="form-control" name="kode_blok" id="kode_blok_edit" readonly>
                </div>
                <div class="form-group">
                    <label for="">Bank</label>
                    <select name="bank_edit" id="bank_edit" class="form-control" required>
                        <option value="">Pilih Bank</option>
                        <?php
                            foreach($bank as $key => $datax){
                                echo '<option value="'.$datax->id_bank.'">'.$datax->nama_bank.'</option>';
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Realisasi MK</label>
                    <input type="text" class="form-control" name="realisasi_mk" id="realisasi_mk_edit" value="0" required>
                </div>
                <table id="table_pencairan" class="table table-bordered">
                    <thead>
                        <tr>
                            <th><button type="button" class="btn btn-sm btn-success" id="btnTambahPencairanEdit" title="tambah">Tambah</button></th>
                            <th>Jenis Pencairan</th>
                            <th>Nominal</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td>
                                <select name="jenis_pencairan[]" id="jenis_pencairan" class="form-control jenis_pencairan" required>
                                    <option value="">Pilih Jenis Pencairan</option>
                                    <option value="1">Progress Bangunan 1</option>
                                    <option value="2">Progress Bangunan 2</option>
                                    <option value="3">Sertifikat</option>
                                    <option value="4">IMB</option>
                                    <option value="5">Bestek</option>
                                    <option value="6">Listrik</option>
                                    <option value="7">PPJB</option>
                                    <option value="8">BPHTB</option>
                                    <option value="9">PBB</option>
                                    <option value="10">Lain-lain</option>
                                </select>

                                <input type="text" name="jenis_pencairan_lain[]" id="jenis_pencairan_lain" class="form-control jenis_pencairan_lain" style="display:none;" placeholder="Tulis Jenis Pencairan Lain">
                            </td>
                            <td><input type="text" class="form-control pencairan" name="pencairan[]" id="pencairan_edit1" value="0" required></td>
                            <td><input type="date" class="form-control tanggal_pencairan" name="tanggal_pencairan[]" id="tanggal_pencairan_edit1" required></td>
                        </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <label for="">Dana Blokir Progress Bangunan 1</label>
                    <input type="text" class="form-control" name="dana_blokir_progress_bangunan_1" id="dana_blokir_progress_bangunan_1_edit" value="0" required>
                </div>
                <div class="form-group">
                    <label for="">Dana Blokir Progress Bangunan 2</label>
                    <input type="text" class="form-control" name="dana_blokir_progress_bangunan_2" id="dana_blokir_progress_bangunan_2_edit" value="0" required>
                </div>
                <div class="form-group">
                    <label for="">Dana Blokir Sertifikat</label>
                    <input type="text" class="form-control" name="dana_blokir_sertifikat" id="dana_blokir_sertifikat_edit" value="0" required>
                </div>
                <div class="form-group">
                    <label for="">Dana Blokir IMB</label>
                    <input type="text" class="form-control" name="dana_blokir_imb" id="dana_blokir_imb_edit" value="0" required>
                </div>
                <div class="form-group">
                    <label for="">Dana Blokir Bestek</label>
                    <input type="text" class="form-control" name="dana_blokir_bestek" id="dana_blokir_bestek_edit" value="0" required>
                </div>
                <div class="form-group">
                    <label for="">Dana Blokir Listrik</label>
                    <input type="text" class="form-control" name="dana_blokir_listrik" id="dana_blokir_listrik_edit" value="0" required>
                </div>
                <div class="form-group">
                    <label for="">Dana Blokir PPJB</label>
                    <input type="text" class="form-control" name="dana_blokir_ppjb" id="dana_blokir_ppjb_edit" value="0" required>
                </div>
                <div class="form-group">
                    <label for="">Dana Blokir BPHTB</label>
                    <input type="text" class="form-control" name="dana_blokir_bphtb" id="dana_blokir_bphtb_edit" value="0" required>
                </div>
                <div class="form-group">
                    <label for="">Dana Blokir PBB</label>
                    <input type="text" class="form-control" name="dana_blokir_pbb" id="dana_blokir_pbb_edit" value="0" required>
                </div>
                <div class="form-group">
                    <label for="">Dana Lain-lain</label>
                    <input type="text" class="form-control" name="dana_dll" id="dana_dll_edit" value="0" required>
                </div>
            </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-warning" id="btnUpdate">Update</button>
      </div>
    </div>
  </div>
</div>
    
<?php  $this->load->view('template/footer'); ?>
<script src="<?php echo base_url('theme_admin/plugins/select2/select2.min.js')?>"></script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('theme_admin/plugins/select2/select2.css') ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('theme_admin/plugins/select2/select2-bootstrap.css') ?>">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.8/jquery.mask.min.js" integrity="sha512-hAJgR+pK6+s492clbGlnrRnt2J1CJK6kZ82FZy08tm6XG2Xl/ex9oVZLE6Krz+W+Iv4Gsr8U2mGMdh0ckRH61Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/moment/min/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script>
    var url_apps = "<?=base_url();?>";
    
    function formatRupiah(angka, prefix){
    	var number_string = angka.replace(/[^,\d]/g, '').toString(),
    	split   		= number_string.split(','),
    	sisa     		= split[0].length % 3,
    	rupiah     		= split[0].substr(0, sisa),
    	ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
     
    	// tambahkan titik jika yang di input sudah menjadi angka ribuan
    	if(ribuan){
    		separator = sisa ? ',' : '';
    		rupiah += separator + ribuan.join(',');
    	}
     
    	rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    	return prefix == undefined ? rupiah : (rupiah ? rupiah : '');
    }
    
    $(document).ready(function(){
        $('#table').DataTable();

        // export_range datepicker
        $('#export_range').daterangepicker({
            locale: {
                format: 'YYYY-MM-DD'
            }
        });

        $('#btnExport').on('click', function(){
            var range = $('#export_range').val();
            window.location.href = url_apps + 'realisasi_mk/excel?range=' + range;
        })
        
        $("#id_customer, #id_customer_edit").select2({
            ajax: {
              url: url_apps + 'realisasi_mk/ajax_select_customer',
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
        $("#id_customer, #id_customer_edit").on('change', function(){
            var id_customer = $(this).val();
            $.ajax({
                url : url_apps + 'cicilan_dp/ajax_change_customer',
                type: "GET",
                data:{
                  id_customer:id_customer,  
                },
                dataType: "JSON",
                success: function(data)
                {
                    var data_customer = data.data_customer;
                    var data_kavling = data.data_kavling;
                    var data_akad = data.data_akad;
                    $('#id_blok').val(data_kavling.id_kavling)
                    $('#id_blok_edit').val(data_kavling.id_kavling)
                    $('#kode_blok').val(data_kavling.kode_kavling)
                    $('#kode_blok_edit').val(data_kavling.kode_kavling)
                    $('#harga_jual_ajb_kredit').val(formatRupiah(data_kavling.harga_jual_ajb, ''))
                    $('#harga_jual_ajb_kredit_edit').val(formatRupiah(data_kavling.harga_jual_ajb, ''))
                    $('#tanggal_akad').val(!data_akad ? '' : data_akad.tanggal)
                    $('#tanggal_akad_edit').val(!data_akad ? '' : data_akad.tanggal)
                    $('#harga_jual_cash').val(formatRupiah(data_kavling.harga_jual_ajb, ''))
                    $('#harga_jual_cash_edit').val(formatRupiah(data_kavling.harga_jual_ajb, ''))

                    $('#harga_jual_kredit').val(formatRupiah(data_kavling.hrg_jual, ''))
                    $('#harga_jual_kredit_edit').val(formatRupiah(data_kavling.hrg_jual, ''))
                }
            })
        })
        
        $('#realisasi_mk, #dana_blokir_progress_bangunan_1, #dana_blokir_progress_bangunan_2, #dana_blokir_sertifikat, #dana_blokir_imb, #dana_blokir_bestek, #dana_blokir_ppjb, #dana_blokir_bphtb, #dana_blokir_pbb, #dana_dll, .pencairan').mask('000,000,000,000,000', {
            reverse:true
        })
        $('#realisasi_mk_edit, #dana_blokir_progress_bangunan_1_edit, #dana_blokir_progress_bangunan_2_edit, #dana_blokir_sertifikat_edit, #dana_blokir_imb_edit, #dana_blokir_bestek_edit, #dana_blokir_ppjb_edit, #dana_blokir_bphtb_edit, #dana_blokir_pbb_edit, #dana_dll_edit, .pencairan').mask('000,000,000,000,000', {
            reverse:true
        })
        
        $('#btnTambahPencairan').on('click', function(){
            var html = `<tr>
                            <td><button type="button" class="btn btn-sm btn-danger btnHapusPencairan" id="" title="delete">Hapus</button></td>
                            <td>
                                <select name="jenis_pencairan[]" id="jenis_pencairan" class="form-control jenis_pencairan" required>
                                    <option value="">Pilih Jenis Pencairan</option>
                                    <option value="1">Progress Bangunan 1</option>
                                    <option value="2">Progress Bangunan 2</option>
                                    <option value="3">Sertifikat</option>
                                    <option value="4">IMB</option>
                                    <option value="5">Bestek</option>
                                    <option value="6">Listrik</option>
                                    <option value="7">PPJB</option>
                                    <option value="8">BPHTB</option>
                                    <option value="9">PBB</option>
                                    <option value="10">Lain-lain</option>
                                </select>

                                <input type="text" name="jenis_pencairan_lain[]" id="jenis_pencairan_lain" class="form-control jenis_pencairan_lain" style="display:none;" placeholder="Tulis Jenis Pencairan Lain">
                            </td>
                            <td><input type="text" class="form-control pencairan" name="pencairan[]" id="" value="0" required></td>
                            <td><input type="date" class="form-control tanggal_pencairan" name="tanggal_pencairan[]" id="" required></td>
                        </tr>`;
            $('#formRealisasiMk #table_pencairan').append(html);
            
            $('.pencairan').mask('000,000,000,000,000', {
            reverse:true
            })
        })

        // Event delegation to handle change event on dynamically added select elements
        $('#formRealisasiMk #table_pencairan').on('change', '.jenis_pencairan', function() {
            var otherInput = $(this).closest('td').find('.jenis_pencairan_lain');
            console.log("ligmaballs")
            
            if ($(this).val() === '10') {
                otherInput.show(); // Show the text input
                otherInput.prop('required', true); // Make it required
            } else {
                otherInput.hide(); // Hide the text input
                otherInput.prop('required', false); // Remove the required attribute
            }
        });

        $('#btnTambahPencairanEdit').on('click', function(){
            var html = `<tr>
                            <td><button type="button" class="btn btn-sm btn-danger btnHapusPencairan" id="" title="delete">Hapus</button></td>
                            <td>
                                <select name="jenis_pencairan[]" id="jenis_pencairan" class="form-control jenis_pencairan" required>
                                    <option value="">Pilih Jenis Pencairan</option>
                                    <option value="1">Progress Bangunan 1</option>
                                    <option value="2">Progress Bangunan 2</option>
                                    <option value="3">Sertifikat</option>
                                    <option value="4">IMB</option>
                                    <option value="5">Bestek</option>
                                    <option value="6">Listrik</option>
                                    <option value="7">PPJB</option>
                                    <option value="8">BPHTB</option>
                                    <option value="9">PBB</option>
                                    <option value="10">Lain-lain</option>
                                </select>

                                <input type="text" name="jenis_pencairan_lain[]" id="jenis_pencairan_lain" class="form-control jenis_pencairan_lain" style="display:none;" placeholder="Tulis Jenis Pencairan Lain">
                            </td>
                            <td><input type="text" class="form-control pencairan" name="pencairan_edit[]" id="" value="0" required></td>
                            <td><input type="date" class="form-control tanggal_pencairan" name="tanggal_pencairan[]" id="" required></td>
                        </tr>`;
            $('#formRealisasiMkEdit #table_pencairan').append(html);
            
            $('.pencairan').mask('000,000,000,000,000', {
            reverse:true
            })
        })
        
        $(this).on('click', '.btnHapusPencairan', function(){
            $(this).closest('td').closest('tr').remove()
        })
        
        $('#btnSave').on('click', function(){
            var form = document.getElementById('formRealisasiMk'); 
            var formData = new FormData(form); 
            
            $.ajax({ 
                url: url_apps + 'realisasi_mk/store',
                method: 'POST', 
                data: formData, 
                processData: false, 
                contentType: false, 
                dataType: "JSON",
                success: function (response) {
                    console.log(response);
                    if(response.status == true){
                        alert('Your form has been sent successfully.'); 
                        location.reload(true)
                    }else{
                        alert('Error.'); 
                    }
                }, 
            }); 
        })
        
        $(this).on('click', '.btnEdit', function(){
            $('#modalEdit').modal('show');
            var id = $(this).attr('data-id');
            
            $.ajax({
                url: url_apps + 'realisasi_mk/get_data',
                method: 'GET', 
                data: {
                    id:id
                }, 
                dataType: "JSON",
                success: function (response) {
                    // $('#btnSave').hide();
                    // $('#btnUpdate').show();
                    var data = response.data[0];
                    $("#formRealisasiMkEdit #id_customer_edit").attr('disabled', true)
                    $("#formRealisasiMkEdit #id_customer_edit").select2('data', { id:data.id_customer, text: data.nama_lengkap}).trigger('change');
                    $('#formRealisasiMkEdit #realisasi_mk_edit').before(`<input type="hidden" value="`+data.id+`" name="id" style="display: none">`)
                    $('#formRealisasiMkEdit #realisasi_mk_edit').val(formatRupiah(data.realisasi_mk, ''))
                    $('#formRealisasiMkEdit #dana_blokir_progress_bangunan_1_edit').val(formatRupiah(data.dana_blokir_progress_bangunan_1, ''))
                    $('#formRealisasiMkEdit #dana_blokir_progress_bangunan_2_edit').val(formatRupiah(data.dana_blokir_progress_bangunan_2, ''))
                    $('#formRealisasiMkEdit #dana_blokir_sertifikat_edit').val(formatRupiah(data.dana_blokir_sertifikat, ''))
                    $('#formRealisasiMkEdit #dana_blokir_imb_edit').val(formatRupiah(data.dana_blokir_imb, ''))
                    $('#formRealisasiMkEdit #dana_blokir_bestek_edit').val(formatRupiah(data.dana_blokir_bestek, ''))
                    $('#formRealisasiMkEdit #dana_blokir_listrik_edit').val(formatRupiah(data.dana_blokir_listrik, ''))
                    $('#formRealisasiMkEdit #dana_blokir_ppjb_edit').val(formatRupiah(data.dana_blokir_ppjb, ''))
                    $('#formRealisasiMkEdit #dana_blokir_bphtb_edit').val(formatRupiah(data.dana_blokir_bphtb, ''))
                    $('#formRealisasiMkEdit #dana_blokir_pbb_edit').val(formatRupiah(data.dana_blokir_pbb, ''))
                    $('#formRealisasiMkEdit #dana_dll_edit').val(formatRupiah(data.dana_dll, ''))
                    $('#formRealisasiMkEdit #bank_edit').val(data.bank_id).trigger('change');
                    $('#formRealisasiMkEdit #tanggal_akad_edit').val(data.tanggal_akad)
                    
                    $('#formRealisasiMkEdit #table_pencairan tbody tr').remove();
                    for(var i=0; i < response.data_dt.length; i++){
                        var pencairan = formatRupiah((response.data_dt[i].pencairan), '');
                        var html = `
                        <tr>
                            <td></td>
                            <td>
                                <select name="jenis_pencairan[]" id="jenis_pencairan" class="form-control jenis_pencairan" required>
                                    <option value="">Pilih Jenis Pencairan</option>
                                    <option value="1" `+(response.data_dt[i].pencairan_id == 1 ? 'selected' : '')+`>Progress Bangunan 1</option>
                                    <option value="2" `+(response.data_dt[i].pencairan_id == 2 ? 'selected' : '')+`>Progress Bangunan 2</option>
                                    <option value="3" `+(response.data_dt[i].pencairan_id == 3 ? 'selected' : '')+`>Sertifikat</option>
                                    <option value="4" `+(response.data_dt[i].pencairan_id == 4 ? 'selected' : '')+`>IMB</option>
                                    <option value="5" `+(response.data_dt[i].pencairan_id == 5 ? 'selected' : '')+`>Bestek</option>
                                    <option value="6" `+(response.data_dt[i].pencairan_id == 6 ? 'selected' : '')+`>Listrik</option>
                                    <option value="7" `+(response.data_dt[i].pencairan_id == 7 ? 'selected' : '')+`>PPJB</option>
                                    <option value="8" `+(response.data_dt[i].pencairan_id == 8 ? 'selected' : '')+`>BPHTB</option>
                                    <option value="9" `+(response.data_dt[i].pencairan_id == 9 ? 'selected' : '')+`>PBB</option>
                                    <option value="10" `+(response.data_dt[i].pencairan_id == 10 ? 'selected' : '')+`>Lain-lain</option>
                                </select>

                                <input type="text" name="jenis_pencairan_lain[]" id="jenis_pencairan_lain" class="form-control jenis_pencairan_lain" style="display:none;" placeholder="Tulis Jenis Pencairan Lain">
                            </td>
                            <td><input type="text" class="form-control pencairan" name="pencairan_edit[]" id="pencairan_edit`+(i+1)+`" value="`+pencairan+`" required></td>
                            <td><input type="date" class="form-control tanggal_pencairan" name="tanggal_pencairan[]" id="tanggal_pencairan_edit`+(i+1)+`" value="`+response.data_dt[i].tanggal_pencairan+`" required></td>
                        </tr>
                        `;
                        $('#formRealisasiMkEdit #table_pencairan tbody').append(html)
                    }
                    
                },   
            })
        })
        
        $('#btnUpdate').on('click', function(){
            var form = document.getElementById('formRealisasiMkEdit'); 
            var formData = new FormData(form); 
            
            $.ajax({ 
                url: url_apps + 'realisasi_mk/update',
                method: 'POST', 
                data: formData, 
                processData: false, 
                contentType: false, 
                dataType: "JSON",
                success: function (response) {
                    console.log(response);
                    if(response.status == true){
                        alert('Your form has been sent successfully.'); 
                        location.reload(true)
                    }else{
                        alert('Error.'); 
                    }
                }, 
            }); 
        })
    })
</script>