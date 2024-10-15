
<br>
<center>
    <h2>
        SITE PLAN
    </h2>
    <h2>Tanah Kavling Desa Pekandangan</h2>
    <h4>Update Tanggal : <?=tgl_indo(date('Y-m-d'));?></h4>
</center>




<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
<!-- Creator: CorelDRAW X8 -->
<svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" width="210mm" height="297mm" version="1.1" style="shape-rendering:geometricPrecision; text-rendering:geometricPrecision; image-rendering:optimizeQuality; fill-rule:evenodd; clip-rule:evenodd"
viewBox="0 0 21000 29700"
 xmlns:xlink="http://www.w3.org/1999/xlink">
 <defs>
  <style type="text/css">
   <![CDATA[
    .str1 {stroke:#332C2B;stroke-width:52.92}
    .str0 {stroke:#DCDDDD;stroke-width:20}
    .fil0 {fill:none}
    .fil4 {fill:#332C2B}
    .fil3 {fill:#D3CAC5}
    .fil5 {fill:#EEEEEF;fill-rule:nonzero}
    .fil1 {fill:#332C2B;fill-rule:nonzero}
    .fil2 {fill:#A2D3AB;fill-rule:nonzero}
    .fnt0 {font-weight:bold;font-size:269.78px;font-family:'Arial'}
    .fnt1 {font-weight:normal;font-size:447.97px;font-family:'Bahnschrift'}
   ]]>
  </style>
 </defs>
 <g id="Layer_x0020_1">
  <metadata id="CorelCorpID_0Corel-Layer"/>
  <rect class="fil0 str0" x="1038" y="624" width="9585" height="17166"/>
  <polygon class="fil1" points="8304,14560 9518,14560 9518,16758 8304,16758 8231,16758 7090,16758 7017,16758 5803,16758 5803,16721 5803,14560 7017,14560 7090,14560 8231,14560 "/>
  <polygon class="fil1" points="8304,9550 9518,9550 9518,11674 9518,11748 9518,13872 8304,13872 8231,13872 7090,13872 7017,13872 5803,13872 5803,13835 5803,11748 5803,11711 5803,11674 5803,9550 7017,9550 7090,9550 8231,9550 "/>
  <path class="fil1" d="M8251 4528c422,0 845,0 1267,0l0 2125 0 73 0 2124 -1214 0 -73 0 -1141 0 -73 0 -1214 0 0 -36 0 -2088 0 -37 0 -36 0 -2125c404,0 809,0 1214,0l73 0 1161 0z"/>
  <polygon class="fil1" points="8304,1647 9518,1647 9518,3845 8304,3845 8231,3845 7090,3845 7017,3845 5803,3845 5803,3808 5803,1647 7017,1647 7090,1647 8231,1647 "/>
  <polygon class="fil1" points="2920,3759 2920,1647 5118,1647 5118,3759 5118,3833 5118,4934 5118,5008 5118,6109 5118,6183 5118,7284 5118,7358 5118,8459 5118,8533 5118,9634 5118,9708 5118,10809 5118,10883 5118,11985 5118,12058 5118,13160 5118,13233 5118,14335 5118,14408 5118,15510 5118,15583 5118,16758 2920,16758 2920,15583 2920,15510 2920,14408 2920,14335 2920,13233 2920,13160 2920,12058 2920,11985 2920,10883 2920,10809 2920,9708 2920,9634 2920,8533 2920,8459 2920,7358 2920,7284 2920,6183 2920,6109 2920,5008 2920,4934 2920,3833 "/>
  <polygon class="fil2" points="5044,3759 5044,1721 2993,1721 2993,3759 "/>
  <polygon class="fil3 str1" points="5081,1684 5081,16721 5840,16721 5840,14597 9481,14597 9481,13839 5840,13839 5840,9587 9481,9587 9481,8828 5840,8828 5840,4565 9496,4565 9496,3806 5840,3806 5840,1684 10185,1684 10185,1045 1590,1045 1590,1684 "/>
  <text x="6386" y="4335"  class="fil4 fnt0">JALAN KAVLING</text>
  <g transform="matrix(2.64845E-14 1 -1 2.64845E-14 20243.3 -3308.48)">
   <text x="10500" y="14850"  class="fil4 fnt0">JALAN KAVLING 5 METER</text>
  </g>
  <text x="6386" y="9298"  class="fil4 fnt0">JALAN KAVLING</text>
  <text x="6386" y="14361"  class="fil4 fnt0">JALAN KAVLING</text>
  <text x="6300" y="1450"  class="fil4 fnt0">JALAN  DESA</text>
  <text x="3564" y="2686"  class="fil4 fnt0">TANAH</text>
  <text x="3662" y="2987"  class="fil4 fnt0">ADAT</text>


  <?php 
  $peta = $this->db->query("SELECT * FROM kavling_peta")->result();

  foreach ($peta as $pt) {
    if($pt->status == '0'){
      $warna = '#ffffff';
    }elseif($pt->status == '1'){
      $warna = '#FFF693';
    }elseif($pt->status == '2'){
      $warna = '#3DBEF0';
    }elseif($pt->status == '3'){
      $warna = '#F08519';
    }elseif($pt->status == '5'){
      $warna = '#606161';
    }



    if($pt->jenis_map == 'polygon'){
        echo '<a href="#bawah" onclick="add('.$pt->id_kavling.')">
         <g id="_1526838190224">
           <polygon class="fil5" points="'.$pt->map.'" style="fill:'.$warna.'"/>
           <g transform="'.$pt->matrik.'">
            <text x="10500" y="14850"  class="fil4 fnt1">'.$pt->kode_kavling.'</text>
           </g>
          </g>
      </a>';
    }

    if($pt->jenis_map == 'path'){
    echo '<a href="#bawah" onclick="add('.$pt->id_kavling.')">
    <g id="_2368771775280">
    <path class="fil4" d="'.$pt->map.'" style="fill:'.$warna.'"/>
    <g transform="'.$pt->matrik.'">
     <text x="8765" y="12246"  class="fil5 fnt0">'.$pt->kode_kavling.'</text>
    </g>
   </g>
   </a>';
    }


  //    if($pt->jenis_map == 'path'){
  //     echo '<a href="#bawah" onclick="add('.$pt->id_kavling.')">
  //     <g id="_2019809037472">
  //  <path class="fil3" d="'.$pt->map.'" style="fill:'.$warna.'"/>
  //  <g transform="'.$pt->matrik.'">
  //   <text x="9903" y="7409"  class="fil4 fnt1">'.$pt->kode_kavling.'</text>
  //  </g>
  // </g>

  //    </a> 
  //     ';
  //   }
  } 
  
  
  //Hitung statistik
  $stt_1 = $this->db->query("SELECT * FROM kavling_peta WHERE status='1'")->num_rows();
  $stt_2 = $this->db->query("SELECT * FROM kavling_peta WHERE status='2'")->num_rows();
  $stt_3 = $this->db->query("SELECT * FROM kavling_peta WHERE status='3'")->num_rows();
  $stt_0 = $this->db->query("SELECT * FROM kavling_peta")->num_rows();

  $kosong = $stt_0 - ($stt_1 + $stt_2 + $stt_3);
  ?>
  

  
</svg>














  
<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">
    <table class="table table-striped table-bordered">
        <tr>
            <td align="center">Jumlah Kavling</td>
            <td align="center">Kavling Terjual</td>
            <td align="center">Kavling Booking</td>
            <td align="center">Sisa Kavling</td>
        </tr>

        <tr>
            <td align="center"><?=$stt_0;?></td>
            <td align="center"><?=$stt_2 + $stt_3;?></td>
            <td align="center"><?=$stt_1;?></td>
            <td align="center"><?=$kosong;?></td>
        </tr>
    </table>
</div>
</div>
