<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tahun_model  extends CI_Model
{


    //public $db2;

    function __construct()
    {
        parent::__construct();
        //$_dbSimrs2 = $this->load->database('simrs', TRUE);
        //load our second db and put in $db2
        //$this->db2 = $this->load->database('simrs', TRUE);
    }



    public function getListTahun($idTahun)
    {
        $this->db->order_by('l_tahun.tahun_id', 'ASC');
        if ($idTahun == null) {
            return $this->db->get('l_tahun')->result_array();
        } else {
            return $this->db->get_where('l_tahun', ['kode' => $idTahun])->result_array();
        }
    }
}
