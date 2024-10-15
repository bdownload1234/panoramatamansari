<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transaksi extends CI_Controller
{

	var $data_ref = array('uri_controllers' => 'transaksi');

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Transaksi_model', 'transaksi');
		$this->load->model('Transaksi_booking_model', 'transaksi_booking');
		// $this->load->model('Group/Group_model','group');

		check_login();
	}

	public function index()
	{

		$user_data['data_ref'] = $this->data_ref;
		$user_data['menu_active'] = 'Data Referensi';

		$this->load->view('template/header', $user_data);
		$this->load->view('index', $user_data);
		// $this->load->view('template/footer',$user_data);

	}


	public function daridenah($id, $status)
	{
		$user_data['data_ref'] = $this->data_ref;
		$user_data['kav'] = $this->db->query("SELECT * FROM kavling_peta WHERE id_kavling='$id'")->row_array();
		if ($status == '0') {

			// JIka Kosong
			$this->load->view('template/header', $user_data);
			$this->load->view('transaksi', $user_data);
		} elseif ($status == '1') {
			// JIka booking
			$this->load->view('template/header', $user_data);
			$this->load->view('transaksi');
		} elseif ($status == '2') {
			// JIka Cash
			redirect('pembayaran/detail/' . $id);
		} elseif ($status == '3') {
			// Jika Kredit
			redirect('pembayaran_kredit/detail/' . $id);
		} elseif ($status == '4') {
			// Jika Cash Bertahap
			redirect('pembayaran/detail/' . $id);
		} elseif ($status == '5') {
			// Jika Kredit (Akad)
			redirect('pembayaran_kredit/detail/' . $id);
		}
	}


	public function booking()
	{

		$user_data['data_ref'] = $this->data_ref;

		$this->load->view('template/header', $user_data);
		$this->load->view('index_booking', $user_data);
		// $this->load->view('template/footer',$user_data);

	}


	public function ajax_list()
	{

		$list = $this->transaksi->get_datatables();
		$data = array();
		$no = $_POST['start'];

		foreach ($list as $post) {

			$link_edit = '<div class="text-center"><a class="btn btn-xs btn-primary" href="' . base_url("transaksi/edit/" . $post->id_pembelian) . '" ><i class="glyphicon glyphicon-pencil"></i> Edit</a></div>';
			// $link_edit2 = '<div class="text-center"> <a class="btn btn-xs btn-primary" href="javascript:void(0)" title="Hapus" onclick="edit(' . "'" . $post->id_pembelian . "'" . ')">Edit</a></div>';
			$link_hapus = '<div class="text-center"> <a class="btn btn-xs btn-danger" href="javascript:void(0)" title="Hapus" onclick="hapus(' . "'" . $post->id_pembelian . "'" . ')">Delete</a></div>';

			$no++;
			$row = array();
			$row[] = '<center>' . $no . '</center>';
			$row[] = $post->nama_lengkap;
			$row[] = '<center>' . $post->no_telp . '</center>';
			$row[] = '<center>' . $post->kode_kavling . '</center>';

			if ($post->jenis_pembelian == '1') {
				$row[] = '<center>' . "Booking" . '</center>';
			} else if ($post->jenis_pembelian == '2') {
				$row[] = '<center>' . "Cash Keras" . '</center>';
			} else if ($post->jenis_pembelian == '3') {
				$row[] = '<center>' . "Kredit" . '</center>';
			} else if ($post->jenis_pembelian == '4') {
				$row[] = '<center>' . "Cash Bertahap" . '</center>';
			} else if ($post->jenis_pembelian == '5') {
				$row[] = '<center>' . "Kredit (Akad)" . '</center>';
			}

			if ($post->jenis_pembelian != '1') {
				$akad = '<div class="text-center"><a class="btn btn-xs btn-success" href="' . base_url('ajb/spr_' . $post->id_pembelian . '_' . $post->kode_kavling . '.docx') . '" target="_blank">Cetak SPR</a></div>';
			} else {
				$akad = '';
			}
			$row[] = $akad;
			//add html for action
			$row[] = $link_edit . $link_hapus;

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->transaksi->count_all(),
			"recordsFiltered" => $this->transaksi->count_filtered(),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}



	public function tambah()
	{
		$a = $this->input->post('submit');
		if (isset($a)) {
			$user_data['harga_jual'] 		= $this->input->post('harga_jual');
			$user_data['dp'] 				= $this->input->post('uang_muka');
			$user_data['lama_cicilan'] 		= $this->input->post('bulan');
			$user_data['cicilan_per_bulan'] = $this->input->post('cicilan');
		} else {
			$user_data['harga_jual'] 		= '';
			$user_data['dp'] 				= '';
			$user_data['lama_cicilan'] 		= '';
			$user_data['cicilan_per_bulan'] = '';
		}

		$user_data['data_ref'] = $this->data_ref;
		$user_data['title'] = 'Sekolah';
		$user_data['menu_active'] = 'Data Referensi';
		$user_data['sub_menu_active'] = 'Sekolah';

		$this->load->view('template/header', $user_data);
		$this->load->view('transaksi', $user_data);
		// $this->load->view('template/footer',$user_data);

	}


	public function edit($id_pembelian)
	{

		$user_data['data_ref'] = $this->data_ref;
		$query = "SELECT * FROM transaksi_kavling t 
	LEFT JOIN kavling_peta p ON t.id_kavling = p.id_kavling 
	LEFT JOIN customer c ON t.id_customer = c.id_customer 
	LEFT JOIN marketing mr ON t.id_marketing = mr.id_marketing 
	LEFT JOIN bank b ON t.bank_id = b.bank_id 
	LEFT JOIN master_jenis_pembayaran mj ON t.id_jenis_pembayaran = mj.id_jenis_pembayaran 
	WHERE t.id_pembelian='$id_pembelian'";
		$user_data['kav'] = $this->db->query($query)->row_array();

		$this->load->view('template/header', $user_data);
		$this->load->view('edit', $user_data);
		// $this->load->view('template/footer',$user_data);

	}


	public function baru()
	{

		$tahun = date('Y');
		$nomor = $this->db->query("SELECT MAX(no_transaksi) as besar FROM transaksi_kavling WHERE no_transaksi like '%$tahun'")->row_array();
		$noSekarangTRX = $nomor['besar'];

		$urutanTRX = (int) substr($noSekarangTRX, 0, 5);
		$urutanTRX++;
		$hurufTRX = "/TRX-KAV/$tahun";
		$noPembayaranTRX = sprintf("%05s", $urutanTRX) . $hurufTRX;
		$bayar = $this->db->query("SELECT * FROM master_jenis_pembayaran WHERE id_jenis_pembayaran='id_bayar'")->row_array();

		$data = array(
			'tgl_pembelian' 	=> $this->input->post('tanggal'),
			'tgl_akad' 			=> $this->input->post('tanggal'),
			'tgl_mulai_cicilan'	=> $this->input->post('tanggal_tempo'),
			'no_transaksi' 		=> $noPembayaranTRX,
			'jenis_pembelian' 	=> $this->input->post('jenis'),
			'id_kavling' 		=> $this->input->post('id_kavling'),
			'id_customer' 		=> $this->input->post('customer'),
			'id_marketing' 		=> $this->input->post('marketing'),
			'bonus_gimmick' 	=> $this->input->post('bonus_gimmick'),
			'id_jenis_pembayaran'	=> str_replace('.', '', $this->input->post('cara_bayar')),
			'fee_marketing' 	=> str_replace('.', '', $this->input->post('fee_marketing')),
			'fee_notaris' 		=> str_replace('.', '', $this->input->post('fee_notaris')),
			'harga_jual' 		=> str_replace('.', '', $this->input->post('harga_jual')),
			'booking_fee' 		=> str_replace('.', '', $this->input->post('book_fee')),
			'bayar_cash' 		=> str_replace('.', '', $this->input->post('pem_cash')),
			'jumlah_dp' 		=> str_replace('.', '', $this->input->post('dp')),
			'booking_rp' 		=> str_replace('.', '', $this->input->post('pem_booking')),
			'cicilan_per_bulan' => str_replace('.', '', $this->input->post('cicilan_per_bulan')),
			'lama_cicilan' 		=> str_replace('.', '', $this->input->post('lama_cicilan')),
			'trx_ppn' 		=> $this->input->post('trx_ppn'),
			'trx_pph' 		=> $this->input->post('trx_pph'),
			'nomor_skp' 	=> $this->input->post('nomor_skp'),
			'nomor_skk' 	=> $this->input->post('nomor_skk'),
			'tujuan_trx' 		=> $this->input->post('tujuan_trx'),
			'sumber_dana' 		=> $this->input->post('sumber_dana'),
			'keterangan_trx' 		=> $this->input->post('keterangan_trx'),
			'bank_id' 		=> $this->input->post('bank'),

		);

		$this->db->insert('transaksi_kavling', $data);
		$id = $this->db->insert_id();
		$this->db->insert('transaksi_pembatalan', $data);

		$idKav = $this->input->post('id_kavling');
		$kav = $this->db->query("SELECT * FROM kavling_peta WHERE id_kavling='$idKav'")->row_array();
		$idCust = $this->input->post('customer');
		$cus = $this->db->query("SELECT * FROM customer WHERE id_customer='$idCust'")->row_array();

		//jenis Pembelian
		if ($this->input->post('jenis') == '3') {
			//Jika Kredit
			$deskripsi = 'Pembayaran DP Kavling #' . $kav['kode_kavling'] . ' a.n ' . $cus['nama_lengkap'];
		} else if ($this->input->post('jenis') == '2') {
			//Jika cash
			$deskripsi = 'Pembayaran Pembelian Kavling #' . $kav['kode_kavling'] . ' a.n ' . $cus['nama_lengkap'];
		} else if ($this->input->post('jenis') == '1') {
			//Jika Booking
			$deskripsi = 'Pembayaran Booking Kavling #' . $kav['kode_kavling'] . ' a.n ' . $cus['nama_lengkap'];
		} else if ($this->input->post('jenis') == '4') {
			//Jika cash
			$deskripsi = 'Pembayaran Pembelian Kavling #' . $kav['kode_kavling'] . ' a.n ' . $cus['nama_lengkap'];
		} else if ($this->input->post('jenis') == '5') {
			//Jika cash
			$deskripsi = 'Pembayaran DP Kavling #' . $kav['kode_kavling'] . ' a.n ' . $cus['nama_lengkap'];
		}

		if ($this->input->post('jenis') == '1') {
			$nominal = str_replace('.', '', $this->input->post('pem_booking'));
		} else if ($this->input->post('jenis') == '2') {
			$nominal = str_replace('.', '', $this->input->post('dp'));
		} else if ($this->input->post('jenis') == '3') {
			$nominal = str_replace('.', '', $this->input->post('dp'));
		} else if ($this->input->post('jenis') == '4') {
			$nominal = str_replace('.', '', $this->input->post('dp'));
		} else if ($this->input->post('jenis') == '5') {
			$nominal = str_replace('.', '', $this->input->post('dp'));
		}

		if ($this->input->post('jenis') != '1') {
			//Jika transaksi Bukan booking ===========================================>>
			$this->cetak($id);

			//Buat Nomor pembayaran
			//Buat pembayaran awal Kavling
			$tahun = date('Y');
			$nmr = $this->db->query("SELECT MAX(no_pembayaran) as besar FROM pembayaran WHERE no_pembayaran like '%$tahun'")->row_array();
			$noSekarang = $nmr['besar'];

			$urutan = (int) substr($noSekarang, 0, 5);
			$urutan++;
			$huruf = "/BYR-KAV/$tahun";
			$noPembayaran = sprintf("%05s", $urutan) . $huruf;

			//Input pembayaran
			$param = array(
				'id_customer' 	=> $this->input->post('customer'),
				'no_pembayaran' => $this->input->post('nomor_skp'),
				'deskripsi' 	=> $deskripsi,
				'id_kavling' 	=> $this->input->post('id_kavling'),
				'tanggal_bayar'	=> $this->input->post('tanggal'),
				'pembayaran_ke' => '0',
				'jumlah_bayar' 	=> $nominal,
				'keterangan'	=> '',
				'jenis_pembelian'	=> $this->input->post('jenis'),
				'status'		=> '1'
			);

			$this->db->insert('pembayaran', $param);
			$this->db->insert('pembatalan', $param);
		} else {
			//Jika Transaksi Booking ===========================================================================>
			$data = array(
				'tgl_pembelian' 		=> $this->input->post('tanggal'),
				'tgl_expired' 			=> $this->input->post('tgl_expired'),
				'jenis_pembelian' 		=> $this->input->post('jenis'),
				'id_kavling' 			=> $this->input->post('id_kavling'),
				'id_customer' 			=> $this->input->post('customer'),
				'nominal_booking' 		=> $this->input->post('pem_booking_int'),
				'keterangan_booking' 	=> $this->input->post('keterangan_booking')
			);
			$this->db->insert('transaksi_booking', $data);
		}
		$tglTempo = substr($this->input->post('tanggal_tempo'), 8, 2);
		//Update ke tabel kavling
		$this->db->update(
			'kavling_peta',
			array(
				'id_customer' => $this->input->post('customer'),
				'id_marketing' => $this->input->post('marketing'),
				'tgl_jatuh_tempo' => $tglTempo,
				'status' => $this->input->post('jenis')
			),
			array('id_kavling' => $this->input->post('id_kavling'))
		);

		//Update ke modul Transaksi keuangan
		//Input pembayaran
		$paramTrx = array(
			'transaksi_tanggal' 	=> $this->input->post('tanggal'),
			'transaksi_jenis' 		=> 'Pemasukan',
			'transaksi_barang' 		=> $this->input->post('kode_kavling'),
			'transaksi_nominal' 	=> $nominal,
			'transaksi_keterangan' 	=> $deskripsi,
			'transaksi_bank'		=> ''
		);
		$this->db->insert('transaksi', $paramTrx);

		redirect('transaksi');
	}

	public function update()
	{

		$data = array(
			'tgl_pembelian' 		=> $this->input->post('tanggal'),
			'tgl_akad' 				=> $this->input->post('tanggal'),
			'tgl_mulai_cicilan'		=> $this->input->post('tanggal_tempo'),
			'harga_jual' 			=> str_replace('.', '', $this->input->post('harga_jual')),
			'booking_fee' 			=> str_replace('.', '', $this->input->post('book_fee')),
			'jenis_pembelian' 		=> $this->input->post('jenis'),
			'id_jenis_pembayaran'	=> $this->input->post('id_jenis_pembayaran'),
			'nomor_skp' 			=> $this->input->post('nomor_skp'),
			'nomor_skk' 			=> $this->input->post('nomor_skk'),
			'id_customer' 			=> $this->input->post('id_customer'),
			'id_marketing' 			=> $this->input->post('id_marketing'),
			'jumlah_dp' 			=> $this->input->post('jumlah_dp'),
			'lama_cicilan' 			=> $this->input->post('lama_cicilan'),
			'cicilan_per_bulan'		=> str_replace('.', '', $this->input->post('cicilan_per_bulan')),
			'trx_ppn' 				=> $this->input->post('trx_ppn'),
			'trx_pph' 				=> $this->input->post('trx_pph'),
			'bank_id' 				=> $this->input->post('bank_id'),
			'bonus_gimmick' 		=> $this->input->post('bonus_gimmick'),
			'sumber_dana' 			=> $this->input->post('sumber_dana'),
			'tujuan_trx' 			=> $this->input->post('tujuan_trx'),
			'fee_marketing' 		=> str_replace('.', '', $this->input->post('fee_marketing')),
			'keterangan_trx' 		=> $this->input->post('keterangan_trx'),

		);

		$id_pembelian = $this->input->post('id');
		$this->db->where('id_pembelian', $id_pembelian);
		$this->db->update('transaksi_kavling', $data);

		$id_customer = $this->input->post('customer');
		$this->db->where('id_customer', $id_customer);
		$this->db->update('transaksi_pembatalan', $data, array('id_customer' => $id_customer));

		$id = $this->input->post('id');
		$this->cetak($id);


		$idKav = $this->input->post('id_kavling');
		$kav = $this->db->query("SELECT * FROM kavling_peta WHERE id_kavling='$idKav'")->row_array();
		$idCust = $this->input->post('customer');
		$cus = $this->db->query("SELECT * FROM customer WHERE id_customer='$idCust'")->row_array();

		//jenis Pembelian
		if ($this->input->post('jenis') == '3') {
			//Jika Kredit
			$deskripsi = 'Pembayaran DP Kavling #' . $kav['kode_kavling'] . ' a.n ' . $cus['nama_lengkap'];
		} else if ($this->input->post('jenis') == '2') {
			//Jika cash
			$deskripsi = 'Pembayaran Pembelian Kavling #' . $kav['kode_kavling'] . ' a.n ' . $cus['nama_lengkap'];
		} else if ($this->input->post('jenis') == '1') {
			//Jika Booking
			$deskripsi = 'Pembayaran Booking Kavling #' . $kav['kode_kavling'] . ' a.n ' . $cus['nama_lengkap'];
		} else if ($this->input->post('jenis') == '4') {
			//Jika cash
			$deskripsi = 'Pembayaran Pembelian Kavling #' . $kav['kode_kavling'] . ' a.n ' . $cus['nama_lengkap'];
		} else if ($this->input->post('jenis') == '5') {
			//Jika cash
			$deskripsi = 'Pembayaran DP Kavling #' . $kav['kode_kavling'] . ' a.n ' . $cus['nama_lengkap'];
		}

		//	$this->cetak($id);

		// if ($this->input->post('jenis') == '1') {
		// 	$nominal = str_replace('.', '', $this->input->post('pem_booking'));
		// } else if ($this->input->post('jenis') == '2') {
		// 	$nominal = str_replace('.', '', $this->input->post('dp'));
		// } else if ($this->input->post('jenis') == '3') {
		// 	$nominal = str_replace('.', '', $this->input->post('dp'));
		// }

		// if ($this->input->post('jenis') != '1') {
		// 	//Jika transaksi Bukan booking ===========================================>>
		// 	// $this->cetak($id);

		// 	//Buat Nomor pembayaran
		// 	//Buat pembayaran awal Kavling
		// 	$tahun = date('Y');
		// 	$nmr = $this->db->query("SELECT MAX(no_pembayaran) as besar FROM pembayaran WHERE no_pembayaran like '%$tahun'")->row_array();
		// 	$noSekarang = $nmr['besar'];

		// 	$urutan = (int) substr($noSekarang, 0, 5);
		// 	$urutan++;
		// 	$huruf = "/BYR-KAV/$tahun";
		// 	$noPembayaran = sprintf("%05s", $urutan) . $huruf;

		// 	//Input pembayaran
		// 	$param = array(
		// 		'id_customer' 	=> $this->input->post('customer'),
		// 		'no_pembayaran' => $this->input->post('nomor_skp'),
		// 		'deskripsi' 	=> $deskripsi,
		// 		'id_kavling' 	=> $this->input->post('id_kavling'),
		// 		'tanggal_bayar'	=> tgl_now(),
		// 		'pembayaran_ke' => '0',
		// 		'jumlah_bayar' 	=> $nominal,
		// 		'keterangan'	=> '',
		// 		'jenis_pembelian'	=> $this->input->post('jenis'),
		// 		'status'		=> '1'
		// 	);

		// 	$id_customer = $this->input->post('customer');
		// 	$this->db->where('id_customer', $id_customer);
		// 	$this->db->update('pembayaran', $param);
		// 	$this->db->update('pembatalan', $param);
		// } else {
		// 	//Jika Transaksi Booking ===========================================================================>
		// 	$data = array(
		// 		'tgl_pembelian' 		=> $this->input->post('tanggal'),
		// 		'tgl_expired' 			=> $this->input->post('tgl_expired'),
		// 		'jenis_pembelian' 		=> $this->input->post('jenis'),
		// 		'id_kavling' 			=> $this->input->post('id_kavling'),
		// 		'id_customer' 			=> $this->input->post('customer'),
		// 		'nominal_booking' 		=> $this->input->post('pem_booking_int'),
		// 		'keterangan_booking' 	=> $this->input->post('keterangan_booking')
		// 	);
		// 	$id_customer = $this->input->post('customer');
		// 	$this->db->where('id_customer', $id_customer);
		// 	$this->db->update('transaksi_booking', $data);
		// }
		// $tglTempo = substr($this->input->post('tanggal_tempo'), 8, 2);
		// // //Update ke tabel kavling
		// // $this->db->update(
		// // 	'kavling_peta',
		// // 	array(
		// // 		'id_customer' => $this->input->post('customer'),
		// // 		'id_marketing' => $this->input->post('marketing'),
		// // 		'tgl_jatuh_tempo' => $tglTempo,
		// // 		'status' => $this->input->post('jenis')
		// // 	),
		// // 	array('id_kavling' => $this->input->post('id_kavling'))
		// // );

		//Update ke modul Transaksi keuangan
		// //Input pembayaran
		// $paramTrx = array(
		// 	'transaksi_tanggal' 	=> $this->input->post('tanggal'),
		// 	'transaksi_jenis' 		=> 'Pemasukan',
		// 	'transaksi_barang' 		=> $this->input->post('kode_kavling'),
		// 	'transaksi_nominal' 	=> $nominal,
		// 	'transaksi_keterangan' 	=> $deskripsi,
		// 	'transaksi_bank'		=> ''
		// );
		// $this->db->insert('transaksi', $paramTrx);

		redirect('transaksi');
	}


	public function ajax_edit($id)
	{
		$this->db->from('transaksi_booking');
		$this->db->join('customer', 'transaksi_booking.id_customer = customer.id_customer', 'left');
		$this->db->join('kavling_peta', 'transaksi_booking.id_kavling = kavling_peta.id_kavling', 'left');
		$this->db->where('id_pembelian', $id);
		$data = $this->db->get()->row();

		echo json_encode($data);
	}




	public function ajax_select_customer()
	{
		$this->db->select('id_customer,nama_lengkap');
		$this->db->like('nama_lengkap', $this->input->get('q'), 'both');
		$this->db->limit(20);
		$items = $this->db->get('customer')->result_array();
		//output to json format
		echo json_encode($items);
	}

	// Controller
	public function get_data_by_customer()
	{
		$customer = $this->input->post('customer');
		$data = $this->db->get_where('customer', array('id_customer' => $customer))->row();
		echo json_encode(array(
			'no_ktp' => $data->no_ktp
		));
	}



	public function ajax_select_marketing()
	{
		$this->db->select('id_marketing, nama_marketing');
		$this->db->like('nama_marketing', $this->input->get('q'), 'both');
		$this->db->limit(20);
		$items = $this->db->get('marketing')->result_array();
		//output to json format
		echo json_encode($items);
	}

	public function ajax_select_bank()
	{
		$this->db->select('bank_id, bank_nama, bank_nomor');
		$this->db->like('bank_nama', $this->input->get('q'), 'both');
		$this->db->limit(20);
		$items = $this->db->get('bank')->result_array();
		//output to json format
		echo json_encode($items);
	}

	public function ajax_select_cara_bayar()
	{
		$this->db->select('id_jenis_pembayaran, cara_bayar');
		$this->db->like('cara_bayar', $this->input->get('q'), 'both');
		$this->db->limit(20);
		$items = $this->db->get('master_jenis_pembayaran')->result_array();
		//output to json format
		echo json_encode($items);
	}

	// Controller
	public function get_data_by_cara_bayar()
	{
		$cara_bayar = $this->input->post('cara_bayar');
		$data = $this->db->get_where('master_jenis_pembayaran', array('id_jenis_pembayaran' => $cara_bayar))->row();
		echo json_encode(array(
			'harga_transaksi' => $data->harga_transaksi,
			'lama_pembayaran' => $data->lama_pembayaran
		));
	}


	public function ajax_select_kavling()
	{
		$this->db->select('id_kavling,kode_kavling');
		$this->db->like('kode_kavling', $this->input->get('q'), 'both');
		$this->db->limit(20);
		$items = $this->db->get_where('kavling_peta', ['status' => '0'])->result_array();
		//output to json format
		echo json_encode($items);
	}




	public function cetak($id_transaksi)
	{

		$query = "SELECT t.*, p.*, c.*, mr.nama_marketing, b.*, m.*, lk.nama_kavling, ak.*
		FROM transaksi_kavling t 
			LEFT JOIN kavling_peta p ON t.id_kavling = p.id_kavling 
			LEFT JOIN customer c ON t.id_customer = c.id_customer 
			LEFT JOIN marketing mr ON t.id_marketing = mr.id_marketing 
			LEFT JOIN bank b ON t.bank_id = b.bank_id
			LEFT JOIN master_jenis_pembayaran m ON t.id_jenis_pembayaran = m.id_jenis_pembayaran
			LEFT JOIN lokasi_kavling lk ON p.id_lokasi = lk.id_lokasi
			LEFT JOIN akad_kredit ak ON t.id_pembelian = ak.id_pembelian
		WHERE t.id_pembelian='$id_transaksi'";
		$item = $this->db->query($query)->row_array();

		if ($item['jenis_pembelian'] == '3') {
			$file = 'assets/aplikasi/spr_kota_sutera.docx';
		} else if ($item['jenis_pembelian'] == '2') {
			$file = 'assets/aplikasi/spr_kota_sutera_cash.docx';
		} else if ($item['jenis_pembelian'] == '4') {
			$file = 'assets/aplikasi/spr_kota_sutera_cash.docx';
		} else if ($item['jenis_pembelian'] == '5') {
			$file = 'assets/aplikasi/spr_kota_sutera.docx';
		}

		// $jJual = is_numeric($item['jumlah_dp']) + (is_numeric($item['cicilan_per_bulan']) * is_numeric($item['lama_cicilan']));
		// $jJual = $item['jumlah_dp'] + ($item['cicilan_per_bulan'] * $item['lama_cicilan']);
		// $jumlahHutang = ($item['cicilan_per_bulan'] * $item['lama_cicilan']);

		$plafon = $item['jumlah_dp'] + $item['booking_fee'];
		$plafon_kredit = $item['harga_jual'] - $plafon;

		$plafon_cash = $item['jumlah_dp'];
		$plafon_kredit_cash = $item['harga_jual'] - $plafon_cash;



		$templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($file);

		// Set the plafon kredit and tanggal akad
		$templateProcessor->setValue('plafon_kredit', 'Rp. ' . rupiah($plafon_kredit));
		$templateProcessor->setValue('plafon_kredit_cash', 'Rp. ' . rupiah($plafon_kredit_cash));
		$templateProcessor->setValue('tanggal_akad', $item['tanggal_akad']);


		$lama_cicilan = $item['lama_cicilan'];
		$cicilan_per_bulan = $item['cicilan_per_bulan'];

		if (isset($item['tgl_mulai_cicilan'])) {
			$tgl_mulai_cicilan = $item['tgl_mulai_cicilan'];
			// Calculate the date for each installment
			for ($i = 1; $i <= $lama_cicilan; $i++) {
				if ($i == 1) {
					// Jatuh tempo for the first installment is based on $tgl_mulai_cicilan
					$jatuh_tempo = $tgl_mulai_cicilan;
				} else {
					// Jatuh tempo for the next installments is based on the previous jatuh tempo
					$jatuh_tempo = date('d M Y', strtotime("+1 month", strtotime($jatuh_tempo)));
				}
				$templateProcessor->setValue('cicilan_ke' . $i, 'Cicilan ke ' . $i);
				$templateProcessor->setValue('cicilan_per_bulan' . $i, 'Rp. ' . rupiah($cicilan_per_bulan));
				$templateProcessor->setValue('jatuh_tempo' . $i, $jatuh_tempo);
			}
		} else {
			for ($i = 1; $i <= $lama_cicilan; $i++) {
				$templateProcessor->setValue('cicilan_ke' . $i, 'Cicilan ke ' . $i);
				$templateProcessor->setValue('cicilan_per_bulan' . $i, 'Rp. ' . rupiah($cicilan_per_bulan));
				$templateProcessor->setValue('jatuh_tempo' . $i, '');
			}
		}

		// Remove the remaining rows if any
		if ($lama_cicilan < 5) {
			for ($i = $lama_cicilan + 1; $i <= 5; $i++) {
				$templateProcessor->setValue('cicilan_ke' . $i, '');
				$templateProcessor->setValue('cicilan_per_bulan' . $i, '');
				$templateProcessor->setValue('jatuh_tempo' . $i, '');
			}
		}

		$templateProcessor->setValue('lama_cicilan', implode("<w:br/>", array_map(function ($i) {
			return 'Cicilan ke ' . $i;
		}, range(1, $lama_cicilan))));

		$templateProcessor->setValue('cicilan_per_bulan', implode("<w:br/>", array_map(function ($i) use ($cicilan_per_bulan) {
			return 'Rp. ' . rupiah($cicilan_per_bulan);
		}, range(1, $lama_cicilan))));

		$jatuh_tempo = ''; // Definisikan variabel jatuh_tempo di luar fungsi array_map()

		$templateProcessor->setValue('jatuh_tempo', implode("<w:br/>", array_map(function ($i) use ($item, $tgl_mulai_cicilan, &$jatuh_tempo) {
			if (isset($item['tgl_mulai_cicilan'])) {
				if ($i == 1) {
					// Jatuh tempo for the first installment is based on $tgl_mulai_cicilan
					$jatuh_tempo = tgl_eng($tgl_mulai_cicilan);
				} else {
					// Jatuh tempo for the next installments is based on the previous jatuh tempo
					$jatuh_tempo = date('d M Y', strtotime("+1 month", strtotime($jatuh_tempo)));
				}
				return $jatuh_tempo;
			} else {
				return '';
			}
		}, range(1, $lama_cicilan))));

		// Set the value for tanggal_plafon
		$templateProcessor->setValue('tanggal_plafon', date('d M Y', strtotime("+1 month", strtotime($jatuh_tempo))));



		$templateProcessor->setValue('booking_fee', 'Rp. ' . rupiah($item['booking_fee']));


		// $templateProcessor->setValue('harga_jual', rupiah($jJual));
		// $templateProcessor->setValue('terbilang', ucwords(penyebut($jJual)));
		// $templateProcessor->setValue('jumlah_hutang', rupiah($jumlahHutang));
		// $templateProcessor->setValue('jumlah_hutang_terbilang', ucwords(penyebut($jumlahHutang)));

		$templateProcessor->setValue('jumlah_dp_terbilang', ucwords(penyebut($item['jumlah_dp'])));

		// $kodeKavling = $item['kode_kavling'];
		$templateProcessor->setValue('no_transaksi', $item['no_transaksi']);
		$templateProcessor->setValue('nomor_skp', $item['nomor_skp']);
		$templateProcessor->setValue('tgl', tgl_indo(date('d')));
		$templateProcessor->setValue('tanggal', tgl_indo(date('Y-m-d')));
		$templateProcessor->setValue('nama_hari', namaHari(date('Y-m-d')));
		$templateProcessor->setValue('nama_kavling', $item['nama_kavling']);
		$templateProcessor->setValue('tgl_pembelian', tgl_eng($item['tgl_pembelian']));

		$kode_kavling = str_replace('-', '/', $item['kode_kavling']);
		$kavling_parts = explode('/', $kode_kavling);

		if (strlen($kavling_parts[1]) == 1) {
			$kavling_parts[1] = str_pad($kavling_parts[1], 2, '0', STR_PAD_LEFT);
		}

		$kode_kavling = implode('/', $kavling_parts);

		$templateProcessor->setValue('kode_kavling', $kode_kavling);


		$templateProcessor->setValue('sumber_dana', $item['sumber_dana']);
		$templateProcessor->setValue('tujuan_trx', $item['tujuan_trx']);
		$templateProcessor->setValue('hrg_jual', 'Rp. ' . rupiah($item['hrg_jual']));


		// Ganti simbol '-' dan spasi ganda dengan karakter newline
		$bonus_gimmick = preg_replace('/[-\s]{2,}/', "\n", $item['bonus_gimmick']);

		// Ganti karakter newline dengan tag <w:br/>
		$bonus_gimmick = str_replace("\n", '<w:br/>', $bonus_gimmick);

		// Set nilai yang telah diubah ke dalam template Word
		$templateProcessor->setValue('bonus_gimmick', $bonus_gimmick);

		// $grand_total = $item['book_fee'] + $item['cicilan_per_bulan'] + $item['plafon_kredit'];
		//$templateProcessor->setValue('hrg_jual', 'Rp. ' . rupiah($item['hrg_jual']));




		$templateProcessor->setValue('cara_bayar', $item['cara_bayar']);
		$templateProcessor->setValue('bank_nama', $item['bank_nama']);
		$templateProcessor->setValue('bank_nomor', $item['bank_nomor']);
		$templateProcessor->setValue('bank_pemilik', $item['bank_pemilik']);

		$templateProcessor->setValue('total_kredit', $item['total_kredit']);
		$templateProcessor->setValue('tanggal_akad', $item['tanggal_akad']);
		$templateProcessor->setValue('book_fee', rupiah($item['book_fee']));

		$templateProcessor->setValue('luas_tanah', $item['luas_tanah']);
		$templateProcessor->setValue('luas_bangunan', $item['luas_bangunan']);

		$templateProcessor->setValue('lama_cicilan', $item['lama_cicilan']);
		$templateProcessor->setValue('jumlah_dp', rupiah($item['jumlah_dp']));
		$templateProcessor->setValue('cicilan_per_bulan', rupiah($item['cicilan_per_bulan']));

		//Data Customer
		$templateProcessor->setValue('nama_lengkap', $item['nama_lengkap']);
		$templateProcessor->setValue('no_ktp_customer', $item['no_ktp']);
		$templateProcessor->setValue('jenis_kelamin', $item['jenis_kelamin']);
		$templateProcessor->setValue('tempat_lahir', $item['tempat_lahir']);
		$templateProcessor->setValue('tgl_lahir', $item['tgl_lahir']);
		$templateProcessor->setValue('alamat_customer', $item['alamat']);
		$templateProcessor->setValue('pekerjaan', $item['pekerjaan']);
		$templateProcessor->setValue('no_telp', $item['no_telp']);
		$templateProcessor->setValue('no_npwp', $item['no_npwp']);
		$templateProcessor->setValue('alamat_domisili', $item['alamat_domisili']);
		$templateProcessor->setValue('email', $item['email']);
		$templateProcessor->setValue('warganegara', $item['warganegara']);

		$query2 = "SELECT mr.nama_marketing, mr.no_telp
		FROM transaksi_kavling t 
			LEFT JOIN marketing mr ON t.id_marketing = mr.id_marketing 
			WHERE t.id_pembelian='$id_transaksi'";
		$item2 = $this->db->query($query2)->row_array();

		$templateProcessor->setValue('nama_marketing', $item2['nama_marketing']);
		$templateProcessor->setValue('no_telpon', $item2['no_telp']);



		// $harga_jual = $item['luas_tanah'] * $item['hrg_meter'];
		// $templateProcessor->setValue('harga_jual', rupiah($harga_jual));

		// $templateProcessor->saveAs('ajb/spr_' . $id_transaksi . '.docx');
		$templateProcessor->saveAs('ajb/spr_' . $id_transaksi . '_' . $item['kode_kavling'] . '.docx');
	}


	public function ajax_delete($id)
	{
		//normalkan data kavling
		$transaksi = $this->db->query("SELECT * FROM transaksi_kavling WHERE id_pembelian='$id'")->row_array();
		$idKavling = $transaksi['id_kavling'];
		//normalkan data kavling
		$this->db->query("UPDATE kavling_peta SET status='0', id_customer='0', book_fee='0' WHERE id_kavling = '$idKavling'");
		//Hapus data pembayaran yang terelasi dengan penghapusan transaksi
		$this->db->query("DELETE FROM pembayaran WHERE id_kavling = '$idKavling'");
		$this->db->query("DELETE FROM pembatalan WHERE id_kavling = '$idKavling'");
		$this->db->query("DELETE FROM transaksi_pembatalan WHERE id_kavling = '$idKavling'");
		$this->transaksi->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete_booking($id)
	{
		//normalkan data kavling
		$transaksi = $this->db->query("SELECT * FROM transaksi_booking WHERE id_pembelian='$id'")->row_array();
		$idKavling = $transaksi['id_kavling'];
		//normalkan data kavling
		$this->db->query("UPDATE kavling_peta SET status='0', id_customer='0', book_fee='0' WHERE id_kavling = '$idKavling'");
		//Hapus data pembayaran yang terelasi dengan penghapusan transaksi
		$this->transaksi_booking->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}
}
