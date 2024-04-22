<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Banner_model  extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function getSliderBanner()
    {
        $data = $this->db->get('m_banners')->result_array();
        return $data;
    }
}
