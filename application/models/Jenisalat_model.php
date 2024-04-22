<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jenisalat_model  extends CI_Model
{


    //public $db2;

    function __construct()
    {
        parent::__construct();
        //$_dbSimrs2 = $this->load->database('simrs', TRUE);
        //load our second db and put in $db2
        //$this->db2 = $this->load->database('simrs', TRUE);
    }



    public function getJenis()
    {
        $where = "jenis_id != 3";
        $this->db->where($where);
        $this->db->order_by('jenis_id', 'ASC');
        return $this->db->get('l_jenisalat')->result_array();
    }

    public function getJenisFarmasi()
    {
        $this->db->order_by('l_jenisalat.jenis_id', 'ASC');
        return $this->db->get('l_jenisalat')->result_array();
        
    }

    public function getJenisAll()
    {
        $this->db->order_by('l_jenisalat.jenis_id', 'ASC');
        return $this->db->get('l_jenisalat')->result_array();
        
    }

    public function getKondisi()
    {
        $this->db->order_by('l_kondisi.id', 'ASC');
        return $this->db->get('l_kondisi')->result_array();
        
    }

    public function getSatuan()
    {
        $this->db->order_by('l_satuan.id', 'ASC');
        return $this->db->get('l_satuan')->result_array();
        
    }

    public function getInstrumen()
    {
        $this->db->order_by('m_alat_cssd.alat_id', 'ASC');
        return $this->db->get('m_alat_cssd')->result_array();
        
    }

    public function getMesin()
    {
        $this->db->order_by('l_mesin_cssd.id', 'ASC');
        return $this->db->get('l_mesin_cssd')->result_array();
        
    }

    public function fetchAlatByJAandRuang($jenisalat)
    {
        $this->db->order_by('m_alat_cssd.alat_id', 'ASC');
        return $this->db->get_where('m_alat_cssd', ['jenis_alat' => $jenisalat])->result_array();
        
    }

    public function getSet()
    {
        $this->db->order_by('l_cssd_set.set_id', 'ASC');
        return $this->db->get('l_cssd_set')->result_array();
        
    }

    // public function fetchAlatByJAandRuang($jenisalat)
    // {
    //     return $this->db->get_where('m_alat_cssd', ['jenis_alat' => $jenisalat])->result_array();
    // }
}
