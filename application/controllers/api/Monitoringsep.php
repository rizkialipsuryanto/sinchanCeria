<?php

use function GuzzleHttp\json_encode;

defined('BASEPATH') or exit('No direct script access allowed');

class Monitoringsep extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_logged_in();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('Vclaim_model', 'vclaim');
        $this->load->helper('pendaftaran');
    }

    function index($jenisrawat = null, $tgl = null)
    {

        if ($jenisrawat) {
            $jnsPelayanan = $jenisrawat;
        } else {
            $jnsPelayanan = 2;
        }

        if ($tgl) {
            $tanggal = $tgl;
        } else {
            $tanggal = date("Y-m-d");
        }


        $result = $this->vclaim->dataKunjunganPasienBPJS($tanggal, $jnsPelayanan);

        echo json_encode($result);
    }
}
