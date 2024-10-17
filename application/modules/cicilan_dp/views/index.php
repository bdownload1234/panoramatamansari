  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Cicilan DP</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard'); ?>">Home</a></li>
              <li class="breadcrumb-item active">Cicilan DP</li>
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
              <h3 class="card-title">Cicilan DP</h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-sm btn-success addData" data-toggle="modal" data-target="#modalAdd">
                        Tambah Data
                    </button>
                    &nbsp;
                    <a href="/cicilan_dp/download" target="_blank" class="btn btn-sm btn-info">Download Data</a>
                  </div>
                  <!-- /.card-tools -->
            </div>
    
            <!-- /.card-header -->
            <div class="card-body">
    
               <table id="table" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="20%">Nama Customer</th>
                            <th>Blok Kavling</th>
                            <th>Nominal Booking</th>
                            <th>Harga Jual</th>
                            <th>Harga Acc Bank</th>
                            <th>Sisa Kewajiban</th>
                            <th>Kekurangan</th>
                            <th>Status</th>
                            <th width="10%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach($data as $key => $datas){
                                // $sisa_kewajiban = ($datas->harga_jual_ajb-$datas->harga_acc_bank);
                                $sisa_kewajiban = ($datas->hrg_jual-$datas->harga_acc_bank);
                                $kekurangan = ($sisa_kewajiban-$datas->dp_1-$datas->dp_2-$datas->dp_3);
                                
                                $button = '';
                                if($kekurangan <> 0){
                                    $button .= '
                                    <button type="button" class="btn btn-sm btn-warning btnEdit" data-toggle="modal" data-target="#modalAdd" data-id="'.$datas->id.'">
                                        <i class="fa fa-edit"></i> Edit Data
                                    </button>
                                    ';
                                }
                                
                                echo '
                                    <tr>
                                    <td>'.($key+1).'</td>
                                    <td>'.$datas->nama_lengkap.'</td>
                                    <td>'.$datas->kode_kavling.'</td>
                                    <td>'.number_format($datas->nominal_booking, 2).'</td>
                                    <td>'.($datas->jenis_pembayaran == 1 ? number_format($datas->hrg_jual, 2) : number_format($datas->harga_jual_ajb, 2)).'</td>
                                    <td>'.number_format($datas->harga_acc_bank, 2).'</td>
                                    <td>'.number_format((($datas->jenis_pembayaran == 1 ? $datas->hrg_jual : $datas->harga_jual_ajb)-$datas->harga_acc_bank), 2).'</td>
                                    <td>'.number_format((($datas->jenis_pembayaran == 1 ? $datas->hrg_jual : $datas->harga_jual_ajb)-$datas->harga_acc_bank)-$datas->total_dp, 2).'</td>
                                    <td>'.(((($datas->jenis_pembayaran == 1 ? $datas->hrg_jual : $datas->harga_jual_ajb)-$datas->harga_acc_bank)-$datas->total_dp) == 0 ? "Lunas" : "Belum Lunas").'</td>
                                    <td>'.$button.'</td>
                                    </tr>
                                ';
                            }
                        ?>
                    </tbody>
                </table>
    
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
        <h5 class="modal-title" id="exampleModalLabel">Data cicilan DP</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form id="formCicilanDP">
                <div class="form-group">
                    <label for="">Nama Customer</label>
                    <input name="id_customer" id="id_customer" class="form-control" type="text" required>
                </div>
                <div class="form-group">
                    <label for="">Blok Kavling</label>
                    <input type="hidden" class="form-control" name="id_blok" id="id_blok" readonly>
                    <input type="text" class="form-control" name="kode_blok" id="kode_blok" readonly>
                </div>
                <div class="form-group">
                    <label for="">Jenis Pembayaran</label>
                    <select class="form-control" name="jenis_pembayaran" id="jenis_pembayaran">
                        <option value="1">Kredit</option>
                        <option value="2">Cash</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Nominal Booking</label>
                    <input type="text" class="form-control" name="nominal_booking" id="nominal_booking" value="0" required>
                </div>
                <div class="form-group">
                    <label for="">Harga Jual</label>
                    <input type="text" class="form-control" name="harga_jual_ajb_kredit" id="harga_jual_ajb_kredit" value="0"  readonly>
                </div>
                <div class="form-group">
                    <label for="">Harga Acc Bank</label>
                    <input type="text" class="form-control" name="harga_acc_bank" id="harga_acc_bank" value="0" required>
                </div>
                <div class="form-group">
                    <label for="">Sisa Kewajiban</label>
                    <input type="text" class="form-control" name="sisa_kewajiban" id="sisa_kewajiban" value="0" readonly>
                </div>

                <!-- Dynamic DP Section -->
                <label for="">DP</label>
                <table class="table table-bordered" id="dpTable">
                    <thead>
                        <tr>
                            <th>Tanggal DP</th>
                            <th>Nominal DP</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="date" class="form-control" name="tanggal_dp[]" required></td>
                            <td><input type="text" class="form-control dp" name="dp[]" value="0" required></td>
                            <td><button type="button" class="btn btn-danger removeRow">Hapus</button></td>
                        </tr>
                    </tbody>
                </table>
                <button type="button" class="btn btn-success" id="addDPRow">Tambahkan DP</button>

                <div class="form-group">
                    <label for="">Kekurangan</label>
                    <input type="text" class="form-control" name="kekurangan" id="kekurangan" value="0" readonly>
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

