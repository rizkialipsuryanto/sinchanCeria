<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kecamatan_model  extends CI_Model
{
    public function fetchKecamatanByKota($idkota)
    {
        return $this->db->get_where('m_kecamatan', ['idkota' => $idkota])->result_array();
    }
}
