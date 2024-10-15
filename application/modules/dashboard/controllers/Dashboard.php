<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->helper('customade');
		$this->load->library(array('form_validation'));	
		// check_login();

	}
	
	public function index()
	{
		$data=array();
		$csrf = array(
		        'name' => $this->security->get_csrf_token_name(),
		        'hash' => $this->security->get_csrf_hash()
		    );
		$data=array('csrf'=>$csrf);	


		$this->load->view('template/header',$data);
		$this->load->view('dashboard',$data);
		$this->load->view('template/footer',$data);
	}


	public function cetakhtml()
	{
		$data=array();
		$csrf = array(
		        'name' => $this->security->get_csrf_token_name(),
		        'hash' => $this->security->get_csrf_hash()
		    );
		$data=array('csrf'=>$csrf);	


		$this->load->view('template/header_kosong',$data);
		$this->load->view('cetak',$data);
		$this->load->view('template/footer_kosong',$data);
	}

	public function cetak_rencana()
	{
		$data=array();
		$csrf = array(
		        'name' => $this->security->get_csrf_token_name(),
		        'hash' => $this->security->get_csrf_hash()
		    );
		$data=array('csrf'=>$csrf);	


		$this->load->view('template/header_kosong',$data);
		$this->load->view('cetak_rencana',$data);
		$this->load->view('template/footer_kosong',$data);
	}


	public function ajax_edit($id)
	{
		$data = $this->db->query("SELECT * FROM kavling_peta a 
			LEFT JOIN customer b ON a.nik_customer = b.nik  
			WHERE a.id_kavling = '$id' ")->row_array();
			$data['harga_jual'] = rupiah($data['hrg_jual']);
		echo json_encode($data);
	}


	function cetak_rekap(){

        
		// $this->db->join('kavling_peta b', 'a.id_kavling = b.id_kavling', 'left');
		// $this->db->join('customer c', 'a.id_customer = c.id_customer', 'left');
		// $kavling = $this->db->get_where('kavling_peta a', array('a.id_kavling'=>$id_kavling))->row_array();
		$konfig = $this->db->get_where('konfigurasi a', array('a.id'=>'1'))->row_array();      
		
		//Harga Jual Kavling
		// $hrg = $this->db->query("SELECT * FROM transaksi_kavling WHERE id_kavling = '$id_kavling'")->row_array();
		// $hrgJual = $hrg['jumlah_dp'] + ($hrg['cicilan_per_bulan'] * $hrg['lama_cicilan']); //versi fix cicilan
		// $hrgJual = $kavling['hrg_jual']; //versi data kavling

        $config=array('orientation'=>'l','size'=>'legal');
        $this->load->library('MyPDF',$config);
        $this->mypdf->SetFont('Arial','B',10);
        $this->mypdf->SetLeftMargin(10);
        $this->mypdf->addPage();
        $this->mypdf->setTitle('Kwintasi Pembayaran');
        $this->mypdf->SetFont('Arial','B',16);

		//Master Desain background Kwitansi Pembayaran
		// $this->mypdf->Image(base_url().'assets/aplikasi/kwitansi.jpg',10,10,190);
		// LOgo Kavling
		// $this->mypdf->Image(base_url().'assets/aplikasi/'.$konfig['logo'],18,10,15);
		$this->mypdf->Cell(25,8, '',0,0,'C');
		$this->mypdf->Cell(320,8, 'RENCANA PENAGIHAN KONSUMEN',0,1,'C');
		$this->mypdf->SetFont('Arial','',12);
		$this->mypdf->Cell(25,8, '',0,0,'C');
		$this->mypdf->Cell(320,5,$konfig['nama_kavling'],0,1,'C');
		$this->mypdf->Cell(25,8, '',0,0,'C');
		$this->mypdf->Cell(320,5,'Periode Cetak :'.tgl_indo(date('Y-m-d')),0,1,'C');

		$this->mypdf->SetLineWidth(1);
		$this->mypdf->Line(35,30,345,30);
		$this->mypdf->SetLineWidth(0.3);
		$this->mypdf->Line(35,31,345,31);


        $this->mypdf->SetFont('Arial','B',9);
		$this->mypdf->SetTextColor(229,8,8);
        // $this->mypdf->text(158,33.7, $kavling['no_pembayaran']);
        $this->mypdf->SetTextColor(0,0,0);

		$this->mypdf->Ln(7);    



		//tabel
		$this->mypdf->SetFont('Times','B',10);  
		$this->mypdf->setFillColor(211,236,230); 
		$this->mypdf->Ln(5);    

		$this->mypdf->Cell(25,8, '',0,0,'C');
		$this->mypdf->Cell(8,10,'No. ',1,0,'C', 1);
		$this->mypdf->Cell(20,10,'Kode KAV',1,0,'C', 1);
		$this->mypdf->Cell(60,10, 'Nama Customer',1,0,'C', 1);
		$this->mypdf->Cell(35,10,'Terakhir Bayar',1,0,'C', 1);
		$this->mypdf->Cell(35,10,'Bayar',1,0,'C', 1);
		$this->mypdf->Cell(25,10,'Sales',1,0,'C', 1);
		$this->mypdf->Cell(25,10,'Paraf',1,0,'C', 1);
		$this->mypdf->Cell(35,10,'Sisa Hutang',1,0,'C', 1);
		$this->mypdf->Cell(25,10,'Paraf',1,0,'C', 1);
		$this->mypdf->Cell(40,10,'Keterangan',1,1,'C', 1);

		$no = 1;
		$query = "SELECT * FROM kavling_peta k 
        LEFT JOIN customer c ON k.id_customer = c.id_customer 
        WHERE k.status ='3'";    
        $tagih = $this->db->query($query)->result();
        foreach($tagih as $tgh){

			// cek bayar terakhir
            $quer2 = "SELECT * FROM pembayaran WHERE id_kavling='$tgh->id_kavling' ORDER BY pembayaran_ke DESC LIMIT 1";
            $terakhir = $this->db->query($quer2)->row_array();

            // Sisa Hutang
            $qSisa = "SELECT SUM(jumlah_bayar) as jum FROM pembayaran WHERE id_kavling='$tgh->id_kavling'";
            $sisa = $this->db->query($qSisa)->row_array();

            $this->mypdf->setFillColor(255, 255, 255); 

            $this->mypdf->Cell(25,8, '',0,0,'C');
			$this->mypdf->Cell(8,10, $no++,1,0,'C', 1);
			$this->mypdf->Cell(20,10, $tgh->kode_kavling,1,0,'C', 1);
			$this->mypdf->Cell(60,10, strtoupper($tgh->nama_lengkap),1,0,'C', 1);
			$this->mypdf->Cell(35,10, tgl_indo($terakhir['tanggal']),1,0,'C', 1);
			$this->mypdf->Cell(35,10,' ',1,0,'C', 1);
			$this->mypdf->Cell(25,10,' ',1,0,'C', 1);
			$this->mypdf->Cell(25,10,' ',1,0,'C', 1);
			$this->mypdf->Cell(35,10, rupiah($tgh->hrg_jual - $sisa['jum']),1,0,'C', 1);
			$this->mypdf->Cell(25,10,'',1,0,'C', 1);
			$this->mypdf->Cell(40,10,'',1,1,'C', 1);

		}

		

	
        


		$namaFile = str_replace('/','-', '0123/KNG/2022');
		$noFile = explode('-', $namaFile);
		

		if(file_exists('./kwitansi/'.$namaFile.'.pdf')){
			echo '';
		}else{
			$this->mypdf->Output('F', './kwitansi/kwitansi-'.$noFile[0].'.pdf', true);
		}
        

        $this->mypdf->Output();
    }


	function buatimage(){


		ob_start();
				$a =  '<?xml version="1.0" encoding="UTF-8"?>
				<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
				<svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" width="169.569mm" height="200.497mm" version="1.1" style="shape-rendering:geometricPrecision; text-rendering:geometricPrecision; image-rendering:optimizeQuality; fill-rule:evenodd; clip-rule:evenodd"
viewBox="0 0 14233 16829"
				xmlns:xlink="http://www.w3.org/1999/xlink">
				<defs>
				<style type="text/css">
				<![CDATA[
					.str0 {stroke:#EEEEEF;stroke-width:16.787}
					.fil0 {fill:none}
					.fil2 {fill:#DCDDDD}
					.fil6 {fill:#332C2B}
					.fil1 {fill:#D7EBD9}
					.fil4 {fill:black}
					.fil14 {fill:#010000}
					.fil17 {fill:#4C4C4C}
					.fil16 {fill:#7F0000}
					.fil18 {fill:#949494}
					.fil8 {fill:#9BCA34}
					.fil12 {fill:#A65F30}
					.fil7 {fill:#ACD4F0}
					.fil11 {fill:#C68836}
					.fil10 {fill:#D20029}
					.fil13 {fill:#D6E7E8}
					.fil5 {fill:#E3E3E3}
					.fil15 {fill:#EE821D}
					.fil9 {fill:#FDFDFA}
					.fil19 {fill:white}
					.fil20 {fill:#EEEEEF;fill-rule:nonzero}
					.fil3 {fill:#332C2B;fill-rule:nonzero}
					.fnt2 {font-weight:normal;font-size:266.494px;font-family:\'Arial\'}
					.fnt1 {font-weight:bold;font-size:325.718px;font-family:\'Arial\'}
					.fnt3 {font-weight:normal;font-size:355.322px;font-family:\'Bahnschrift\'}
					.fnt0 {font-weight:bold;font-size:451.033px;font-family:\'Arial\'}
				]]>
				</style>
				</defs>
				<g id="Layer_x0020_1">
				<metadata id="CorelCorpID_0Corel-Layer"/>
				<g id="_1440014684432">
				<rect class="fil0 str0" x="8" y="8" width="14216" height="16812"/>
				<rect class="fil1" x="689" y="2659" width="9930" height="13806"/>
				<polygon class="fil2" points="147,2089 14011,2089 14011,2414 14011,2774 7470,2774 7470,13736 10499,13736 10499,14368 819,14368 819,13736 6958,13736 6958,10076 819,10076 819,9495 6958,9495 6958,2774 147,2774 "/>
				<path class="fil3" d="M8900 14345l1607 0 0 2027 -1607 0 -45 0 -1562 0 -45 0 -1562 0 -44 0 -1563 0 -44 0 -1563 0 -44 0 -1607 0c0,-675 0,-1351 0,-2027l22 0 1585 0 44 0 1563 0 44 0 1563 0 22 0 22 0 1562 0 45 0 1562 0 45 0zm-3948 -11585l2028 0 0 2322 -2050 0 0 -2322 22 0zm5562 8061l0 1100 0 0 0 1838 -1514 0 -44 0 -1514 0 0 -1838 0 0 0 -1100 0 -45 0 -1055 0 -45 0 -1055 0 -45 0 -1055 0 -45 0 -1055 0 -45 0 -1055 0 -45 0 -2216 22 0 1492 0 44 0 1514 0 0 2216 0 45 0 1055 0 45 0 1055 0 45 0 1055 0 45 0 1055 0 45 0 1055 0 45zm-3556 -1304l-2020 0 -22 0 -22 0 -1997 0 -22 0 -23 0 -2041 0 0 -1872 0 -44 0 -1872 22 0 2019 0 23 0 22 0 1997 0 44 0 2042 0 0 1872 0 44 0 1872 -22 0zm21 2404l0 1838 -1531 0 -44 0 -1487 0 -44 0 -1487 0 -44 0 -1531 0 0 -1838 0 -45 0 -1838 2041 0 45 0 1997 0 44 0 2042 0 0 1883 -1 0z"/>
				<g>
					<g>
					<path class="fil4" d="M12294 9189c-51,-26 -335,-234 -361,-234 -3,18 41,70 55,91 22,37 168,256 175,274l-930 193c-18,4 -18,0 -18,15 0,11 99,25 113,29l835 175c-11,22 -95,149 -117,182l-113 168c-7,11 0,11 0,11 4,7 37,-19 44,-22 15,-11 29,-18 48,-29l178 -121c18,-11 73,-51 91,-58 33,131 70,335 99,478l98 463c4,18 15,21 22,-8l142 -692c18,-77 33,-164 51,-241 37,18 343,230 354,230 4,0 7,-4 7,-4l0 -7c0,0 -7,-11 -7,-11 -58,-84 -168,-252 -219,-336 11,-11 80,-21 117,-29 40,-7 76,-14 120,-22 226,-47 467,-102 693,-145 22,-4 18,0 18,-19l-948 -200c7,-18 44,-69 55,-91l175 -263c0,-7 0,-3 -4,-7 -18,-4 -324,215 -357,226 -11,-22 -164,-784 -186,-890 -4,-18 -7,-47 -18,-58 -18,0 -11,-4 -22,47l-37 179c-25,109 -142,707 -153,726z"/>
					<path class="fil5" d="M12495 9502c-4,-390 0,-784 0,-1174 -11,29 -157,737 -172,817 -7,25 -10,55 -18,80 -18,98 -36,58 88,179 14,14 87,91 102,98z"/>
					<path class="fil5" d="M12480 9535c-386,0 -780,-4 -1163,0 11,7 59,14 77,18 25,7 55,11 80,18l729 150c22,3 62,22 80,11l146 -146c15,-15 40,-37 51,-51z"/>
					<path class="fil5" d="M12509 10720c8,-19 44,-204 51,-241l103 -481c3,-29 51,-241 47,-248l-201 -201 0 1171z"/>
					<path class="fil5" d="M12524 9517c204,7 467,0 678,0l481 0c-18,-11 8,0 -7,-4 -4,-4 -7,-4 -15,-4l-91 -18c-40,-11 -80,-18 -120,-25l-602 -124c-40,-11 -83,-22 -124,-26 -18,15 -193,190 -200,201z"/>
					<path class="fil5" d="M11981 10056c11,-7 58,-40 73,-51l237 -153 -19 -87c-10,3 -3,0 -10,7 -4,4 -8,7 -11,7l-237 237c-4,7 -30,37 -33,40z"/>
					<path class="fil5" d="M12178 9316l87 -18c-14,-22 -120,-120 -142,-146 -26,-22 -47,-44 -73,-69 -18,-18 -58,-62 -73,-73 15,33 197,303 201,306z"/>
					<path class="fil5" d="M12739 9754c7,22 281,280 292,291 -8,-11 -40,-58 -51,-73l-153 -237 -88 19z"/>
					<polygon class="fil5" points="12710,9200 12728,9291 13023,8995 "/>
					</g>
					<text x="12341" y="8080"  class="fil6 fnt0">U</text>
				</g>
				<g>
					<path class="fil7" d="M11309 5760l340 0c74,0 357,-4 406,1l1 49c1,10 0,8 4,14l-2 -68 -522 -1 -1 -591 -52 -1c12,-31 118,-168 136,-206l47 0 -1 -424 -33 -1 112 -163 976 -1 111 164 -32 1 -1 424c57,1 38,-10 105,91 17,26 69,94 77,116l-52 0 -2 591c-74,3 -501,-10 -528,5l613 0c-6,-37 -2,-342 -2,-405 0,-57 -6,-375 2,-394 15,-1 183,-7 200,2l3 30 139 2 0 117 1 122 -173 1c-3,-17 1,-18 -6,-31l-132 -1 -3 557 331 0c112,-183 176,-399 176,-629 0,-667 -540,-1207 -1207,-1207 -667,0 -1208,540 -1208,1207 0,230 65,446 177,629z"/>
					<path class="fil8" d="M13371 5760l-331 0 -29 0 -613 0 -1 65 -32 0c-3,2 -246,12 -266,-2l-39 1c-4,-6 -3,-4 -4,-14l-1 -49c-49,-5 -332,-1 -406,-1l-340 0c212,347 594,578 1031,578 436,0 819,-231 1031,-578z"/>
					<path class="fil9" d="M11535 5164l1 591 522 1 2 68 39 -1 -1 -495 268 0 -1 497 32 0 1 -65c27,-15 454,-2 528,-5l2 -591 -530 0 -1 -68 -339 1 -1 67 -522 0z"/>
					<path class="fil9" d="M11666 4957l470 0c11,-11 32,-44 41,-58 13,-19 27,-39 40,-59 -4,-4 0,-7 -26,-7 -12,-1 -25,0 -37,0 -21,0 -43,1 -65,0l-1 -248 131 -1c4,58 -3,179 0,216 2,37 -4,21 15,22 14,22 29,42 44,65 13,20 37,51 46,70l474 0 1 -424 -1134 0 1 424z"/>
					<path class="fil10" d="M12217 4840c-13,20 -27,40 -40,59 -9,14 -30,47 -41,58l-470 0 -47 0c-18,38 -124,175 -136,206l52 1 522 0 1 -67 339 -1 1 68 530 0 52 0c-8,-22 -60,-90 -77,-116 -67,-101 -48,-90 -105,-91l-474 0c-9,-19 -33,-50 -46,-70 -15,-23 -30,-43 -44,-65 -7,19 2,10 -17,18z"/>
					<polygon class="fil10" points="11665,4533 12799,4533 12831,4532 12720,4368 11744,4369 11632,4532 "/>
					<path class="fil11" d="M12099 5823c20,14 263,4 266,2l1 -497 -268 0 1 495z"/>
					<path class="fil12" d="M12115 5761l0 52 234 1 1 -216c-36,0 -35,6 -38,-31 16,-10 -5,-3 18,-8 7,-2 12,-1 19,-1l0 -33 -234 1 0 235z"/>
					<path class="fil9" d="M13011 5760l29 0 3 -557 132 1c7,13 3,14 6,31l173 -1 -1 -122 -171 0 -1 -31 -138 0 1 -119 167 1c-17,-9 -185,-3 -200,-2 -8,19 -2,337 -2,394 0,63 -4,368 2,405z"/>
					<path class="fil11" d="M12680 5602l180 -1 1 -343 -182 -2c-5,38 -6,316 1,346z"/>
					<polygon class="fil11" points="12462,5601 12644,5601 12646,5257 12462,5256 "/>
					<polygon class="fil12" points="11603,5600 11785,5600 11784,5257 11604,5257 "/>
					<polygon class="fil12" points="11819,5600 12001,5600 12001,5257 11821,5257 "/>
					<polygon class="fil12" points="12115,5454 12116,5511 12347,5511 12350,5346 12115,5346 "/>
					<polygon class="fil10" points="13353,5112 13353,4995 13214,4993 13211,4963 13044,4962 13043,5081 13181,5081 13182,5112 "/>
					<polygon class="fil12" points="11723,4833 11854,4833 11855,4584 11724,4584 "/>
					<path class="fil12" d="M12217 4840c19,-8 10,1 17,-18 -19,-1 -13,15 -15,-22 -3,-37 4,-158 0,-216l-131 1 1 248c22,1 44,0 65,0 12,0 25,-1 37,0 26,0 22,3 26,7z"/>
					<polygon class="fil12" points="12445,4833 12576,4833 12578,4584 12446,4584 "/>
					<polygon class="fil12" points="12602,4833 12733,4833 12734,4585 12603,4584 "/>
					<polygon class="fil12" points="12244,4833 12376,4832 12376,4584 12245,4584 "/>
					<polygon class="fil12" points="11880,4833 12011,4833 12012,4585 11881,4584 "/>
					<polygon class="fil12" points="12690,5366 12851,5366 12851,5269 12690,5269 "/>
					<polygon class="fil12" points="12473,5366 12634,5366 12634,5269 12473,5269 "/>
					<polygon class="fil13" points="11914,5590 11992,5591 11992,5488 11914,5488 "/>
					<polygon class="fil13" points="11914,5477 11991,5478 11992,5374 11916,5374 "/>
					<polygon class="fil13" points="11612,5477 11690,5478 11690,5374 11614,5374 "/>
					<polygon class="fil13" points="11828,5478 11906,5478 11906,5374 11830,5373 "/>
					<polygon class="fil13" points="11612,5590 11690,5591 11690,5488 11613,5488 "/>
					<polygon class="fil13" points="11828,5591 11906,5590 11906,5490 11828,5487 "/>
					<polygon class="fil13" points="11698,5477 11775,5478 11775,5374 11700,5374 "/>
					<path class="fil13" d="M12558 5475c22,6 51,4 74,2l0 -102c-90,-4 -78,-15 -74,100z"/>
					<polygon class="fil13" points="11698,5589 11775,5591 11775,5487 11701,5487 "/>
					<path class="fil13" d="M12472 5475l75 3 0 -103c-87,-3 -80,-20 -75,100z"/>
					<polygon class="fil13" points="12689,5590 12705,5590 12764,5590 12764,5489 12728,5488 12714,5488 12689,5488 "/>
					<polygon class="fil13" points="12472,5590 12548,5590 12548,5489 12472,5488 "/>
					<polygon class="fil13" points="12558,5590 12633,5590 12633,5549 12633,5535 12633,5489 12615,5488 12597,5488 12558,5488 "/>
					<polygon class="fil13" points="12774,5508 12775,5553 12774,5567 12775,5590 12849,5590 12850,5489 12775,5488 "/>
					<polygon class="fil13" points="12689,5477 12764,5477 12764,5376 12690,5375 "/>
					<polygon class="fil13" points="12775,5478 12849,5477 12850,5376 12776,5375 "/>
					<path class="fil13" d="M12314 4825l56 2c1,-80 7,-77 -26,-78 -31,0 -36,-8 -30,76z"/>
					<path class="fil13" d="M12251 4825l56 2 0 -75c-66,-7 -60,-12 -56,73z"/>
					<path class="fil13" d="M12157 4745c71,3 59,-1 56,-75l-55 -2 -1 77z"/>
					<polygon class="fil13" points="12251,4745 12306,4745 12308,4669 12252,4668 "/>
					<polygon class="fil13" points="12094,4745 12149,4745 12151,4669 12095,4669 "/>
					<polygon class="fil13" points="12514,4827 12570,4827 12570,4751 12516,4750 "/>
					<polygon class="fil13" points="11792,4745 11847,4745 11848,4669 11793,4668 "/>
					<polygon class="fil13" points="12515,4745 12569,4745 12571,4669 12515,4668 "/>
					<polygon class="fil13" points="12609,4745 12664,4745 12665,4669 12610,4668 "/>
					<polygon class="fil13" points="11886,4745 11941,4745 11943,4669 11888,4668 "/>
					<polygon class="fil13" points="12094,4827 12150,4827 12150,4753 12094,4751 "/>
					<polygon class="fil13" points="11792,4827 11848,4827 11848,4751 11794,4750 "/>
					<polygon class="fil13" points="12314,4745 12370,4745 12370,4670 12315,4668 "/>
					<polygon class="fil13" points="11886,4827 11942,4827 11943,4753 11887,4751 "/>
					<polygon class="fil13" points="12609,4827 12664,4827 12665,4753 12609,4751 "/>
					<polygon class="fil13" points="11950,4745 12005,4745 12005,4670 11950,4668 "/>
					<polygon class="fil13" points="12672,4745 12727,4745 12727,4670 12673,4668 "/>
					<polygon class="fil13" points="11949,4827 12005,4827 12005,4754 11950,4751 "/>
					<polygon class="fil13" points="12672,4827 12727,4827 12728,4754 12672,4751 "/>
					<polygon class="fil13" points="12452,4781 12452,4826 12507,4827 12507,4752 12452,4752 "/>
					<polygon class="fil13" points="11730,4826 11785,4827 11784,4751 11731,4750 "/>
					<polygon class="fil13" points="12157,4827 12213,4827 12213,4754 12157,4751 "/>
					<polygon class="fil13" points="11730,4744 11783,4745 11785,4669 11730,4669 "/>
					<polygon class="fil13" points="12452,4744 12505,4745 12508,4669 12453,4669 "/>
				</g>
				<path class="fil3" d="M14011 2796l-6535 0 0 -44 6535 0 0 44zm-7060 0l-6804 0 0 -44 6804 0 0 44zm-6804 -730l13864 0 0 45 -13864 0 0 -45z"/>
				<g>
					<text x="11097" y="2548"  class="fil6 fnt1">JALAN DESA</text>
					<text x="647" y="2548"  class="fil6 fnt1">JALAN DESA</text>
					<text x="1875" y="4200"  class="fil6 fnt1">TANAH ADAT</text>
					<text x="3109" y="9891"  class="fil6 fnt2">Jalan Kavling</text>
					<text x="3109" y="14152"  class="fil6 fnt2">Jalan Kavling</text>
					<g transform="matrix(2.64845E-14 1 -1 2.64845E-14 19201.9 -1799.73)">
					<text x="8478" y="12073"  class="fil6 fnt2">Jalan Kavling</text>
					</g>
				</g>
				<g>
					<path class="fil14" d="M6914 629l0 -152 -185 1 -18 0 -1 89c1,89 -1,180 0,269 0,12 1,9 -6,16l-152 151c-2,2 -4,4 -6,6 -5,5 -8,10 -12,12l0 28 113 0 0 590 967 0c0,-99 -1,-197 0,-296 1,-19 -1,-285 1,-294l84 0 0 -28c-7,-5 -53,-51 -63,-61l-95 -92c-5,-5 -10,-10 -15,-15 -24,-25 -56,-53 -79,-77 -23,-23 -55,-52 -79,-77l-63 -61c-15,-17 -103,-98 -108,-107l-9 -7c-3,-3 -5,-5 -7,-7 -5,-5 -10,-10 -15,-15 -7,-6 -26,-23 -29,-29l-54 0c-2,5 -37,38 -42,43l-127 125 0 -12z"/>
					<path class="fil15" d="M6686 1617c1,0 413,3 436,1l0 -508 342 1 1 507 110 0c1,-22 0,-113 0,-143 0,-29 2,-417 -1,-426l-888 0 0 568z"/>
					<path class="fil16" d="M6602 1010l1028 0c-1,-4 -1,-2 -7,-8l-122 -119c-5,-5 -11,-10 -15,-15l-189 -183c0,0 0,-1 0,-1l-3 -3c-2,-2 -3,-2 -5,-4 -28,-26 -59,-59 -89,-87l-16 -16c-3,-3 -6,-5 -9,-8 -6,-6 -10,-10 -16,-16 -5,-5 -11,-11 -17,-16l-33 -32c-5,8 -94,94 -110,110l-63 64c-22,23 -56,55 -81,80l-118 118c-2,2 -3,3 -4,4l-68 68c-9,9 -62,60 -63,64z"/>
					<path class="fil17" d="M7161 1150l0 345c0,13 -1,107 1,117l252 0c5,0 12,2 12,-3l0 -456c0,-6 -22,-4 -30,-4l-235 1z"/>
					<polygon class="fil14" points="6752,1448 7031,1448 7032,1168 6752,1168 "/>
					<path class="fil16" d="M6750 806c19,-17 84,-84 103,-104 15,-14 22,-17 22,-29 0,-52 1,-105 0,-156 -23,-3 -50,0 -78,-1 -9,0 -25,1 -40,0 -4,0 -7,-1 -8,5l0 5c1,4 0,1 0,4 0,3 0,-1 0,2l0 54c0,0 0,4 0,6l0 39c0,3 0,-1 0,2l0 21c0,3 0,-1 0,2l0 6c0,2 0,-1 0,3l0 14c0,0 0,2 0,3l0 74c0,5 -1,-6 0,2l0 21c0,3 0,-2 0,2 0,2 1,0 0,4l0 17c0,3 -1,-1 0,2 0,0 1,1 1,2z"/>
					<path class="fil18" d="M6916 1284c2,3 35,1 39,1 9,0 31,2 39,-1l0 -77c-7,-2 -73,-2 -79,0 -3,8 -1,43 -1,57l0 16c1,5 1,3 2,4z"/>
					<path class="fil19" d="M6916 1284l76 0c0,-14 2,-67 -1,-76 -12,0 -68,-2 -74,1 -3,2 0,63 -1,75z"/>
				</g>
				<g>
					<g>
					<path class="fil14" d="M1773 629l0 -152 -185 1 -18 0 -1 89c1,89 -1,180 0,269 0,12 1,9 -6,16l-152 151c-2,2 -4,4 -6,6 -5,5 -8,10 -12,12l0 28 113 0 0 590 967 0c0,-99 -1,-197 0,-296 1,-19 -1,-285 1,-294l84 0 0 -28c-7,-5 -53,-51 -63,-61l-95 -92c-5,-5 -10,-10 -15,-15 -25,-25 -56,-53 -79,-77 -23,-23 -55,-52 -79,-77l-63 -61c-15,-17 -103,-98 -108,-107l-9 -7c-3,-3 -5,-5 -8,-7 -4,-5 -9,-10 -14,-15 -7,-6 -26,-23 -29,-29l-54 0c-2,5 -37,38 -42,43l-127 125 0 -12z"/>
					<path class="fil15" d="M1545 1617c1,0 413,3 436,1l0 -508 342 1 1 507 110 0c1,-22 0,-113 0,-143 0,-29 2,-417 -1,-426l-888 0 0 568z"/>
					<path class="fil16" d="M1461 1010l1028 0c-1,-4 -1,-2 -7,-8l-122 -119c-5,-5 -11,-10 -16,-15l-188 -183c0,0 0,-1 0,-1l-3 -3c-2,-2 -3,-2 -5,-4 -28,-26 -59,-59 -89,-87l-16 -16c-3,-3 -6,-5 -9,-8 -6,-6 -10,-10 -16,-16 -5,-5 -12,-11 -17,-16l-33 -32c-5,8 -94,94 -110,110l-63 64c-22,23 -56,55 -81,80l-119 118c-1,2 -2,3 -3,4l-68 68c-9,9 -62,60 -63,64z"/>
					<path class="fil17" d="M2020 1150l0 345c0,13 -1,107 1,117l252 0c5,0 12,2 12,-3l0 -456c0,-6 -22,-4 -30,-4l-235 1z"/>
					<polygon class="fil14" points="1611,1448 1890,1448 1891,1168 1611,1168 "/>
					<path class="fil16" d="M1609 806c19,-17 84,-84 103,-104 15,-14 22,-17 22,-29 0,-52 1,-105 0,-156 -23,-3 -50,0 -78,-1 -9,0 -25,1 -40,0 -4,0 -7,-1 -8,5l0 5c1,4 0,1 0,4 0,3 0,-1 0,2l0 54c0,0 0,4 0,6l0 39c0,3 0,-1 0,2l0 21c0,3 0,-1 0,2l0 6c0,2 0,-1 0,3l0 14c0,0 0,2 0,3l0 74c0,5 -1,-6 0,2l0 21c0,3 0,-2 0,2 0,2 1,0 0,4l0 17c0,3 -1,-1 0,2 0,0 1,1 1,2z"/>
					<path class="fil18" d="M1774 1284c3,3 36,1 39,1 10,0 32,2 40,-1l0 -77c-7,-2 -73,-2 -79,0 -3,8 -1,43 -1,57l0 16c1,5 0,3 1,4z"/>
					<path class="fil19" d="M1774 1284l77 0c0,-14 2,-67 -1,-76 -12,0 -68,-2 -74,1 -3,2 0,63 -2,75z"/>
					</g>
					<g>
					<path class="fil14" d="M12055 629l0 -152 -185 1 -18 0 -1 89c1,89 -1,180 0,269 1,12 1,9 -6,16l-152 151c-2,2 -4,4 -6,6 -5,5 -8,10 -12,12l0 28 113 0 1 590 966 0c0,-99 -1,-197 0,-296 1,-19 -1,-285 1,-294l84 0 0 -28c-7,-5 -53,-51 -63,-61l-95 -92c-5,-5 -10,-10 -15,-15 -24,-25 -56,-53 -79,-77 -23,-23 -54,-52 -79,-77l-63 -61c-15,-17 -103,-98 -108,-107l-9 -7c-3,-3 -5,-5 -7,-7 -5,-5 -10,-10 -15,-15 -6,-6 -26,-23 -29,-29l-54 0c-2,5 -37,38 -42,43l-127 125 0 -12z"/>
					<path class="fil15" d="M11827 1617c1,0 413,3 436,1l0 -508 342 1 1 507 110 0c2,-22 0,-113 0,-143 0,-29 2,-417 -1,-426l-888 0 0 568z"/>
					<path class="fil16" d="M11743 1010l1028 0c-1,-4 -1,-2 -7,-8l-122 -119c-5,-5 -11,-10 -15,-15l-189 -183c0,0 0,-1 0,-1l-3 -3c-2,-2 -3,-2 -5,-4 -28,-26 -59,-59 -89,-87l-16 -16c-3,-3 -6,-5 -9,-8 -6,-6 -10,-10 -16,-16 -5,-5 -11,-11 -17,-16l-33 -32c-5,8 -94,94 -110,110l-63 64c-22,23 -56,55 -81,80l-118 118c-2,2 -3,3 -4,4l-68 68c-9,9 -62,60 -63,64z"/>
					<path class="fil17" d="M12302 1150l0 345c0,13 -1,107 1,117l252 0c5,0 13,2 13,-3l0 -456c0,-6 -22,-4 -31,-4l-235 1z"/>
					<polygon class="fil14" points="11893,1448 12173,1448 12173,1168 11893,1168 "/>
					<path class="fil16" d="M11891 806c19,-17 84,-84 103,-104 15,-14 22,-17 22,-29 0,-52 1,-105 0,-156 -23,-3 -50,0 -78,-1 -9,0 -25,1 -40,0 -4,0 -6,-1 -8,5l0 5c1,4 0,1 0,4 0,3 0,-1 0,2l0 54c0,0 0,4 0,6l0 39c0,3 0,-1 0,2l0 21c0,3 0,-1 0,2l0 6c0,2 0,-1 0,3l0 14c0,0 0,2 0,3l0 74c0,5 -1,-6 0,2l0 21c0,3 0,-2 0,2 0,2 1,0 0,4l0 17c0,3 -1,-1 0,2 0,0 1,1 1,2z"/>
					<path class="fil18" d="M12057 1284c2,3 35,1 39,1 9,0 32,2 39,-1l0 -77c-6,-2 -73,-2 -79,0 -3,8 -1,43 -1,57l0 16c1,5 1,3 2,4z"/>
					<path class="fil19" d="M12057 1284l76 0c0,-14 2,-67 -1,-76 -11,0 -68,-2 -74,1 -3,2 0,63 -1,75z"/>
					</g>
				</g>';


				$peta = $this->db->query("SELECT * FROM kavling_peta")->result();
			  
				foreach ($peta as $pt) {
				  if($pt->stt_kavling == '0'){
					$warna = '#ffffff';
				  }elseif($pt->stt_kavling == '1'){
					$warna = '#FFF693';
				  }elseif($pt->stt_kavling == '2'){
					$warna = '#3DBEF0';
				  }elseif($pt->stt_kavling == '3'){
					$warna = '#F08519';
				  }elseif($pt->stt_kavling == '5'){
					$warna = '#606161';
				  }
			  
				  if($pt->jenis_map == 'polygon'){
					$a .=  '
					<g>
						<polygon class="fil20" points="'.$pt->map.'" style="fill:'.$warna.'"/>
						<g transform="'.$pt->matrik.'">
						<text x="8478" y="12073"  class="fil6 fnt3">'.$pt->kode_kavling.'</text>
						</g>
					  </g>';
				  }
			  
				  if($pt->jenis_map == 'path'){
					$a .=  '
					<g id="_2368771775280">
								<path class="fil4" d="'.$pt->map.'" style="fill:'.$warna.'"/>
								<g transform="'.$pt->matrik.'">
									<text x="8765" y="12246"  class="fil5 fnt0">'.$pt->kode_kavling.'</text>
								</g>
							</g>';
				  }
			  
				}
				
				$a .= '
				</g>
						</g>
						</svg>';
				echo $a;

			$content = ob_get_clean();

			$namaFile = date('YmdHis'); 

			if(file_put_contents("./image_manipulation/$namaFile.svg", $content)) { // Filename for storing purpose
				// echo "Success";
			}else{
				echo "Failed to save file";
			}

			$image = new Imagick();
			$image->readImageBlob(file_get_contents("./image_manipulation/$namaFile.svg"));
			$image->setImageFormat("jpg");
			$image->resizeImage(1690, 2000, imagick::FILTER_LANCZOS, 1); 
			$image->writeImage('htdocs/kav_pekandangan/image_manipulation/hasil_heru.jpg');

	}



	function cetak(){
		$this->buatimage();

        $config=array('orientation'=>'P','size'=>'A4');
        $this->load->library('MyPDF',$config);
        $this->mypdf->SetFont('Arial','B',10);
        $this->mypdf->SetLeftMargin(10);
        $this->mypdf->addPage();
        $this->mypdf->setTitle('Update_Denah_kavling');
        $this->mypdf->SetFont('Arial','B',18);

		$this->mypdf->Cell(190,8, ' SITE PLAN',0,1,'C');
		$this->mypdf->SetFont('Arial','',9);
		$this->mypdf->Cell(190,4, 'Tanah Kavling Desa Pekandangan',0,1,'C');
		$this->mypdf->Cell(190,4, 'Update per tanggal : '. tgl_indo(date('Y-m-d')),0,1,'C');

		$this->mypdf->SetLineWidth(1);
		$this->mypdf->Line(15,30,190,30);
		$this->mypdf->SetLineWidth(0.3);
		$this->mypdf->Line(15,31,190,31);


        $this->mypdf->SetFont('Arial','B',8);
		$this->mypdf->SetTextColor(229,8,8);
        // $this->mypdf->text(158,33.7, $kavling['no_pembayaran']);
        $this->mypdf->SetTextColor(0,0,0);

		$this->mypdf->Ln(7);    
		$this->mypdf->SetTextColor(0,0,0);

		$this->mypdf->SetLineWidth(0.1);
		$this->mypdf->SetFont('Times','',9);  

		
		//tabel
		$this->mypdf->SetFont('Arial','B',7);  
		$this->mypdf->setFillColor(211,236,230); 
		

		$this->mypdf->Image(base_url().'image_manipulation/hasil_heru.jpg',35,35,140);

		$this->mypdf->Ln(175);    
		$this->mypdf->Cell(50,10,'',0,0,'C');
		$this->mypdf->Cell(25,10,'Jumlah Kavling. ',1,0,'C', 1);
		$this->mypdf->Cell(25,10,'Kavling Terjual',1,0,'C', 1);
		$this->mypdf->Cell(25,10, 'Kavling Booking',1,0,'C', 1);
		$this->mypdf->Cell(25,10,'Sisa Kavling',1,1,'C', 1);

		$this->mypdf->Cell(50,10,'',0,0,'C');
		$this->mypdf->Cell(25,10,'Jumlah Kavling. ',1,0,'C', 0);
		$this->mypdf->Cell(25,10,'Kavling Terjual',1,0,'C', 0);
		$this->mypdf->Cell(25,10, 'Kavling Booking',1,0,'C', 0);
		$this->mypdf->Cell(25,10,'Sisa Kavling',1,1,'C', 0);

        

        $this->mypdf->Output();
    }

}