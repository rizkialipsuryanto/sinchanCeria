<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Configrs_model  extends CI_Model
{
    public function getById($id = 1)
    {
        if ($id) {
            $this->db->cache_on();
            $this->db->limit(1);
            $data = $this->db->get_where('simrs2012.l_konfigurasi_ws', ['id' => $id])->row_array();
            $this->db->cache_off();
            return $data;
        }
    }
}
