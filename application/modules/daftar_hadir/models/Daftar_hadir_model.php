<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Daftar_hadir_model extends CI_Model {

	var $table = 'daftar_hadir';
	var $column_order = array('customer.nama_lengkap','customer.alamat','customer.no_telp',null); //set column field database for datatable orderable
	var $column_search = array('customer.nama_lengkap','customer.alamat','customer.no_telp'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('id_hadir' => 'desc'); // default order 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{
		
		$this->db->select('*, daftar_hadir.keterangan as ket, daftar_hadir.no_rekening as norek, daftar_hadir.harga_jual_ajb as hrg_ajb');
		$this->db->from($this->table);
		$this->db->join('kavling_peta', 'kavling_peta.id_kavling = daftar_hadir.lokasi_kavling', 'left');
		$this->db->join('customer', 'customer.id_customer = daftar_hadir.id_customer', 'left');
		$this->db->join('notaris', 'notaris.id_notaris = daftar_hadir.id_notaris', 'left');
		$this->db->join('bank', 'bank.id_bank = daftar_hadir.id_bank', 'left');
		$this->db->order_by('daftar_hadir.tanggal', 'asc');

		$i = 0;
	
		foreach ($this->column_search as $item) // loop column 
		{
			if($_POST['search']['value']) // if datatable send POST for search
			{
				
				if($i===0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}
		
		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables()
	{

		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);

		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	public function get_by_id($id)
	{
	    $this->db->select('daftar_hadir.*, customer.nama_lengkap, notaris.nama_notaris, bank.nama_bank');
		$this->db->from($this->table);
		$this->db->join('customer', 'daftar_hadir.id_customer = customer.id_customer', 'left');
		$this->db->join('notaris', 'daftar_hadir.id_notaris = notaris.id_notaris', 'left');
		$this->db->join('bank', 'daftar_hadir.id_bank = bank.id_bank', 'left');
		$this->db->where('daftar_hadir.id_hadir',$id);
		$query = $this->db->get();

		return $query->row();
	}

	public function save($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function update($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_by_id($id)
	{

		$this->db->where('id_hadir', $id);
		$this->db->update($this->table);
	}

}
