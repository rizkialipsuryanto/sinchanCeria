<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Lisserver extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Sqlserver_model', 'sqlserv');
    }

    function koneksi()
    {
        $result =  $this->sqlserv->cek();
        echo json_encode($result, false);
    }
}
