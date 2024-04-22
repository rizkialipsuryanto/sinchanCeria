<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Phpgrid extends CI_Controller
{


    function __construct()
    {
        parent::__construct();
        //$this->load->library('phpGrid_Lite');
    }


    public function index()
    {
        require_once(APPPATH . 'libraries/phpGrid_Lite/conf.php'); // APPPATH is path to application folder
        $data['phpgrid'] = new C_DataGrid("SELECT * FROM m_pasien", "NOMR", ""); //$this->ci_phpgrid->example_method(3);

        $this->load->view('show_grid', $data);
    }
}
