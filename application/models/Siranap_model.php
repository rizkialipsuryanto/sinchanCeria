<?php
defined('BASEPATH') or exit('No direct script access allowed');


use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;


class Siranap_model  extends CI_Model
{
    private $_client;
    private $_header;
    private $_config;
    private $_dataid = BASE_SIRANP_REFF;
    private $_secretKey = BASE_SIRANP_REFF_PASS;
    private $_url = BASE_SIRANP_PRODUCTION;


    public function __construct()
    {
        parent::__construct();
        $this->_client = new Client();

        date_default_timezone_set('UTC');
        $dataid                 = $this->_dataid;
        $secretKey              = $this->_secretKey;



        $xTimestamp = time();

        $this->_header = [
            'X-rs-id' => $dataid,
            'X-pass' => md5($secretKey),
            'Content-Type' => 'application/json; charset=ISO-8859-1',
            'X-Timestamp' => $xTimestamp
        ];
    }

    public function cek()
    {
        return $this->_header;
    }
}
