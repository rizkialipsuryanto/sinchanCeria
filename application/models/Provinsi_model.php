<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Provinsi_model  extends CI_Model
{
    public function getListProvinsi()
    {
        return $this->db->get('m_provinsi')->result_array();
    }
}
