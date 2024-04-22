<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ruang_model  extends CI_Model
{
    public function getList()
    {
        return $this->db->get_where('m_ruang')->result_array();
    }
    public function getRuangDetails($kdRuang)
    {
        // $this->db->select('m_detail_tempat_tidur.id');
        $this->db->select('m_detail_tempat_tidur.no_tt');
        return $this->db->get_where('m_detail_tempat_tidur', ['idxruang' => $kdRuang])->result_array();
    }
}
