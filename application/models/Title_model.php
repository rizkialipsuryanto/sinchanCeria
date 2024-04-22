<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Title_model  extends CI_Model
{
    public function getListTitle()
    {
        return $this->db->get_where('l_titel')->result_array();
    }
}
