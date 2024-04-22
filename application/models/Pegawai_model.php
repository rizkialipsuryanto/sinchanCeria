<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pegawai_model  extends CI_Model
{


    //public $db2;

    function __construct()
    {
        parent::__construct();
        //$_dbSimrs2 = $this->load->database('simrs', TRUE);
        //load our second db and put in $db2
        //$this->db2 = $this->load->database('simrs', TRUE);
    }



    public function getPegawai()
    {
        $this->db->select('master_login.*');
        $this->db->select('userlevels.userlevelname');
        $this->db->order_by('master_login.userlevelid', 'ASC');
        $this->db->join('simrs.userlevels', 'master_login.userlevelid = userlevels.userlevelid', 'left outer');
        return $this->db->get('simrs.master_login')->result_array();
    }

    public function getPetugasCSSD()
    {
        $this->db->select('master_login.*');
        $this->db->select('userlevels.userlevelname');
        $this->db->order_by('master_login.userlevelid', 'ASC');
        $this->db->where("master_login.userlevelid", "149");
        $this->db->join('simrs.userlevels', 'master_login.userlevelid = userlevels.userlevelid', 'left outer');
        return $this->db->get('simrs.master_login')->result_array();
    }

    public function getPegawaiPerawat()
    {
        $this->db->select('master_login.*');
        $this->db->select('userlevels.userlevelname');
        $this->db->order_by('master_login.userlevelid', 'ASC');
        $this->db->where("master_login.id_profesi", "6");
        $this->db->join('simrs.userlevels', 'master_login.userlevelid = userlevels.userlevelid', 'left outer');
        return $this->db->get('simrs.master_login')->result_array();
    }

    public function getPegawaiById($nono)
    {
        // $this->db->order_by('userlevels.userlevelname', 'ASC');
        // if ($ruang == null) {
        //     return $this->db->get('m_alat_cssd')->result_array();
        // } 
        return $this->db->get_where('simrs.master_login', ['no_identitas' => $nono])->result_array();
    }

    public function getPegawaiByUid($id)
    {
        return $this->db->get_where('simrs.master_login', ['uid' => $id])->row_array();
    }

    // public function fetchTugasByProfesi($profesi)
    // {
    //     return $this->db->get_where('m_alat_cssd', ['jenis_alat' => $jenisalat])->result_array();
        
    // }
}