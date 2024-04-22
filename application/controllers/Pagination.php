<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pagination extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('product_model');
        $this->ci_minifier->set_domparser(2);
        $this->ci_minifier->init(1);
        $this->ci_minifier->enable_obfuscator(3);
    }

    function index()
    {
        $this->load->library('pagination');
        $config['base_url'] = base_url('pagination/index');
        $config['total_rows'] = 200;
        $config['per_page'] = 20;
        $this->pagination->initialize($config);
        echo $this->pagination->create_links();
    }
}
