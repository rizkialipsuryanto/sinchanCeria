<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Statuskeluar_model  extends CI_Model
{
    public function getListStatusKeluarRanap()
    {
        return $this->db->get_where('m_statuskeluarranap',['flag_cara_kondisi'=>'1'])->result_array();
    }
}
