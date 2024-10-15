  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard Customer</h1>
            <hr>
          </div>
        </div>
      </div>
    </div>
    <!-- /.content-header -->



  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->

      <div class="row">
        <div class="col-lg-12 col-12">

        <div class="callout callout-info">
            <?php 
            $cust = $this->db->get_where('customer', ['email' => $this->encryption->decrypt($this->session->userdata('email'))])->row_array();
            ?>
                  <h5>Hi, <?=$cust['nama_lengkap'];?></h5>

                  <p>Status proses pembelian rumah anda. <br>
                  <!-- <span class="badge badge-warning">Proses Verifikasi</span> -->
                </p>

                <hr>


                <!-- ============================================================== -->
                
                
                <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
<!-- Creator: CorelDRAW X8 -->
<svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" width="100%" height="145.857mm" version="1.1" style="shape-rendering:geometricPrecision; text-rendering:geometricPrecision; image-rendering:optimizeQuality; fill-rule:evenodd; clip-rule:evenodd"
viewBox="0 0 7070 8804"
 xmlns:xlink="http://www.w3.org/1999/xlink">
 <defs>
  <style type="text/css">
   <![CDATA[
    .str0 {stroke:#E6E6E6;stroke-width:12.0716}
    .fil0 {fill:none}
    .fil2 {fill:#332C2B}
    .fil4 {fill:#8E4002}
    .fil1 {fill:#CCCCCC}
    .fil8 {fill:#F39D1B}
    .fil6 {fill:#FBB513}
    .fil7 {fill:#FDE200}
    .fil5 {fill:#FEC905}
    .fil9 {fill:#FFF699}
    .fil11 {fill:#FFFCD3}
    .fil10 {fill:white}
    .fil3 {fill:#332C2B;fill-rule:nonzero}
    .fnt1 {font-weight:normal;font-size:234.225px;font-family:'Bahnschrift'}
    .fnt0 {font-weight:normal;font-size:1007.43px;font-family:'Bahnschrift'}
   ]]>
  </style>
 </defs>
 
 
   <?php 
  // cek proses status_customer
  $cekCust = $this->db->get_where('customer', ['email' => $this->encryption->decrypt($this->session->userdata('email'))])->row_array();
  if($cekCust['status_customer'] >= 1){ $proses1 = 'fil5'; }else{ $proses1 = 'fil1'; }
  if($cekCust['status_customer'] >= 2){ $proses2 = 'fil5'; }else{ $proses2 = 'fil1'; }
  if($cekCust['status_customer'] >= 3){ $proses3 = 'fil5'; }else{ $proses3 = 'fil1'; }
  if($cekCust['status_customer'] >= 4){ $proses4 = 'fil5'; }else{ $proses4 = 'fil1'; }
?>
 
 
 
 <g id="Layer_x0020_1">
  <metadata id="CorelCorpID_0Corel-Layer"/>
  <rect class="fil0 str0" x="6" y="6" width="7057" height="8792"/>
  <g id="_2002306873808">
   <circle class="<?=$proses1;?>" cx="1749" cy="2163" r="883"/>
   <text x="1603" y="2521"  class="fil2 fnt0">1</text>
  </g>
  <g id="_2002306876528">
   <circle class="<?=$proses2;?>" cx="4689" cy="2163" r="883"/>
   <text x="4429" y="2524"  class="fil2 fnt0">2</text>
  </g>
  <g id="_2002306877040">
   <circle class="<?=$proses3;?>" cx="4689" cy="5523" r="883"/>
   <text x="4435" y="5880"  class="fil2 fnt0">3</text>
  </g>
  <g id="_2002306876304">
   <circle class="<?=$proses4;?>" cx="1749" cy="5523" r="883"/>
   <text x="1455" y="5880"  class="fil2 fnt0">4</text>
  </g>
  <g id="_2002306879696">
   <path class="fil3" d="M1749 1248c252,0 481,103 647,268 165,166 268,394 268,647 0,253 -103,481 -268,647 -166,165 -395,268 -647,268 -253,0 -481,-103 -647,-268 -165,-166 -268,-394 -268,-647 0,-253 103,-481 268,-647 166,-165 394,-268 647,-268zm602 313c-154,-154 -367,-249 -602,-249 -235,0 -448,95 -602,249 -154,154 -249,367 -249,602 0,235 95,448 249,602 154,154 367,249 602,249 235,0 448,-95 602,-249 154,-154 249,-367 249,-602 0,-235 -95,-448 -249,-602z"/>
   <path class="fil3" d="M4689 1248c253,0 482,103 647,268 166,166 268,394 268,647 0,253 -102,481 -268,647 -165,165 -394,268 -647,268 -252,0 -481,-103 -646,-268 -166,-166 -268,-394 -268,-647 0,-253 102,-481 268,-647 165,-165 394,-268 646,-268zm602 313c-154,-154 -367,-249 -602,-249 -235,0 -447,95 -601,249 -154,154 -249,367 -249,602 0,235 95,448 249,602 154,154 366,249 601,249 235,0 448,-95 602,-249 154,-154 249,-367 249,-602 0,-235 -95,-448 -249,-602z"/>
   <path class="fil3" d="M1749 4608c252,0 481,102 647,268 165,165 268,394 268,647 0,252 -103,481 -268,646 -166,166 -395,268 -647,268 -253,0 -481,-102 -647,-268 -165,-165 -268,-394 -268,-646 0,-253 103,-482 268,-647 166,-166 394,-268 647,-268zm602 313c-154,-154 -367,-249 -602,-249 -235,0 -448,95 -602,249 -154,154 -249,367 -249,602 0,235 95,447 249,601 154,154 367,249 602,249 235,0 448,-95 602,-249 154,-154 249,-366 249,-601 0,-235 -95,-448 -249,-602z"/>
   <path class="fil3" d="M4689 4608c253,0 482,102 647,268 166,165 268,394 268,647 0,252 -102,481 -268,646 -165,166 -394,268 -647,268 -252,0 -481,-102 -646,-268 -166,-165 -268,-394 -268,-646 0,-253 102,-482 268,-647 165,-166 394,-268 646,-268zm602 313c-154,-154 -367,-249 -602,-249 -235,0 -447,95 -601,249 -154,154 -249,367 -249,602 0,235 95,447 249,601 154,154 366,249 601,249 235,0 448,-95 602,-249 154,-154 249,-366 249,-601 0,-235 -95,-448 -249,-602z"/>
   <g>
    <text x="1317" y="900"  class="fil2 fnt1">PROSES</text>
    <text x="1117" y="1181"  class="fil2 fnt1">REGISTRASI</text>
    <text x="4257" y="900"  class="fil2 fnt1">PROSES</text>
    <text x="4093" y="1181"  class="fil2 fnt1">VERIFIKASI</text>
    <text x="4253" y="4226"  class="fil2 fnt1">PROSES</text>
    <text x="4466" y="4508"  class="fil2 fnt1">SPR</text>
    <text x="1313" y="4226"  class="fil2 fnt1">PROSES</text>
    <text x="1441" y="4508"  class="fil2 fnt1">AKAD</text>
   </g>
   <g>
    <path class="fil4" d="M4282 7439l-9 -10 -200 -89c-34,-15 -27,-15 -67,22 -71,67 -49,66 -132,41 -17,-5 -17,-4 -34,5 -42,23 -48,36 -66,19 -17,-16 -18,-9 -33,6l-100 93c-29,28 -12,54 -49,46 -7,-2 -27,-6 -33,-10 -11,-8 -14,-26 -26,-31 -15,-6 -54,-2 -67,-15l-61 -67c-16,-18 -13,-13 -32,-7 -38,14 -32,14 -57,49 -13,19 -29,43 -61,37 -17,-3 -49,-31 -67,-42 -59,-35 -116,-49 -182,-54 -6,0 -10,1 -17,0 -36,-3 -99,13 -133,25 -45,16 -95,47 -134,85 -59,58 -91,124 -108,199 -22,101 2,215 63,299 5,8 23,29 26,34l33 33c8,4 18,14 26,20 25,19 51,34 80,46 192,79 413,-5 500,-196 21,-47 23,-82 38,-106 23,-34 75,-46 106,-56 143,-45 284,-91 428,-135 23,-7 253,-79 266,-85 22,-10 32,-30 44,-49 7,-9 54,-82 58,-93 3,-8 1,-6 0,-14z"/>
    <path class="fil5" d="M3304 7906l-65 -23c-12,-4 -13,-2 -16,-14 -9,-30 -18,-57 -27,-87 -5,-15 -9,-28 -14,-43l-41 -129 51 -51c-21,-19 -67,-40 -91,-48 -15,-5 -31,-10 -46,-12 -34,-5 -36,-5 -67,-4 -57,1 -110,17 -161,49 -142,89 -167,251 -138,353 29,101 105,190 212,222 18,5 29,8 46,11l46 5c63,1 130,-20 183,-55 58,-39 102,-96 125,-162l2 -9c1,-2 1,-2 1,-3z"/>
    <path class="fil6" d="M2784 7595c-34,34 -59,73 -73,112 -3,8 -6,18 -8,26 -18,63 -15,118 6,184 27,85 101,154 184,184 34,13 101,29 123,-12 9,-17 4,-40 -8,-55 -17,-25 -56,-5 -70,-15 -16,-12 25,-48 41,-73 28,-41 60,-101 69,-145 15,-71 -33,-83 -34,-108 -1,-11 7,-27 12,-37 48,-105 117,-132 13,-144 -36,-5 -75,-5 -110,4 -47,12 -101,35 -145,79z"/>
    <path class="fil5" d="M4193 7552c-9,0 -48,15 -60,18l-122 39c-20,6 -41,11 -61,19 -33,12 -85,26 -122,38 -41,14 -81,26 -123,38 -73,23 -310,101 -366,111 -21,3 -43,5 -61,3 -38,-6 -30,-29 -2,-49 36,-27 85,-42 122,-55l121 -38c101,-30 205,-65 306,-96 20,-6 41,-12 61,-19l123 -39c41,-12 81,-26 122,-38l92 -28c6,-2 24,-7 30,-10 -8,-8 -30,-16 -40,-21 -10,-5 -11,-7 -20,-4l-268 85c-110,33 -220,70 -329,103 -56,17 -109,35 -164,51 -27,8 -56,19 -82,25 -33,7 -55,11 -83,9 -26,-2 -69,-14 -58,-50 8,-30 46,-54 72,-67 55,-27 137,-44 166,-57 -63,-69 -48,-65 -84,-47 -18,9 -34,38 -46,56 -12,19 -19,17 -41,20 -15,1 -28,4 -47,-10l-75 71c6,10 11,32 15,45l58 184c2,7 5,15 7,23 3,12 5,10 17,14 16,5 85,29 94,29 9,-18 11,-34 25,-54 14,-20 34,-31 53,-38 36,-14 75,-26 111,-37 144,-43 296,-96 440,-139 54,-16 112,-36 167,-53 17,-5 41,-11 52,-32z"/>
    <path class="fil7" d="M3340 7919c-9,-4 -19,-6 -28,-11 -3,8 -5,15 -8,24 -47,134 -181,220 -315,219 -14,0 -32,-1 -48,-4 -50,-7 -99,-26 -143,-57 -194,-138 -184,-430 16,-555 31,-19 64,-33 95,-41 104,-25 198,-4 287,60l22 -21c-27,-24 -74,-47 -104,-58 -102,-36 -217,-26 -312,32 -267,164 -217,563 81,658 150,47 318,-10 408,-141 16,-24 47,-84 49,-105z"/>
    <path class="fil7" d="M3150 7566c-15,-15 -25,-6 -39,4 -14,9 -28,22 -28,36 -1,33 29,59 47,78 21,22 27,49 22,77 -4,24 -27,56 -48,79 -17,19 -52,58 -22,77 14,9 28,6 21,30 -5,16 -10,22 -9,39 1,60 -12,41 -40,77 -25,33 -3,52 36,47 41,-5 122,-63 151,-107 14,-22 37,-58 40,-78 3,-25 -54,-14 -66,-47l-54 -174c-9,-23 -46,-76 -24,-118 4,-7 11,-13 13,-20z"/>
    <path class="fil5" d="M2745 7791c0,-8 -2,-1 2,-7 3,-7 26,-25 31,-28 20,-11 30,-12 35,-15 -31,5 -67,24 -88,59 -19,31 -23,63 -16,94 12,60 68,105 135,100 6,-1 18,-2 25,-5l-57 -2c-7,-2 -5,-1 -11,-5 9,-5 1,-3 17,0l14 1c5,1 9,0 14,-1 47,-5 83,-31 102,-74 18,-42 6,-100 -29,-129 -19,-16 -38,-24 -58,-28 -26,-5 -54,-1 -79,11l-2 1c-14,7 -22,16 -35,28z"/>
    <path class="fil8" d="M4251 7467c-3,-1 0,-1 -4,0l-27 8c-10,3 -19,6 -30,9l-179 57c-158,49 -320,102 -478,150 -45,13 -220,62 -239,98 5,6 8,7 15,7 25,-1 18,0 46,-5 52,-9 130,-37 183,-53 60,-17 123,-39 183,-57l122 -38c99,-31 206,-67 304,-96 11,-3 54,-15 61,-19 7,-5 34,-50 43,-61z"/>
    <path class="fil4" d="M2916 7925c28,-41 26,-106 -24,-141 -42,-28 -106,-25 -141,26 -28,41 -25,104 24,139 41,29 106,27 141,-24z"/>
    <path class="fil8" d="M3636 7576c44,-14 88,-28 134,-42 38,-12 99,-30 134,-42 21,-8 44,-13 66,-21 22,-7 44,-14 68,-21 23,-7 44,-15 67,-21 12,-4 23,-7 33,-11 12,-4 24,-6 34,-11 -23,-11 -43,-19 -67,-31 -11,-5 -23,-10 -34,-16 -18,-8 -19,-8 -35,6 -23,21 -46,43 -68,64 -23,21 -21,17 -69,3 -38,-12 -31,-11 -69,9 -31,17 -36,27 -50,15 -5,-5 -12,-14 -18,-12 -4,1 -61,58 -69,65 -14,14 -58,50 -57,66z"/>
    <path class="fil8" d="M3462 7536c-19,3 -124,40 -140,47 -20,9 -55,27 -68,49 -18,30 26,37 46,37l34 -4c54,-8 152,-42 210,-60 10,-3 26,-7 36,-12 -13,-6 -20,-1 -31,-18 -8,-13 -10,-21 -25,-22 -26,-3 -48,-2 -62,-17z"/>
    <path class="fil9" d="M3224 7800c37,-49 70,-62 118,-77 42,-12 82,-26 123,-39l246 -78c40,-12 82,-27 123,-39 82,-26 164,-54 246,-78 42,-13 84,-26 123,-40 -19,6 -42,10 -64,16 -60,17 -131,32 -193,49 -22,6 -43,9 -65,17 -20,7 -44,14 -65,20 -21,6 -43,14 -64,20 -37,12 -95,28 -130,40 -11,4 -21,7 -32,10 -47,17 -113,34 -163,50 -43,14 -85,25 -129,37 -18,5 -48,14 -64,27 -20,17 -19,46 -10,65z"/>
    <path class="fil10" d="M2895 7913c23,-32 22,-81 -17,-108 -31,-22 -79,-20 -106,17 -22,31 -20,79 17,107 31,22 79,20 106,-16z"/>
    <path class="fil11" d="M3084 8091c8,4 47,-10 59,-15 40,-20 84,-66 105,-104 12,-24 21,-40 -12,-53 -22,-8 -52,-18 -43,13 6,19 16,32 2,60 -11,22 -32,41 -52,57 -12,9 -54,33 -59,42z"/>
    <path class="fil11" d="M3167 7617l22 70 3 -35c9,-51 41,-68 87,-88 40,-17 135,-38 150,-48 -2,-7 -34,-54 -65,-27 -31,26 -32,83 -129,66 -12,-2 -17,9 -35,27 -10,10 -25,24 -33,35z"/>
    <path class="fil11" d="M2921 7931c-115,117 -257,-39 -163,-137 21,-22 47,-32 76,-34 9,0 17,2 27,2 -7,-4 -21,-5 -27,-5 -61,-5 -139,65 -112,146 14,44 53,71 92,76 40,5 91,-14 107,-48z"/>
   </g>
   <g>
    <path class="fil3" d="M2759 2131l0 64 -127 0 0 -64 127 0zm1048 32l-448 -192c27,54 43,107 47,160l-8 0 0 64 8 0c-4,53 -20,106 -47,160l448 -192zm-473 -32l0 64 -127 0 0 -64 127 0zm-191 0l0 64 -128 0 0 -64 128 0zm-192 0l0 64 -128 0 0 -64 128 0z"/>
    <path class="fil3" d="M3679 5555l0 -64 128 0 0 64 -128 0zm-1047 -32l447 191c-27,-53 -42,-106 -47,-159l8 0 0 -64 -8 0c5,-53 20,-107 47,-160l-447 192zm472 32l0 -64 128 0 0 64 -128 0zm192 0l0 -64 127 0 0 64 -127 0zm191 0l0 -64 128 0 0 64 -128 0z"/>
    <path class="fil3" d="M5689 2132l0 63 -128 0 1 -64 127 1zm-117 3391l449 188c-27,-53 -43,-106 -48,-159l101 -1 0 -64 -101 1c4,-53 19,-107 45,-160l-446 195zm566 27l0 -63 112 -1 0 16 32 0 0 47 -144 1zm144 -112l-64 0 0 -128 64 0 0 128zm0 -191l-64 0 0 -128 64 0 0 128zm0 -192l-64 0 0 -128 64 0 0 128zm0 -192l-64 0 0 -128 64 0 0 128zm0 -191l-64 0 0 -128 64 0 0 128zm0 -192l-64 0 0 -128 64 0 0 128zm0 -192l-64 0 0 -127 64 0 0 127zm0 -191l-64 0 0 -128 64 0 0 128zm0 -192l-64 0 0 -128 64 0 0 128zm0 -192l-64 0 0 -127 64 0 0 127zm0 -191l-64 0 0 -128 64 0 0 128zm0 -192l-64 0 0 -128 64 0 0 128zm0 -191l-64 0 0 -128 64 0 0 128zm0 -192l-64 0 0 -128 64 0 0 128zm0 -192l-64 0 0 -127 64 0 0 127zm0 -191l-64 0 0 -128 64 0 0 128zm0 -192l-64 0 0 -128 64 0 0 128zm0 -192l-15 0 -17 18 -114 0 1 -64 145 0 0 46zm-209 -47l-1 64 -127 0 0 -64 128 0zm-192 -1l0 64 -128 0 0 -64 128 0z"/>
    <path class="fil3" d="M1749 6601l-64 0 0 -128 64 0 0 128zm646 1251l-446 -195c26,54 42,107 46,160l-118 -1 -1 64 118 1c-4,53 -20,106 -48,159l449 -188zm-582 -36l-1 64 -127 -1 0 -65 64 0 0 1 64 1zm-64 -66l-64 0 0 -127 64 0 0 127zm0 -191l-64 0 0 -128 64 0 0 128zm0 -192l-64 0 0 -128 64 0 0 128zm0 -191l-64 0 0 -128 64 0 0 128zm0 -192l-64 0 0 -128 64 0 0 128zm0 -192l-64 0 0 -128 64 0 0 128z"/>
   </g>
  </g>
 </g>
</svg>









<!-- ============================================== -->
                </div>

                <div class="row">
            <div class="col-lg-4"></div>
            <div class="col-lg-4">
              <!-- <img src="<?=base_url('assets/TIPE_MEZANINE .jpg');?>" alt="" width="100%"> -->
            
            </div>
            </div>
                

          </div>
        </div>
      </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->






<script type="text/javascript">
   function add(id)
   {
       save_method = 'add';
       $('#form')[0].reset(); // reset form on modals
       $('.form-group').removeClass('has-error'); // clear error class
       $('.help-block').empty(); // clear error string
       $('#modal_form').modal('show'); // show bootstrap modal
       $('.modal-title').text('Detail Kavling' + id); // Set Title to Bootstrap modal title
       $('#photo-preview').hide(); // hide photo preview modal

       //Ajax Load data from ajax
       $.ajax({
           url : "<?php echo site_url('dashboard/ajax_edit/')?>" + id,
           type: "GET",
           dataType: "JSON",
           success: function(data)
           {
               $('[name="kode"]').val(data.kode_kavling);
               $('[name="panjang_kanan"]').val(data.panjang_kanan);
               $('[name="panjang_kiri"]').val(data.panjang_kiri);
               $('[name="lebar_depan"]').val(data.lebar_depan);
               $('[name="lebar_belakang"]').val(data.lebar_belakang);
               $('[name="luas"]').val(data.luas_tanah);
               $('[name="harga_jual"]').val(data.harga_jual);
               $('[name="nama_marketing"]').val(data.nama_marketing);
               $('[name="nama_lengkap"]').val(data.nama_lengkap);
               
               if(data.status == '0'){
                  $('[name="status"]').val('Kosong');
               }else if(data.status == '1'){
                  $('[name="status"]').val('Booking');
               }else if(data.status == '2'){
                  $('[name="status"]').val('Terjual Cash');
               }else if(data.status == '3'){
                  $('[name="status"]').val('Terjual Kredit');
               }else if(data.status == '5'){
                  $('[name="status"]').val('Terjual Kredit # LUNAS');
               }
              
               $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
               $('.modal-title').text('Detail Kavling'); // Set title to Bootstrap modal title
              
           },
           error: function (jqXHR, textStatus, errorThrown)
           {
               alert('Error get data from ajax');
           }
       });
   }


</script>
