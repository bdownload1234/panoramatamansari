<?php

use PhpOffice\PhpSpreadsheet\Style\Borders;

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ajb_model extends CI_Model
{

    public $table = 'ajb';
    public $id = 'id_ajb';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // get all
    function get_all()
    {
        $this->db->join('transaksi_kavling', 'transaksi_kavling.id_pembelian = ajb.id_pembelian');
        $this->db->join('customer', 'customer.id_customer = ajb.id_customer');
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->join('transaksi_kavling', 'transaksi_kavling.id_pembelian = ajb.id_pembelian');
        $this->db->join('customer', 'customer.id_customer = ajb.id_customer');
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }

    // get total rows
    function total_rows($q = NULL)
    {
        $this->db->like('id_ajb', $q);
        $this->db->or_like('id_pembelian', $q);
        $this->db->or_like('id_customer', $q);
        $this->db->or_like('tanggal_ajb', $q);
        $this->db->or_like('notaris', $q);
        $this->db->or_like('keterangan_ajb', $q);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data()
    {
        $this->db->join('transaksi_kavling', 'transaksi_kavling.id_pembelian = ajb.id_pembelian');
        $this->db->join('customer', 'customer.id_customer = ajb.id_customer');
        return $this->db->get($this->table)->result();
    }

    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

    public function filter_by_date($start_date, $end_date)
    {
        $this->db->select('*');
        $this->db->from('ajb');
        $this->db->join('transaksi_kavling', 'transaksi_kavling.id_pembelian = ajb.id_pembelian');
        $this->db->join('customer', 'customer.id_customer = ajb.id_customer');
        $this->db->where('tanggal_ajb >=', $start_date);
        $this->db->where('tanggal_ajb <=', $end_date);
        $query = $this->db->get();
        return $query->result();
    }
}
