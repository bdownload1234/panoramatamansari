  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Data Kavling</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard'); ?>">Home</a></li>
              <li class="breadcrumb-item active">Kavling</li>
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
          <h3 class="card-title">Data Kavling</h3>
          <div class="card-tools">
                <a href="<?= base_url('kavling/upload');?>" class="btn btn-info btn-sm""><i class="fa fa-plus"></i> Upload SVG</a></div>
             <!-- /.card-tools -->
        </div>

        <!-- /.card-header -->
        <div class="card-body">

           <table id="table" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="10%">Lokasi</th>
                        <th width="10%">Luas Tanah</th>
                        <th width="10%">Type Rumah</th>
                        <th width="10%">Harga Jual</th>
                        <th width="10%">Harga Diskon</th>
                        <th width="10%">Status</th>
                        <th width="25%">Keterangan</th>
                        <th width="10%">Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                $query = "SELECT *
FROM kavling_peta 
ORDER BY 
    SUBSTRING(kode_kavling, 1, 1),
    CAST(SUBSTRING(kode_kavling, 2, 1) AS UNSIGNED),
    CAST(SUBSTRING(kode_kavling, 4) AS UNSIGNED)";
    
    $no =1;
                $kavling = $this->db->query($query)->result();
                foreach($kavling as $kav){
                    
                    if($kav->stt_kavling == '0'){
        				$stat = '<span class="btn btn-danger btn-xs">HOLD</span>';
        			}elseif($kav->stt_kavling == '1'){
        				$stat = '<span class="btn btn-warning btn-xs">AVAILABLE</span>';
        			}elseif($kav->stt_kavling == '2'){
        				$stat = '<span class="btn btn-primary btn-xs">NUP</span>';
        			}elseif($kav->stt_kavling == '3'){
        				$stat = '<span class="btn btn-info btn-xs">TERBOOKING</span>';
        			}elseif($kav->stt_kavling == '4'){
        				$stat = '<span class="btn btn-success btn-xs">SUDAH AKAD</span>';
        			}elseif($kav->stt_kavling == '5'){
        				$stat = '<span class="btn btn-warning btn-xs">STANDART</span>';
        			}elseif($kav->stt_kavling == '6'){
        				$stat = '<span class="btn btn-secondary btn-xs">KHUSUS</span>';
        			}else{
        				$stat = '';
        			}
			
                    echo '<tr id="'.$no.'">
                        <td>'.$no++.'</td>
                        <td>'.$kav->kode_kavling.'</td>
                        <td>'.$kav->luas_tanah.' meter'.'</td>
                        <td>'.$kav->tipe_bangunan.'</td>
                        <td align="right">'.rupiah($kav->hrg_jual).'</td>
                        <td align="right">'.rupiah($kav->harga_diskon).'</td>
                        <td align="center">'.$stat.'</td>
                        <td>'.$kav->keterangan.'</td>
                        <td><a class="btn btn-xs btn-success" href="javascript:void(0)" title="Edit" onclick="edit('."'".$kav->id_kavling."'".')"> Edit Kavling</a></td>
                    </tr>';
                }
                ?>
                </tbody>
            </table>

          </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
</div>


<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">header</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id"/> 
                    <div class="form-body">

    
                        <div class="form-group row">
                            <label class="control-label col-md-3">Kode Kavling</label>
                            <div class="col-md-2">
                                <input name="kode_kavling" placeholder="" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="control-label col-md-3">Luas Tanah</label>
                            <div class="col-md-2">
                                <input name="luas_tanah" placeholder="" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Type Rumah</label>
                            <div class="col-md-4">
                            <select class="form-control" id="tipe_bangunan" name="tipe_bangunan" required>
                                <option>-</option>
                                <option value="Classic">Classic ( 33/60 )</option>
                                <option value="Mezzanine">Mezzanine ( 33+8/60)</option>
                            </select>
                                <span class="help-block"></span>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="control-label col-md-3">Harga Jual Cash / Kredit</label>
                            <div class="col-md-2">
                                <input name="harga_jual" id="harga_jual" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="control-label col-md-3">Harga Diskon Lainnya</label>
                            <div class="col-md-2">
                                <input name="harga_diskon" id="harga_diskon" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="control-label col-md-3">Jenis Map</label>
                            <div class="col-md-2">
                                <input name="jenis_map" placeholder="" class="form-control" type="text" disabled>
                                <span class="help-block"></span>
                            </div>
                        </div>


                        <!-- <div class="form-group row">
                            <label class="control-label col-md-3">Status</label>
                            <div class="col-md-2">
                              <select class="form-control" name="status" disabled>
                                <option value="0">Kosong</option>
                                <option value="1">Booking</option>
                                <option value="2">Cash</option>
                                <option value="3">Kredit</option>
                              </select>
                                <span class="help-block"></span>
                            </div>
                        </div> -->

                        <div class="form-group row">
                            <label class="control-label col-md-3">Kode Map</label>
                            <div class="col-md-6">
                                <textarea name="map" class="form-control" cols="10" rows="4" disabled></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="control-label col-md-3">Status</label>
                            <div class="col-md-2">
                              <select class="form-control" name="stt_kavling" >
                                <option value="0">Hold</option>
                                <option value="1">Available</option>
                                <option value="2">NUP</option>
                                <option value="3">Terboking</option>
                                <option value="4">Sudah Akad</option>
                                <option value="5">Standart</option>
                                <option value="6">Khusus</option>
                              </select>
                                <span class="help-block"></span>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="control-label col-md-3">Keterangan</label>
                            <div class="col-md-8">
                                <input name="keterangan" id="keterangan" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->
