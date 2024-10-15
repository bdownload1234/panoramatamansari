  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Data Penjualan Rumah - (SPR)</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard'); ?>">Home</a></li>
              <li class="breadcrumb-item active">Penjualan</li>
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
          <h3 class="card-title">Data Penjualan</h3>
              <div class="card-tools">
                <button class="btn btn-default btn-sm" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
              </div>
              <!-- /.card-tools -->
        </div>

        <!-- /.card-header -->
        <div class="card-body">

           <table id="table" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="12%">Nomor Penjualan</th>
                        <th width="22%">Nama Customer</th>
                        <th width="10%">Lokasi Rumah</th>
                        <th width="10%">Booking Fee</th>
                        <th width="10%">No. Telp</th>
                        <th width="7%">Status</th>
                        <th width="7%">Kwitansi</th>
                        <th width="20%">Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>

          </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
</div>


</body>
</html>





<?php  $this->load->view('template/footer'); ?>

<script src="<?php echo base_url('theme_admin/plugins/select2/select2.min.js')?>"></script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('theme_admin/plugins/select2/select2.css') ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('theme_admin/plugins/select2/select2-bootstrap.css') ?>">


<script type="text/javascript">

  var save_method; //for save method string
  var table;
  var url = "<?php echo site_url(); ?>";

  $(document).ready(function() {

      //datatables
      table = $('#table').DataTable({

          "processing": true, //Feature control the processing indicator.
          "serverSide": true, //Feature control DataTables' server-side processing mode.
          "order": [], //Initial no order.

          // Load data for the table's content from an Ajax source
          "ajax": {
              "url": url + "<?php echo $data_ref['uri_controllers']; ?>/ajax_list/1",
              "type": "POST"
          },

          //Set column definition initialisation properties.
          "columnDefs": [
          {
              "targets": [ -1 ], //last column
              "orderable": false, //set not orderable
          },
          ],

      });


      //set input/textarea/select event when change value, remove class error and remove text help block
      $("input").change(function(){
          $(this).parent().parent().removeClass('has-error');
          $(this).next().empty();
      });
      $("textarea").change(function(){
          $(this).parent().parent().removeClass('has-error');
          $(this).next().empty();
      });
      $("select").change(function(){
          $(this).parent().parent().removeClass('has-error');
          $(this).next().empty();
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
           url : "<?php echo site_url($data_ref['uri_controllers'].'/ajax_edit/')?>" + id,
           type: "GET",
           dataType: "JSON",
           success: function(data)
           {
               $('[name="id"]').val(data.id_penjualan);
               $('[name="nama_lengkap"]').val(data.nama_lengkap);
               $('[name="no_ktp"]').val(data.nik);
               $('[name="alamat"]').val(data.alamat);
               $('[name="catatan"]').val(data.catatan);
               $('[name="no_telp"]').val(data.no_telp);
               $('[name="nama_saudara"]').val(data.nama_saudara);
               $('[name="no_hp_tidak_serumah"]').val(data.no_telp_saudara);

               $('#nama_lengkap').select2('data', {id: data.id_customer, text: data.nama_lengkap});
               $('[name="kode_kavling"]').val(data.kode_kavling);
               $('[name="nominal_booking"]').val(data.booking_fee);

               $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
               $('.modal-title').text('Edit Penjualan'); // Set title to Bootstrap modal title

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
                   reload_table();
                   Lobibox.notify('success', {
                       size: 'mini',
                       msg: 'Data berhasil Disimpan'
                   });
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

   var url_apps = '<?=base_url();?>';

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
                  reload_table();
                  Lobibox.notify('success', {
                       size: 'mini',
                       msg: 'Data berhasil Dihapus'
                   });
                location.reload(); 
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


  function kirimpersonal(id)
   {
    //  $("#kartuanggota").load('<?php echo base_url('customer/kosong');?>');
       //Ajax Load data from ajax
      //  $('#form_notif')[0].reset(); // reset form on modals
      //  $('.form-group').removeClass('has-error'); // clear error class
      //  $('.help-block').empty(); // clear error string
       //Ajax Load data from ajax
       $.ajax({
           url : "<?php echo site_url($data_ref['uri_controllers'].'/ajax_kirim_bukti/')?>" + id,
           type: "GET",
           dataType: "JSON",
           success: function(data)
           {
               $('[name="id"]').val(data.id_kavling);
               $('[name="noFile"]').val(data.noFile);
               $('[name="nama_lengkap"]').val(data.nama_lengkap);
               $('[name="no_telp"]').val(data.no_telp);
               $('[name="isi_pesan"]').val(data.isi_pesan);
               $('#modal_form_notif').modal('show'); // show bootstrap modal when complete loaded
               $('.modal-title').text('Kirim Pesan'); // Set title to Bootstrap modal title
               $("#kartuanggota").load('<?php echo base_url('penjualan/kwitansi/');?>' + id);
           },
           error: function (jqXHR, textStatus, errorThrown)
           {
               alert('Error get data from ajax');
           }
       });

   }


   function kirim(){
    $.confirm({
      title: 'Perhatian!',
      content: 'Apakah anda yakin akan mengirim pesan dan lampiran ?',
      buttons: {
        confirm: function () {
          var formData = new FormData($('#form_notif')[0]);
           $.ajax({
              url : url + "<?php echo $data_ref['uri_controllers']; ?>/ajax_kirim",
              type: "POST",
              data: formData,
              contentType: false,
              processData: false,
              dataType: "JSON",
              success: function(data)
              {
                  Lobibox.notify('success', {
                       size: 'mini',
                       msg: 'Pesan Berhasil Dikirim....'
                   });
              },
              error: function (jqXHR, textStatus, errorThrown)
              {
                  alert('Gagal memproses');
              }
          });
        },
        cancel: function () {
          
        }
      }
    });
  }




  $("#nama_lengkap").select2({
    ajax: {
      url: url_apps+'spr/ajax_select',
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



$('#nama_lengkap').on('change', function() {
  
  $.ajax({
    url: url_apps + 'spr/get_select/' + $(this).val(),
    type: 'GET',
    dataType: 'json',
  })
  .done(function(data) {
    $('#id_customer').val(data.id_customer);
    $('#no_ktp').val(data.nik);
    $('#alamat').val(data.alamat);
    $('#no_telp').val(data.no_telp);
    $('#no_hp_tidak_serumah').val(data.no_telp_saudara);
    $('#nama_saudara').val(data.nama_saudara);
    $('#nominal_booking').val(data.booking_fee);
    $('#kode_kavling').val(data.kode_kavling);
    $('#id_kavling').val(data.id_kavling);
    
  })
  .fail(function() {
    console.log("error");
  })
  .always(function() {
    console.log("complete");
  });
  
});


var nominal_booking = document.getElementById('nominal_booking');
nominal_booking.addEventListener('keyup', function(e) {
  nominal_booking.value = formatRupiah(this.value);
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


<div class="modal fade" id="modal_form_notif" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">header</h3>
            </div>
            <div class="modal-body">
            <form action="#" id="form_notif" class="form-horizontal">
                    <input type="hidden" value="" name="id"/> 
                    <input type="hidden" value="" name="noFile"/> 
                    <div class="form-body">

    
                        <div class="form-group row">
                            <label class="control-label col-md-2">Nomor Tujuan</label>
                            <div class="col-md-3">
                                <input name="no_telp" placeholder="" class="form-control" type="text" >
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-2">Nama Kontak</label>
                            <div class="col-md-3">
                                <input name="nama_lengkap" placeholder="" class="form-control" type="text" >
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-2">Isi Pesan</label>
                            <div class="col-md-8">
                                <textarea name="isi_pesan" rows="7" class="form-control" ></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-2">Kwitansi</label>
                            <div class="col-md-10">
                                <div id="kartuanggota">
                                    
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
            <button type="button" id="btnSave" onclick="kirim()" class="btn btn-primary">Kirim Pesan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
