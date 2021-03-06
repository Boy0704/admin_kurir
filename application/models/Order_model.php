<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Order_model extends CI_Model
{

    public $table = 'order';
    public $id = 'id_order';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // get all
    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }
    
    // get total rows
    function total_rows($q = NULL) {
        $this->db->like('id_order', $q);
	$this->db->or_like('customer', $q);
	$this->db->or_like('driver', $q);
	$this->db->or_like('origin', $q);
	$this->db->or_like('destination', $q);
	$this->db->or_like('alamat_origin', $q);
	$this->db->or_like('alamat_destination', $q);
	$this->db->or_like('jarak', $q);
	$this->db->or_like('harga', $q);
	$this->db->or_like('catatan', $q);
	$this->db->or_like('telp_penerima', $q);
	$this->db->or_like('telp_pengirim', $q);
	$this->db->or_like('nama_penerima', $q);
	$this->db->or_like('nama_pengirim', $q);
	$this->db->or_like('status', $q);
	$this->db->or_like('id_jenis', $q);
	$this->db->or_like('date_at', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id_order', $q);
	$this->db->or_like('customer', $q);
	$this->db->or_like('driver', $q);
	$this->db->or_like('origin', $q);
	$this->db->or_like('destination', $q);
	$this->db->or_like('alamat_origin', $q);
	$this->db->or_like('alamat_destination', $q);
	$this->db->or_like('jarak', $q);
	$this->db->or_like('harga', $q);
	$this->db->or_like('catatan', $q);
	$this->db->or_like('telp_penerima', $q);
	$this->db->or_like('telp_pengirim', $q);
	$this->db->or_like('nama_penerima', $q);
	$this->db->or_like('nama_pengirim', $q);
	$this->db->or_like('status', $q);
	$this->db->or_like('id_jenis', $q);
	$this->db->or_like('date_at', $q);
	$this->db->limit($limit, $start);
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

}

/* End of file Order_model.php */
/* Location: ./application/models/Order_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2020-09-03 08:58:44 */
/* http://harviacode.com */