</body>
</html>





<?php  $this->load->view('template/footer'); ?>


<script type="text/javascript">


  var url = "<?php echo site_url(); ?>";
  
  
  $(document).ready(function() {

      //datatables
      table = $('#table').DataTable({

          "paging": false,




      });
       });


   function edit(id)
   {
       save_method = 'update';
       $('#form')[0].reset(); // reset form on modals
       $('.form-group').removeClass('has-error'); // clear error class
       $('.help-block').empty(); // clear error string
    
       //Ajax Load data from ajax
       $.ajax({
           url : "<?php echo site_url($data_ref['uri_controllers'].'/ajax_edit/')?>/" + id,
           type: "GET",
           dataType: "JSON",
           success: function(data)
           {
               $('[name="id"]').val(data.id_kavling);
               $('[name="kode_kavling"]').val(data.kode_kavling);
               $('[name="luas_tanah"]').val(data.luas_tanah);
               $('[name="tipe_bangunan"]').val(data.tipe_bangunan);
               $('[name="harga_jual"]').val(data.hrg_jual);
               $('[name="harga_diskon"]').val(data.harga_diskon);
               $('[name="jenis_map"]').val(data.jenis_map);
               $('[name="map"]').val(data.map);
            //    $('[name="status"]').val(data.status);
               $('[name="stt_kavling"]').val(data.stt_kavling);
               $('[name="keterangan"]').val(data.keterangan);

               $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
               $('.modal-title').text('Edit Kavling'); // Set title to Bootstrap modal title
              
            
           },
           error: function (jqXHR, textStatus, errorThrown)
           {
               alert('Error get data from ajax');
           }
       });
   }



   function save()
   {
       $('#btnSave').text('Menyimpan...'); //change button text
       $('#btnSave').attr('disabled',true); //set button disable 
       var url;
    
       if(save_method == 'add') {
           url = "<?php echo site_url($data_ref['uri_controllers'].'/ajax_add')?>";
       } else {
           url = "<?php echo site_url($data_ref['uri_controllers'].'/ajax_update')?>";
       }
    
       // ajax adding data to database
       var formData = new FormData($('#form')[0]);
       $.ajax({
            url : url,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "JSON",
           success: function(data)
           {
    
               if(data.status) //if success close modal and reload ajax table
               {
                   $('#modal_form').modal('hide');
                   location.reload();
               }
               else
               {
                   for (var i = 0; i < data.inputerror.length; i++) 
                   {
                       $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                       $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                   }
               }
               $('#btnSave').text('Simpan'); //change button text
               $('#btnSave').attr('disabled',false); //set button enable 
    
    
           },
           error: function (jqXHR, textStatus, errorThrown)
           {
               alert('Error adding / update data');
               $('#btnSave').text('Simpan'); //change button text
               $('#btnSave').attr('disabled',false); //set button enable 
    
           }
       });
   }




var harga_jual = document.getElementById('harga_jual');
harga_jual.addEventListener('keyup', function(e) {
    harga_jual.value = formatRupiah(this.value);
});

var harga_diskon = document.getElementById('harga_diskon');
harga_diskon.addEventListener('keyup', function(e) {
    harga_diskon.value = formatRupiah(this.value);
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


</script>


