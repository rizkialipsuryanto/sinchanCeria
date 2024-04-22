<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rujukan_model  extends CI_Model
{
    public function getListRujukan()
    {
        return $this->db->get_where('m_rujukan')->result_array();
    }
    public function getListRujukanOnline()
    {
        return $this->db->get_where('m_rujukan',['KODE'=> 5 ])->result_array();
    }
}
