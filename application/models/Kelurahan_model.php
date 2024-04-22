<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kelurahan_model  extends CI_Model
{
    public function fetchKelurahannByKecamatan($idkecamatan)
    {
        return $this->db->get_where('m_kelurahan', ['idkecamatan' => $idkecamatan])->result_array();
    }
}
