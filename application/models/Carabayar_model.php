<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Carabayar_model  extends CI_Model
{
    public function getListCaraBayar()
    {
        $this->db->where('KODE !=', 1);
        $this->db->order_by('ORDERS', 'ASC');
        return $this->db->get_where('m_carabayar')->result_array();
    }

    public function getCarabayar()
    {
        // $this->db->where('KODE !=', 1);
        // $this->db->order_by('ORDERS', 'ASC');
        $this->db->order_by('KODE', 'ASC');
        return $this->db->get_where('m_carabayar')->result_array();
    }

    public function ParentCaraBayar()
    {
        $carabayar =  [
            ["id" => "1", "carabayar" => "Umum "],
            ["id" => "2", "carabayar" => "Jaminan/Asuransi "]
        ];
        return $carabayar;
    }
    public function jenispasienBPJS()
    {
        $jenispasien =  [
            ["id" => "PBI", "jenis" => "PBI"],
            ["id" => "Non PBI", "jenis" => "Non PBI"]
        ];
        return $jenispasien;
    }


   
}
