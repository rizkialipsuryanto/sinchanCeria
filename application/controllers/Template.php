<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Template extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        // $this->load->library('database');
        $this->load->library('parser');
        // $this->ci_minifier->set_domparser(2);
        // $this->ci_minifier->init(1);
        // $this->ci_minifier->enable_obfuscator(3);
    }

    function index()
    {
        $template = '<ul>{menuitems}
                            <li><a href="{link}">{title}</a></li>
                    {/menuitems}</ul>';

        $data = array(
            'menuitems' => array(
                array('title' => 'First Link', 'link' => '/rekammedis'),
                array('title' => 'Second Link', 'link' => '/pasien'),
            )
        );
        $this->parser->parse_string($template, $data);
    }
}
