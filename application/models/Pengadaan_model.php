<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengadaan_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function getData($table)
    {
    	// $this->db->order_by('id_pengadaan_permintaan_barang', 'DESC');
     //    $this->db->limit($limit, $start);

    	return $this->db->get($table)->result_array();    
    }

    public function getWhere($table,$where)
    {
    	return $this->db->get_where($table,$where)->result_array();
    }

    public function getWhereRow($table,$where)
    {
    	return $this->db->get_where($table,$where)->row_array();
    }

    public function insertData($table,$data)
    {
    	return $this->db->insert($table,$data);
    }

    public function insertDataAnggaran($input)
    {
        $data["id_rekening"]              = $input['txrekening'];
        $data["tahun_anggaran"]           = $input['txjmlanggaran'];
        $data["jumlah_anggaran_semua"]    = $input['txjmlanggaran'];

        $this->db->insert('simrs.pengadaan_anggaran_kendali',$data);
    }

    public function updateData($table,$data,$where)
    {
    	return $this->db->update($table,$data,$where);
    }

    public function deleteData($table,$where)
    {
    	return $this->db->delete($table,$where);
    }

    public function getData2($table,$limit,$start)
    {
    	return $this->db->get($table,$limit,$start)->result_array();    
    }

}