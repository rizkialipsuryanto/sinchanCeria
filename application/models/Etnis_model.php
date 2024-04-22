<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Etnis_model  extends CI_Model
{
    public function getListEtnis()
    {
        return $this->db->get_where('m_etnis')->result_array();
    }
}