<?php  $this->load->view('template/footer'); ?>
<script src="<?php echo base_url('theme_admin/plugins/select2/select2.min.js')?>"></script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('theme_admin/plugins/select2/select2.css') ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('theme_admin/plugins/select2/select2-bootstrap.css') ?>">

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.8/jquery.mask.min.js" integrity="sha512-hAJgR+pK6+s492clbGlnrRnt2J1CJK6kZ82FZy08tm6XG2Xl/ex9oVZLE6Krz+W+Iv4Gsr8U2mGMdh0ckRH61Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    var url_apps = "<?=base_url();?>";

    // Add new DP row
    $('#addDPRow').on('click', function() {
        var newRow = `<tr>
                        <td><input type="date" class="form-control" name="tanggal_dp[]" required></td>
                        <td><input type="text" class="form-control dp" name="dp[]" value="0" required></td>
                        <td><button type="button" class="btn btn-danger removeRow">Hapus</button></td>
                      </tr>`;
        $('#dpTable tbody').append(newRow);
    });

    // Remove DP row with SweetAlert confirmation
    $(document).on('click', '.removeRow', function() {
        var row = $(this).closest('tr');
        
        // Check if it's the first row
        if (row.is(':first-child')) {
            alert("Baris pertama tidak bisa dihapus!");
        } else {
            row.remove();
        }

    });
    
    function formatRupiah(angka, prefix){
    	var number_string = angka.replace(/[^,\d]/g, '').toString(),
    	split   		= number_string.split(','),
    	sisa     		= split[0].length % 3,
    	rupiah     		= split[0].substr(0, sisa),
    	ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
     
    	if(ribuan){
    		separator = sisa ? ',' : '';
    		rupiah += separator + ribuan.join(',');
    	}
     
    	rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    	return prefix == undefined ? rupiah : (rupiah ? rupiah : '');
    }
    
    $(document).ready(function(){
        

        $('#table').DataTable();
        
        harga = [];

        // addData button click reset form
        $('.addData').on('click', function(){
            $('#formCicilanDP').trigger('reset');
            $('#dpTable tbody').html('');
            var newRow = `<tr>
                            <td><input type="date" class="form-control" name="tanggal_dp[]" required></td>
                            <td><input type="text" class="form-control dp" name="dp[]" value="0" required></td>
                            <td><button type="button" class="btn btn-danger removeRow">Hapus</button></td>
                          </tr>`;
            $('#dpTable tbody').append(newRow);
        })

        $(document).on('click', '.printDP', function(){
            var id = $(this).attr('id');
            window.open(url_apps + 'cicilan_dp/print/' + id, '_blank');
        })

        $('#jenis_pembayaran').on('change', function(){
            var jenis_pembayaran = $(this).val();
            if(jenis_pembayaran == 1){
                $('#harga_jual_ajb_kredit').val(formatRupiah(harga['hrg_jual'], ''))
            }else{
                $('#harga_jual_ajb_kredit').val(formatRupiah(harga['harga_jual_ajb'], ''))
            }
        })

        $("#id_customer").select2({
            ajax: {
              url: url_apps + 'cicilan_dp/ajax_select_customer',
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
        $("#id_customer").on('change', function(){
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

                    harga['hrg_jual'] = data_kavling.hrg_jual;
                    harga['harga_jual_ajb'] = data_kavling.harga_jual_ajb;

                    $('#id_blok').val(data_kavling.id_kavling)
                    $('#kode_blok').val(data_kavling.kode_kavling)

                    if($('#jenis_pembayaran').val() == 1){
                        $('#harga_jual_ajb_kredit').val(formatRupiah(data_kavling.hrg_jual, ''))
                    }else{
                        $('#harga_jual_ajb_kredit').val(formatRupiah(data_kavling.harga_jual_ajb, ''))
                    }
                }
            })
        })
        
        $('#nominal_booking, #harga_acc_bank, #sisa_kewajiban, #dp_1, #dp_2, #dp_3, #kekurangan').mask('000,000,000,000,000', {
            reverse:true
        })

        $('#harga_acc_bank').on('keyup', function(){
            var harga_acc_bank = ($(this).val()).replaceAll(',', '');
            var harga_jual_ajb_kredit = ($('#harga_jual_ajb_kredit').val()).replaceAll(',', '');
            
            var sisa_kewajiban = (harga_jual_ajb_kredit-harga_acc_bank);
            sisa_kewajiban = sisa_kewajiban.toString();
            $('#sisa_kewajiban').val(formatRupiah(sisa_kewajiban, ''));
        })
        
        $('#dpTable').on('keyup', '.dp', function(){
            // count the total DP
            console.log('DP');
            var total_dp = 0;
            $('.dp').each(function(){
                // if nan, set to 0
                total_dp += parseInt(($(this).val()).replaceAll(',', '')) || 0;

                console.log(total_dp);
            });

            var sisa_kewajiban = ($('#sisa_kewajiban').val()).replaceAll(',', '');
            var kekurangan = (sisa_kewajiban-total_dp);
            // make if negative, set to 0
            kekurangan = kekurangan < 0 ? 0 : kekurangan;

            kekurangan = kekurangan.toString();
            
            $('#kekurangan').val(formatRupiah(kekurangan, ''));
        })
        
        $('#btnSave').on('click', function(){
            if($('#id_customer').val() == '' || $('#id_blok').val() == ''){
                alert('Ada data yang belum diisi!');
                return;
            }
            var form = document.getElementById('formCicilanDP'); 
            var formData = new FormData(form); 
            
            $.ajax({ 
                url: url_apps + 'cicilan_dp/store',
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
        
        $('.btnEdit').on('click', function(){
            var id = $(this).attr('data-id');
            $.ajax({ 
                url: url_apps + 'cicilan_dp/ajax_get_data',
                method: 'GET', 
                data: {
                    id:id,
                }, 
                dataType: "JSON",
                success: function (response) {
                    $('#id_customer').select2('data', {id: response.header.id_customer, text: response.header.nama_lengkap}).trigger('change');
                    $('#id_blok').val(response.header.id_blok)
                    $('#kode_blok').val(response.header.kode_kavling)
                    $('#nominal_booking').val(formatRupiah(response.header.nominal_booking, ''))

                    
                    harga['hrg_jual'] = response.header.hrg_jual;
                    harga['harga_jual_ajb'] = response.header.harga_jual_ajb;

                    $('#jenis_pembayaran').val(response.header.jenis_pembayaran).trigger('change');
                    harga_jual_ajb = 0;
                    if(response.header.jenis_pembayaran == 1){
                        harga_jual_ajb = response.header.hrg_jual;
                    }else{
                        harga_jual_ajb = response.header.harga_jual_ajb;
                    }
                    $('#harga_jual_ajb_kredit').val(formatRupiah(harga_jual_ajb, ''))

                    $('#harga_acc_bank').val(formatRupiah(response.header.harga_acc_bank, ''))
                    var sisa_kewajiban = (harga_jual_ajb-response.header.harga_acc_bank);
                    sisa_kewajiban = sisa_kewajiban.toString();
                    console.log(sisa_kewajiban);
                    $('#sisa_kewajiban').val(formatRupiah(sisa_kewajiban, ''))

                    // foreach response.detail and append to dpTable
                    $('#dpTable tbody').html('');
                    $.each(response.detail, function(key, value){
                        var newRow = `<tr>
                                        <td><input type="date" class="form-control" name="tanggal_dp[]" value="${value.tanggal_dp}" disabled></td>
                                        <td><input type="text" class="form-control dp" name="dp[]" value="${formatRupiah(value.nilai_dp, '')}" disabled></td>
                                        <td><button type="button" class="btn btn-info printDP" id="${value.id}">Print</button></td>
                                      </tr>`;
                        $('#dpTable tbody').append(newRow);
                    });

                    var total_dp = 0;
                    $('.dp').each(function(){
                        // if nan, set to 0
                        total_dp += parseInt(($(this).val()).replaceAll(',', '')) || 0;
                    });

                    var kekurangan = (sisa_kewajiban-total_dp);

                    kekurangan = kekurangan.toString();
                    $('#kekurangan').val(formatRupiah(kekurangan, ''))
                }, 
            }); 
        })
    })
</script>

