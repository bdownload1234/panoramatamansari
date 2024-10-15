<?php


function hitungCicilan($id){

        $CI = &get_instance();
			$i =1;
            $jDAta = 0;
			$kavling = $CI->db->query("SELECT * FROM kavling_peta k 
			LEFT JOIN customer c ON k.id_customer=c.id_customer 
			LEFT JOIN transaksi_kavling t ON t.id_kavling=k.id_kavling 
			WHERE k.status='3' ORDER BY kode_kavling")->result();
			foreach($kavling as $kvg){
				//Pembayaran Terakhir
				$byrTerakhir = $CI->db->query("SELECT * FROM pembayaran WHERE id_kavling='$kvg->id_kavling' ORDER by pembayaran_ke DESC limit 0,1")->row_array();
				$pembayaranTerakhir = @$byrTerakhir['tanggal'];
				$bulanTerakhir = substr($pembayaranTerakhir, 5,2);
				//Tanggal Jatuh Tempo
				if($kvg->tgl_jatuh_tempo == '0'){ $jt = '10';}else{$jt = $kvg->tgl_jatuh_tempo;}

				$selisihBulan =  selisihBulan($kvg->tgl_mulai_cicilan);
				$selisihBulan = $selisihBulan;
				$pembayaranKe = @$byrTerakhir['pembayaran_ke'];


				//Cari pembayaran bulan ini
				$bulan = date('m');
				$bulanIni = $CI->db->query("SELECT * FROM pembayaran WHERE MONTH(tanggal) = '$bulan' AND id_kavling='$kvg->id_kavling' ORDER BY tanggal DESC LIMIT 0,1")->row_array();
				if($bulanIni){ 
					$tunggakan = '';
					$sudahBayar = '1';
				}else{ 
				  //cek apakah sudah jatuh Tempo
				  $sudahBayar = '0';
					//Hitung tunggakan
					@$tung = $selisihBulan - $pembayaranKe -1;
					$tunggakan = @$tung.' x<br>'.rupiah(@$tung * $kvg->cicilan_per_bulan);
				}


				//Looping Baris
                
				if($id == '0'){
					// semua data
					$jDAta++;
				}else if($id == '10'){
					//Tampilkan data yang sudah Bayar
					if($sudahBayar == '1'){
						$jDAta++;
					}
				}else if($id == '11'){
					//Tampilkan data yang belum bayar
					if($sudahBayar == '0'){
						$jDAta++;
					}
				}else if($id == '1' AND @$tung == '1'){
					//Tampilkan data tunggakan 1x
					if($sudahBayar == '0'){
						$jDAta++;
					}
				}else if($id == '2' AND @$tung == '2'){
					//Tampilkan data tunggakan 3x
					if($sudahBayar == '0'){
						$jDAta++;
					}
				}else if($id == '3' AND @$tung == '3'){
					//Tampilkan data tunggakan 3x
					if($sudahBayar == '0'){
						$jDAta++;
					}
				}else if($id == '4' AND @$tung > '3'){
					//Tampilkan data tunggakan lebih 3x
					if($sudahBayar == '0'){
						$jDAta++;
					}
				}
			}
		return $jDAta;
	}


function tgl_now() {
    date_default_timezone_set('Asia/Makassar');
    return date('Y-m-d');
}

function time_now() {
    date_default_timezone_set('Asia/Makassar');
    return date('H:i:s');
}

function tglTime_now() {
    date_default_timezone_set('Asia/Makassar');
    return date('Y-m-d H:i:s');
}

function aktifitas($aktifitas, $keterangan='')
{
    $CI = &get_instance();
    date_default_timezone_set('Asia/Makassar');
    $sekarang = date('Y-m-d H:i:s');
    $param = [
        'tanggal' => $sekarang, 
        'aktifitas' => $aktifitas, 
        'keterangan' => $keterangan, 
        'id_user' => $CI->encryption->decrypt($CI->session->userdata('id')), 
        'surname' => $CI->encryption->decrypt($CI->session->userdata('surname')), 
        'username' => $CI->encryption->decrypt($CI->session->userdata('username')), 
    ];
    $CI->db->insert('aktifitas', $param);
    return('true');
}

function durasi_menit($awal, $akhir) {
    date_default_timezone_set('Asia/Makassar');
    
    $waktu_awal        =strtotime($awal);
    $waktu_akhir    =strtotime($akhir); // bisa juga waktu sekarang now()

    //menghitung selisih dengan hasil detik
    $diff    = $waktu_akhir - $waktu_awal;
    $menit   = ceil($diff / (60));

    return $menit;
}

function rupiah($nilai, $pecahan = 0) {
    return number_format($nilai, $pecahan, ',', '.');
}


function konfigMedia($jenisData) {
    $CI = &get_instance();
    $confMedia = $CI->db->query("SELECT * FROM konfigurasi_media WHERE jenis_data = '$jenisData'")->row_array();
    return $confMedia;
}

function konfig() {
    $CI = &get_instance();
    $confMedia = $CI->db->query("SELECT * FROM konfigurasi WHERE id = '1'")->row_array();
    return $confMedia;
}

function konf() {
    $CI = &get_instance();
    $confMedia = $CI->db->query("SELECT * FROM konfigurasi WHERE id = '1'")->row_array();
    return $confMedia;
}


function terbilang($nilai) {
    $nilai = abs($nilai);
    $huruf = array("", "satu ", "dua ", "tiga ", "empat ", "lima ", "enam ", "tujuh ", "delapan ", "sembilan ", "sepuluh ", "sebelas ");
    $temp = "";
    if ($nilai < 12) {
        $temp = "". $huruf[$nilai];
    } else if ($nilai <20) {
        $temp = terbilang($nilai - 10). "belas ";
    } else if ($nilai < 100) {
        $temp = terbilang($nilai/10)."puluh ". terbilang($nilai % 10);
    } else if ($nilai < 200) {
        $temp = "seratus " . terbilang($nilai - 100);
    } else if ($nilai < 1000) {
        $temp = terbilang($nilai/100) . "ratus " . terbilang($nilai % 100);
    } else if ($nilai < 2000) {
        $temp = "seribu" . terbilang($nilai - 1000);
    } else if ($nilai < 1000000) {
        $temp = terbilang($nilai/1000) . "ribu " . terbilang($nilai % 1000);
    } else if ($nilai < 1000000000) {
        $temp = terbilang($nilai/1000000) . "juta " . terbilang($nilai % 1000000);
    } else if ($nilai < 1000000000000) {
        $temp = terbilang($nilai/1000000000) . "milyar" . terbilang(fmod($nilai,1000000000));
    } else if ($nilai < 1000000000000000) {
        $temp = terbilang($nilai/1000000000000) . "trilyun" . terbilang(fmod($nilai,1000000000000));
    }     
    return $temp;
}

function check_login()
{
    $CI = &get_instance();
    if ($CI->session->userdata('username') == '') {
        redirect('');
    }
}

function getUser()
{
    $CI = &get_instance();
    $idUser = $CI->encryption->decrypt($CI->session->userdata('id'));
    $dataUser = $CI->db->query("
            SELECT * FROM users a 
            LEFT JOIN registrasi b ON a.id_join=b.id_reg 
            LEFT JOIN teknisi c ON b.id_reg=c.id_reg WHERE a.id='$idUser'
            ")->row_array();

    return $dataUser;
}

function infoUser($kolom = "")
{
    $CI = &get_instance();
    $idUser = $CI->encryption->decrypt($CI->session->userdata('id'));
    $dataUser = $CI->db->query("
            SELECT $kolom as dataKolom FROM users a 
            LEFT JOIN registrasi b ON a.id_join=b.id_reg 
            LEFT JOIN teknisi c ON b.id_reg=c.id_reg WHERE a.id='$idUser'
            ")->row_array();

    return $dataUser['dataKolom'];
}


function selamat(){
    date_default_timezone_set("Asia/makassar");
    $jam = date("H:i:s");
    if($jam <='05:00:00'){
        echo "Selamat dini hari";
    }elseif($jam >='05:00:01' AND $jam <='11:00:00'){
        echo "Selamat Pagi";
    }elseif($jam >='11:00:01' AND $jam <='15:00:00'){
        echo "Selamat Siang";
    }elseif($jam >='15:00:01' AND $jam <='18:00:00'){
        echo "Selamat Sore";
    }elseif($jam >='18:00:01'){
        echo "Selamat Malam";
    }else{
        
    }
}



function tgl_indo($tgl){
    return substr($tgl, 8, 2).' '.getbln(substr($tgl, 5,2)).' '.substr($tgl, 0, 4);
}

function tgl_indo_slash($tgl){
    return substr($tgl, 8, 2).'/'.substr($tgl, 5,2).'/'.substr($tgl, 0, 4);
}

function thn_indo($tgl){
    return substr($tgl, 0, 4);
}

function bln_indo($tgl){
    return getbln(substr($tgl, 5,2));
}


function namaHari($tanggal){
    $day=date("D", strtotime ($tanggal)); 
        if($day=='Mon'){
            $day='Senin';
        }else if($day=='Tue'){
            $day='Selasa';
        }else if($day=='Wed'){
            $day='Rabu';
        }else if($day=='Thu'){
            $day='Kamis';
        }else if($day=='Fri'){
            $day='Jumat';
        }else if($day=='Sat'){
            $day='Sabtu';
        }else if($day=='Sun'){
            $day='Minggu';
        }
    return $day;
}

function namaHariKecil($tanggal){
    $day=date("D", strtotime ($tanggal)); 
        if($day=='Mon'){
            $day='senin';
        }else if($day=='Tue'){
            $day='selasa';
        }else if($day=='Wed'){
            $day='rabu';
        }else if($day=='Thu'){
            $day='kamis';
        }else if($day=='Fri'){
            $day='jumat';
        }else if($day=='Sat'){
            $day='sabtu';
        }else if($day=='Sun'){
            $day='minggu';
        }
    return $day;
}


function conHari($tanggal){
$day=date("D", strtotime ($tanggal)); 
    if($day=='Mon'){
        $day='senin';
    }else if($day=='Tue'){
        $day='selasa';
    }else if($day=='Wed'){
        $day='rabu';
    }else if($day=='Thu'){
        $day='kamis';
    }else if($day=='Fri'){
        $day='jumat';
    }else if($day=='Sat'){
        $day='sabtu';
    }else if($day=='Sun'){
        $day='minggu';
    }
return $day;
}


function getbln($bln){
    switch ($bln) 
    {
        
        case 1:
            return "Januari";
        break;

        case 2:
            return "Februari";
        break;

        case 3:
            return "Maret";
        break;

        case 4:
            return "April";
        break;

        case 5:
            return "Mei";
        break;

        case 6:
            return "Juni";
        break;

        case 7:
            return "Juli";
        break;

        case 8:
            return "Agustus";
        break;

        case 9:
            return "September";
        break;

         case 10:
            return "Oktober";
        break;

        case 11:
            return "November";
        break;

        case 12:
            return "Desember";
        break;
    }

}



function blnAngka($hari){
    if($hari == "Juli"){
        $hari = "7";
            return $hari;
    }elseif($hari == "Agustus"){
        $hari = "8";
            return $hari;
    }elseif($hari == "September"){
        $hari = "9";
            return $hari;
    }elseif($hari == "Oktober"){
        $hari = "10";
            return $hari;
    }elseif($hari == "November"){
        $hari = "11";
            return $hari;
    }elseif($hari == "Desember"){
        $hari = "12";
            return $hari;
    }elseif($hari == "Januari"){
        $hari = "1";
            return $hari;
    }elseif($hari == "Februari"){
        $hari = "2";
            return $hari;
    }elseif($hari == "Maret"){
        $hari = "3";
            return $hari;
    }elseif($hari == "April"){
        $hari = "4";
            return $hari;
    }elseif($hari == "Mei"){
        $hari = "5";
            return $hari;
    }elseif($hari == "Juni"){
        $hari = "6";
            return $hari;
    }
} 


if (!function_exists('dd')) {
    /**
     * Dump and Die function with improved formatting
     *
     * @param mixed $data - The data to be dumped
     */
    function dd($data)
    {
        echo '<style>
            pre {
                background-color: black;
                border: 1px solid black;
                border-radius: 4px;
                padding: 15px;
                font-size: 14px;
                color: green;
                max-height: 500px;
                overflow-y: auto;
                white-space: pre-wrap; /* To ensure long lines wrap */
            }
            body {
                font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            }
            </style>';

        echo '<pre>';
        var_dump($data); // you can replace this with print_r($data, true) if preferred
        echo '</pre>';

        die(); // Stop script execution
    }
}

if (!function_exists('convertToRoman'))
{
    function convertToRoman($month)
    {
        $roman_numerals = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 
            6 => 'VI', 7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 
            11 => 'XI', 12 => 'XII'
        ];
        return $roman_numerals[(int)$month];
    }
}