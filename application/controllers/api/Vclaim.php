<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Vclaim extends CI_Controller
{
    private $_dataid = BASE_DATAID;
    private $_secretKey = BASE_SECRET;
    private $_url = BASE_URL_PRODUCTION;
    
    function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('Vclaim_model', 'vclaim');
    }


    public function detailsKunjungan($norujukan, $faskes)
    {
        $response  = $this->vclaim->DETAILRUJUKAN($norujukan, $faskes);
        echo json_encode($response);
    }

    public function kepesertaan($type, $nokartu)
    {
        $response  = $this->vclaim->detailKepesertaan($type, $nokartu);
        echo json_encode($response);
    }

    public function detailRujukanByNoka($faskes, $nokartu)
    {
        $response  = $this->vclaim->detailrujukanByNoKa($faskes, $nokartu);
        echo json_encode($response);
    }

    public function detailRujukanByNoRujuk($faskes, $noRujukan)
    {
        $response  = $this->vclaim->cariRujukanByNorujukan($faskes, $noRujukan);
        echo json_encode($response);
    }

    public function createSEP($faskes, $norujukan)
    {
        $response  = $this->vclaim->cariRujukanByNorujukan($faskes, $norujukan);
        echo json_encode($response);
    }

    public function findDetailsSuratKontrol($noSuratKontrol)
    {
        date_default_timezone_set('UTC');

        $dataid                 = $this->_dataid;
        $secretKey              = $this->_secretKey;
        $tStamp               = strval(time() - strtotime('1970-01-01 00:00:00'));
        $key = $dataid . $secretKey . $tStamp;

        $responseold  = $this->vclaim->DETAILSURATKONTROL($noSuratKontrol);
        $string1 = $responseold["response"];
        $response = json_decode($this->vclaim->stringDecrypt($key, $string1), true);
        $list = [
            'meta'       =>  $responseold,
            'detail'   =>  $response
        ];
        // return $list;

        echo json_encode($list);
    }
}
