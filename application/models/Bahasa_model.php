<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bahasa_model  extends CI_Model
{
    public function getListBahasa()
    {
        return $this->db->get_where('m_bahasa_harian')->result_array();
    }
}
