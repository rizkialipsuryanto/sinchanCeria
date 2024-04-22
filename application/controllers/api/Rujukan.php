<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Rujukan extends CI_Controller
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


    public function findDetails($norujukan, $faskes)
    {
        date_default_timezone_set('UTC');

        $dataid                 = $this->_dataid;
        $secretKey              = $this->_secretKey;
        $tStamp               = strval(time() - strtotime('1970-01-01 00:00:00'));
        $key = $dataid . $secretKey . $tStamp;

        $responseold  = $this->vclaim->DETAILRUJUKAN($norujukan, $faskes);
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
