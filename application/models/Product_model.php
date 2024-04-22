<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Product_model  extends CI_Model
{
    function get_all_product()
    {
        $result = $this->db->get('product');
        return $result;
    }
}
