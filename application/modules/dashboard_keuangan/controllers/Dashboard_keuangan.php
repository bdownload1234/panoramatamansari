<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_keuangan extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->helper('customade');
		$this->load->library(array('form_validation'));	
		check_login();

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
		$this->load->view('stok',$data);
		$this->load->view('template/footer',$data);
	}

	public function ajax_edit($id)
	{
		$data = $this->db->query("SELECT * FROM kavling_peta a 
			LEFT JOIN customer b ON a.id_customer=b.id_customer 
			WHERE a.id_kavling = '$id' ")->row_array();
			$data['harga_jual'] = rupiah($data['hrg_jual']);
		echo json_encode($data);
	}


	public function detail($id)
	{
		$a = '<table id="table" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%"  >
		<thead>
			<tr>
				<th width="5%">No</th>
				<th width="5%">Lok Kavling</th>
				<th width="15%">Nama Customer</th>
				<th width="10%">Cicilan / Bulan</th>
				<th width="10%">Stt Bulan ini</th>
				<th width="10%">Jatuh Tempo</th>
				<th width="10%">Tunggakan</th>
				<th width="10%">Byr Terakhir</th>
			</tr>
		</thead>
		<tbody>';

		$tglSekarang = date('d');
		$BlnSekarang = date('m');
		$ThnSekarang = date('Y');
			$i =1;
			$kavling = $this->db->query("SELECT * FROM kavling_peta k 
			LEFT JOIN customer c ON k.id_customer=c.id_customer 
			LEFT JOIN transaksi_kavling t ON t.id_kavling=k.id_kavling 
			WHERE k.status='3' ORDER BY kode_kavling")->result();
			foreach($kavling as $kvg){
				//Pembayaran Terakhir
				$byrTerakhir = $this->db->query("SELECT * FROM pembayaran WHERE id_kavling='$kvg->id_kavling' ORDER by pembayaran_ke DESC limit 0,1")->row_array();
				$pembayaranTerakhir = @$byrTerakhir['tanggal'];
				$bulanTerakhir = substr($pembayaranTerakhir, 5,2);
				//Tanggal Jatuh Tempo
				if($kvg->tgl_jatuh_tempo == '0'){ $jt = '10';}else{$jt = $kvg->tgl_jatuh_tempo;}

				$selisihBulan =  selisihBulan($kvg->tgl_mulai_cicilan);
				$selisihBulan = $selisihBulan;
				$pembayaranKe = @$byrTerakhir['pembayaran_ke'];

				//Cari pembayaran bulan ini
				$bulan = date('m');
				$bulanIni = $this->db->query("SELECT * FROM pembayaran WHERE MONTH(tanggal) = '$bulan' AND id_kavling='$kvg->id_kavling' ORDER BY tanggal DESC LIMIT 0,1")->row_array();
				if($bulanIni){ 
					$lunas = '<span class="badge badge-secondary">Sudah Bayar</span>';
					$sudahBayar = '1';
					$tunggakan = '';
					
				}else{ 
					if($jt <= date('d')){
						$lunas = '<span class="badge badge-danger">Belum Bayar</span>';
					  }else{
						$lunas = '<span class="badge badge-warning">Belum Bayar</span>';
					  }
					$sudahBayar = '0';
					//Hitung tunggakan
					// $tung = $bulan - $bulanTerakhir;
					@$tung = $selisihBulan - $pembayaranKe -1;
					$tunggakan = @$tung.' x<br>'.rupiah(@$tung * $kvg->cicilan_per_bulan);
				}


				//Cari pembayaran bulan ini
				$bulan = date('m');
				$bulanIni = $this->db->query("SELECT * FROM pembayaran WHERE (MONTH(tanggal) = '$BlnSekarang' AND YEAR(tanggal) = '$ThnSekarang') AND id_kavling='$kvg->id_kavling' ORDER BY tanggal DESC LIMIT 0,1")->row_array();
				if($bulanIni){ 
					$lunas = '<span class="badge badge-secondary">Sudah Bayar</span>';
					$tunggakan = '';
					$sudahBayar = '1';
				}else{ 
				  //cek apakah sudah jatuh Tempo
				  if($jt <= date('d')){
					$lunas = '<span class="badge badge-warning">Belum Bayar</span>';
				  }else{
					$lunas = '<span class="badge badge-danger">Belum Bayar</span>';
				  }
				  $sudahBayar = '0';
					//Hitung tunggakan
					// $tung = $bulan - $bulanTerakhir;
					@$tung = $selisihBulan - $pembayaranKe -1;
					$tunggakan = @$tung.' x<br>'.rupiah(@$tung * $kvg->cicilan_per_bulan);
				}

				$link_detail = ' <a class="btn btn-xs btn-success" href="javascript:void(0)" title="Edit" onclick="edit('."'".$kvg->id_kavling."'".')">Edit Detail</a>';
				$link_history = ' <a class="btn btn-xs btn-warning" href="javascript:void(0)" title="Pembayaran" onclick="pembayaran('."'".$kvg->id_kavling."'".')">History Pembayaran</a>';
				$link_notif = ' <a class="btn btn-xs btn-info" href="javascript:void(0)" title="Hapus" onclick="notif('."'".$kvg->id_kavling."'".')"> Kirim Notif</a>';


				//Looping Baris
				if($id == '0'){
					//Tampilkan semua data
					$a .= '<tr>
							<td align="center">'.$i++.'</td>
							<td align="center">'.$kvg->kode_kavling.'</td>
							<td>'.$kvg->nama_lengkap.'<br><span class="badge badge-success">'.$kvg->no_telp.'</span><br>'.tgl_indo($kvg->tgl_akad).'</td>
							<td>'.$kvg->lama_cicilan.' Bulan<br>@ '.rupiah($kvg->cicilan_per_bulan).'<br><span class="badge badge-info">Berjalan '.$selisihBulan.' Bulan</span></td>
							<td><span class="badge badge-info">Bayar '.$pembayaranKe.' x</span><br>Sisa : '.($kvg->lama_cicilan - @$byrTerakhir['pembayaran_ke']).'</td>
							<td>Tgl : '.$jt.'<br>'.$lunas.'</td>
							<td>'.$tunggakan.'</td>
							<td align="center">'.@tgl_indo($byrTerakhir['tanggal']).'</td>
						</tr>';
				}else if($id == '10'){
					//Tampilkan data yang sudah Bayar
					if($sudahBayar == '1'){
						$a .= '<tr>
							<td align="center">'.$i++.'</td>
							<td align="center">'.$kvg->kode_kavling.'</td>
							<td>'.$kvg->nama_lengkap.'<br><span class="badge badge-success">'.$kvg->no_telp.'</span><br>'.tgl_indo($kvg->tgl_akad).'</td>
							<td>'.$kvg->lama_cicilan.' Bulan<br>@ '.rupiah($kvg->cicilan_per_bulan).'<br><span class="badge badge-info">Berjalan '.$selisihBulan.' Bulan</span></td>
							<td><span class="badge badge-info">Bayar '.$pembayaranKe.' x</span><br>Sisa : '.($kvg->lama_cicilan - @$byrTerakhir['pembayaran_ke']).'</td>
							<td>Tgl : '.$jt.'<br>'.$lunas.'</td>
							<td>'.$tunggakan.'</td>
							<td align="center">'.@tgl_indo($byrTerakhir['tanggal']).'</td>
						</tr>';
					}
				}else if($id == '11'){
					//Tampilkan data yang sudah Bayar
					if($sudahBayar == '0'){
						$a .= '<tr>
							<td align="center">'.$i++.'</td>
							<td align="center">'.$kvg->kode_kavling.'</td>
							<td>'.$kvg->nama_lengkap.'<br><span class="badge badge-success">'.$kvg->no_telp.'</span><br>'.tgl_indo($kvg->tgl_akad).'</td>
							<td>'.$kvg->lama_cicilan.' Bulan<br>@ '.rupiah($kvg->cicilan_per_bulan).'<br><span class="badge badge-info">Berjalan '.$selisihBulan.' Bulan</span></td>
							<td><span class="badge badge-info">Bayar '.$pembayaranKe.' x</span><br>Sisa : '.($kvg->lama_cicilan - @$byrTerakhir['pembayaran_ke']).'</td>
							<td>Tgl : '.$jt.'<br>'.$lunas.'</td>
							<td>'.$tunggakan.'</td>
							<td align="center">'.@tgl_indo($byrTerakhir['tanggal']).'</td>
						</tr>';
					}
				}else if($id == '1' AND @$tung == '1'){
					//Tampilkan data yang sudah Bayar
					if($sudahBayar == '0'){
						$a .= '<tr>
							<td align="center">'.$i++.'</td>
							<td align="center">'.$kvg->kode_kavling.'</td>
							<td>'.$kvg->nama_lengkap.'<br><span class="badge badge-success">'.$kvg->no_telp.'</span><br>'.tgl_indo($kvg->tgl_akad).'</td>
							<td>'.$kvg->lama_cicilan.' Bulan<br>@ '.rupiah($kvg->cicilan_per_bulan).'<br><span class="badge badge-info">Berjalan '.$selisihBulan.' Bulan</span></td>
							<td><span class="badge badge-info">Bayar '.$pembayaranKe.' x</span><br>Sisa : '.($kvg->lama_cicilan - @$byrTerakhir['pembayaran_ke']).'</td>
							<td>Tgl : '.$jt.'<br>'.$lunas.'</td>
							<td>'.$tunggakan.'</td>
							<td align="center">'.@tgl_indo($byrTerakhir['tanggal']).'</td>
						</tr>';
					}
				}else if($id == '2' AND @$tung == '2'){
					//Tampilkan data yang sudah Bayar
					if($sudahBayar == '0'){
						$a .= '<tr>
							<td align="center">'.$i++.'</td>
							<td align="center">'.$kvg->kode_kavling.'</td>
							<td>'.$kvg->nama_lengkap.'<br><span class="badge badge-success">'.$kvg->no_telp.'</span><br>'.tgl_indo($kvg->tgl_akad).'</td>
							<td>'.$kvg->lama_cicilan.' Bulan<br>@ '.rupiah($kvg->cicilan_per_bulan).'<br><span class="badge badge-info">Berjalan '.$selisihBulan.' Bulan</span></td>
							<td><span class="badge badge-info">Bayar '.$pembayaranKe.' x</span><br>Sisa : '.($kvg->lama_cicilan - @$byrTerakhir['pembayaran_ke']).'</td>
							<td>Tgl : '.$jt.'<br>'.$lunas.'</td>
							<td>'.$tunggakan.'</td>
							<td align="center">'.@tgl_indo($byrTerakhir['tanggal']).'</td>
						</tr>';
					}
				}else if($id == '3' AND @$tung == '3'){
					//Tampilkan data yang sudah Bayar
					if($sudahBayar == '0'){
						$a .= '<tr>
							<td align="center">'.$i++.'</td>
							<td align="center">'.$kvg->kode_kavling.'</td>
							<td>'.$kvg->nama_lengkap.'<br><span class="badge badge-success">'.$kvg->no_telp.'</span><br>'.tgl_indo($kvg->tgl_akad).'</td>
							<td>'.$kvg->lama_cicilan.' Bulan<br>@ '.rupiah($kvg->cicilan_per_bulan).'<br><span class="badge badge-info">Berjalan '.$selisihBulan.' Bulan</span></td>
							<td><span class="badge badge-info">Bayar '.$pembayaranKe.' x</span><br>Sisa : '.($kvg->lama_cicilan - @$byrTerakhir['pembayaran_ke']).'</td>
							<td>Tgl : '.$jt.'<br>'.$lunas.'</td>
							<td>'.$tunggakan.'</td>
							<td align="center">'.@tgl_indo($byrTerakhir['tanggal']).'</td>
						</tr>';
					}
				}else if($id == '4' AND @$tung > '3'){
					//Tampilkan data yang sudah Bayar
					if($sudahBayar == '0'){
						$a .= '<tr>
							<td align="center">'.$i++.'</td>
							<td align="center">'.$kvg->kode_kavling.'</td>
							<td>'.$kvg->nama_lengkap.'<br><span class="badge badge-success">'.$kvg->no_telp.'</span><br>'.tgl_indo($kvg->tgl_akad).'</td>
							<td>'.$kvg->lama_cicilan.' Bulan<br>@ '.rupiah($kvg->cicilan_per_bulan).'<br><span class="badge badge-info">Berjalan '.$selisihBulan.' Bulan</span></td>
							<td><span class="badge badge-info">Bayar '.$pembayaranKe.' x</span><br>Sisa : '.($kvg->lama_cicilan - @$byrTerakhir['pembayaran_ke']).'</td>
							<td>Tgl : '.$jt.'<br>'.$lunas.'</td>
							<td>'.$tunggakan.'</td>
							<td align="center">'.@tgl_indo($byrTerakhir['tanggal']).'</td>
						</tr>';
					}
				}
				
				
			}
		
				$a .= '</tbody>
			</table>';

			echo $a;
	}



	public function detail_data($param)
	{
	    if($param == 'all'){
	        $where = '';
	    }else{
	        $where = 'WHERE a.stt_kavling = '.$param;
	    }
	    
	    $data = array('data' => $this->db->query("SELECT * FROM kavling_peta a LEFT JOIN customer b ON a.kode_kavling = b.lokasi_kavling ".$where)->result(), 'stt' => $param);
	    
	    $this->load->view('template/header',$data);
		$this->load->view('detail_data',$data);
		$this->load->view('template/footer',$data);
	}
	
	public function detail_penjualan($param)
	{
	    if($param == 'spr'){
	        $where = 'status_spr = 0';
	    }else if($param == 'pindah_kavling'){
	        $where = 'status_spr = 12';
	    }else if($param == 'ganti_nama'){
	        $where = 'status_spr = 14';
	    }else if($param == 'batal'){
	        $where = 'status_spr = 13';
	    }
	    
	    if($param == 'batal'){
	        $data = array('data' => $this->db->query("SELECT *, '13' as status_spr, '-' as nomor_spr, '-' as tanggal_spr FROM pembatalan a LEFT JOIN customer b ON a.id_customer = b.id_customer LEFT JOIN kavling_peta c ON a.id_kavling = c.id_kavling")->result(), 'stt' => $param);
	    }else{
	        $data = array('data' => $this->db->query("SELECT * FROM spr a LEFT JOIN customer b ON a.id_customer = b.id_customer LEFT JOIN kavling_peta c ON a.kode_kavling = c.kode_kavling WHERE ".$where)->result(), 'stt' => $param);
	    }
	    
	    $this->load->view('template/header',$data);
		$this->load->view('detail_penjualan',$data);
		$this->load->view('template/footer',$data);
	}

    public function download_detail_data($param)
	{
	    if($param == 'all'){
	        $where = '';
	    }else{
	        $where = 'WHERE a.stt_kavling = '.$param;
	    }
		$data['data'] = $this->db->query("SELECT * FROM kavling_peta a LEFT JOIN customer b ON a.kode_kavling = b.lokasi_kavling ".$where)->result();
		$this->load->view('download_detail_data', $data);
	}
	
	public function download_detail_penjualan($param)
	{
	    if($param == 'spr'){
	        $where = 'status_spr = 0';
	    }else if($param == 'pindah_kavling'){
	        $where = 'status_spr = 12';
	    }else if($param == 'ganti_nama'){
	        $where = 'status_spr = 14';
	    }else if($param == 'batal'){
	        $where = 'status_spr = 13';
	    }
	    
		if($param == 'batal'){
	        $data = array('data' => $this->db->query("SELECT *, '13' as status_spr, '-' as nomor_spr, '-' as tanggal_spr FROM pembatalan a LEFT JOIN customer b ON a.id_customer = b.id_customer LEFT JOIN kavling_peta c ON a.id_kavling = c.id_kavling")->result(), 'stt' => $param);
	    }else{
	        $data = array('data' => $this->db->query("SELECT * FROM spr a LEFT JOIN customer b ON a.id_customer = b.id_customer LEFT JOIN kavling_peta c ON a.kode_kavling = c.kode_kavling WHERE ".$where)->result(), 'stt' => $param);
	    }
		$this->load->view('download_detail_penjualan', $data);
	}

}