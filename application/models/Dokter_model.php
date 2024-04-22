<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dokter_model  extends CI_Model
{
    public function getProfesiDokter($kdDokter)
    {
        return $this->db->get_where('m_dokter', ['KDDOKTER' => $kdDokter])->row_array();
    }

    public function getDoctorDetailsById($kdDokter)
    {
        return $this->db->get_where('m_dokter', ['KDDOKTER' => $kdDokter])->row_array();
    }

    public function getlistDokter()
    {
        $where = "NAMADOKTER is  NOT NULL AND KDDOKTER != 234 AND KDDOKTER != 249";
        $this->db->where($where);
        $this->db->order_by('st_aktif', 'DESC');
        $this->db->order_by('KDDOKTER', 'ASC');
        return $this->db->get('m_dokter')->result_array();
    }
    
    public function getlistActiveDokter()
    {
        $where = "NAMADOKTER is  NOT NULL";
        $this->db->where($where);
        $this->db->where("st_aktif", 1);
        $this->db->order_by('KDDOKTER', 'ASC');
        return $this->db->get('m_dokter')->result_array();
    }

    public function setActiveDoctor($kode, $state)
    {
        $this->db->set('st_aktif', $state);
        $this->db->where('KDDOKTER', $kode);
        $this->db->update('m_dokter');
        $result = $this->db->affected_rows();
        return $result;
    }
}
