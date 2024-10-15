  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Data Proses Legalitas</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->




    <!-- Main content -->
    <section class="content">
      <div class="card">
        

        <!-- /.card-header -->
        <div class="card-body">

           <table id="table" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="10%">Lokasi</th>
                        <th width="20%">Nama Customer</th>
                        <th width="15%">Ukuran Tanah</th>
                        <th width="15%">Status Legalitas</th>
                        <th width="15%">No. SHM</th>
                        <th width="20%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no=1;
                    $legalitas = $this->db->query("SELECT * FROM legal 
                    LEFT JOIN kavling_peta ON legal.id_kavling = kavling_peta.id_kavling 
                    LEFT JOIN customer ON kavling_peta.id_customer = customer.id_customer")->result();
                    foreach($legalitas as $lg){
                        if($lg->stt_legal == '1'){
                            $sttLegal = 'Proses';
                        }else if($lg->stt_legal == '2'){
                            $sttLegal = 'Selesai';
                        }else if($lg->stt_legal == '3'){
                            $sttLegal = 'Serah Terima';
                        }else{
                            $sttLegal = '-';
                        }
                        $link_edit = '<a class="btn btn-xs btn-primary" href="javascript:void(0)" title="Edit" onclick="edit('."'".$lg->id_legal."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>';
						$link_hapus = ' <a class="btn btn-xs btn-danger" href="javascript:void(0)" title="Hapus" onclick="hapus('."'".$lg->id_legal."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
		
                        echo '<tr>
                        <td>'.$no++.'</td>
                        <td>'.$lg->kode_kavling.'</td>
                        <td>'.$lg->atas_nama.'</td>
                        <td>'.$lg->luas.' m2</td>
                        <td>'.$sttLegal.'</td>
                        <td>'.$lg->no_shm.'</td>
                        <td>'.$link_edit.$link_hapus.'</td>
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
                            <label class="control-label col-md-3">Kode Kavling</label>
                            <div class="col-md-5">
                                <input name="kode_kavling" id="kode_kavling" class="form-control" type="text" readonly>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Nama Pembeli</label>
                            <div class="col-md-5">
                                <input name="nama_cust" placeholder="" class="form-control" type="text" id="nama_cust" readonly>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Ukuran Tanah</label>
                            <div class="col-md-5">
                                <input name="ukuran_tanah" placeholder="" class="form-control" type="text" >
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Nomor SHM</label>
                            <div class="col-md-5">
                                <input name="no_shm" placeholder="" class="form-control" type="text" >
                                <span class="help-block"></span>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="control-label col-md-3">Status Legalitas</label>
                            <div class="col-md-5">
                              <select name="status" id="status"  class="form-control">
                                <option value="">-- Pilih --</option>
                                <option value="1">Proses</option>
                                <option value="2">Selesai</option>
                                <option value="3">Serah Terima</option>
                              </select>
                                <span class="help-block"></span>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
            <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->
</body>
</html>





<?php  $this->load->view('template/footer'); ?>


<script type="text/javascript">

  var save_method; //for save method string
  var table;
  var url = "<?php echo site_url(); ?>";

   function add()
   {
       save_method = 'add';
       $('#form')[0].reset(); // reset form on modals
       $('.form-group').removeClass('has-error'); // clear error class
       $('.help-block').empty(); // clear error string
       $('#modal_form').modal('show'); // show bootstrap modal
       $('.modal-title').text('Tambah Konten'); // Set Title to Bootstrap modal title
       $('#photo-preview').hide(); // hide photo preview modal
   }

   function edit(id)
   {
       save_method = 'update';
       $('#form')[0].reset(); // reset form on modals
       $('.form-group').removeClass('has-error'); // clear error class
       $('.help-block').empty(); // clear error string
    
       //Ajax Load data from ajax
       $.ajax({
           url : "<?php echo site_url($data_ref['uri_controllers'].'/ajax_edit/')?>" + id,
           type: "GET",
           dataType: "JSON",
           success: function(data)
           {
               $('[name="id"]').val(data.id_legal);
               $('[name="kode_kavling"]').val(data.kode_kavling);
               $('[name="luas_tanah"]').val(data.luas_tanah);
               $('[name="nama_cust"]').val(data.atas_nama);
               $('[name="ukuran_tanah"]').val(data.ukuran);
               $('[name="no_shm"]').val(data.no_shm);              
               $('[name="status"]').val(data.stt_legal);

               $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
               $('.modal-title').text('Edit Data Legal'); // Set title to Bootstrap modal title
           },
           error: function (jqXHR, textStatus, errorThrown)
           {
               alert('Error get data from ajax');
           }
       });
   }

   function reload_table()
   {
      table.ajax.reload(null,false); //reload datatable ajax
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

   function hapus(id){
    $.confirm({
      title: 'Confirm!',
      content: 'Apakah anda yakin menghapus data ini ?',
      buttons: {
        confirm: function () {
           $.ajax({
              url : url + "<?php echo $data_ref['uri_controllers']; ?>/ajax_delete/" + id,
              type: "POST",
              dataType: "JSON",
              success: function(data)
              {
                  //if success reload ajax table
                  location.reload(); 
                //   reload_table();
                //   Lobibox.notify('success', {
                //        size: 'mini',
                //        msg: 'Data berhasil Dihapus'
                //    });
              },
              error: function (jqXHR, textStatus, errorThrown)
              {
                  alert('Error deleting data');
              }
          });
        },
        cancel: function () {
          
        }
      }
    });
  }

</script>


