<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mlogin_model  extends CI_Model
{
    public function getListPetugasRM()
    {
        return $this->db->get_where('m_login', ['ROLES' => 1])->result_array();
    }
}
