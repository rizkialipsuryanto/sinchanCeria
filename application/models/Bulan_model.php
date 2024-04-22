<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bulan_model  extends CI_Model
{


    //public $db2;

    function __construct()
    {
        parent::__construct();
        //$_dbSimrs2 = $this->load->database('simrs', TRUE);
        //load our second db and put in $db2
        //$this->db2 = $this->load->database('simrs', TRUE);
    }



    public function getListBulan($kdBulan)
    {
        $this->db->order_by('l_bulan.bulan_id', 'ASC');
        if ($kdBulan == null) {
            return $this->db->get('l_bulan')->result_array();
        } else {
            return $this->db->get_where('l_bulan', ['kode' => $kdBulan])->result_array();
        }
    }
}
