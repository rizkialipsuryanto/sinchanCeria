<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Siryankes extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Sirs_model', 'sirs');
    }


    public function index()
    {
        $this->_getData();
    }

    private function _getData()
    {
        // $model = $this->sirs->Patient();
        // echo json_encode($model);

        $data['title']  =   "Menu Management";

        sendToAdminLTE(1, 'siryankes/outpatient-Patient-Sep-Page-Create', $data);
    }
}
