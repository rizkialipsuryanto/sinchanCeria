<?php
defined('BASEPATH') or exit('No direct script access allowed');


use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;


class Sirs_model  extends CI_Model
{
    private $_client;
    private $_header;
    private $_config;
    private $_dataid = BASE_RS_REFF;
    private $_secretKey = BASE_RS_REFF_PASS;
    private $_url = BASE_SIRS_COVID_PRODUCTION;


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
            // 'X-pass' => md5($secretKey),
            'X-pass' => $secretKey,
            'Content-Type' => 'application/json; charset=ISO-8859-1',
            'X-Timestamp' => $xTimestamp
        ];
    }

    public function cek()
    {
        return $this->_header;
    }

    public function Kabupaten()
    {
        $path =   'Referensi/Kabupaten';
        $result = $this->_send("GET", $path);
        return $result;
    }
    public function Patient($nomr = null)
    {
        if ($nomr) {
            //
        } else {
            $this->_header = [
                'X-rs-id' => $this->_dataid,
                'X-pass' => $this->_secretKey,
                'Content-Type' => 'application/json; charset=ISO-8859-1',
                'X-Timestamp' => time(),
                'nomr' => $nomr
            ];
        }
        $path =   'Pasien';
        $result = $this->_send("GET", $path);
        return $result;
    }
    private function _send($method, $path, $payload = null)
    {
        try {
            $config['base_uri'] = $this->_url;
            $config['headers'] = $this->_header;
            // $config['verify'] = false;
            $config['http_errors'] = false;
            $config['timeout'] = 2;

            switch ($method) {
                case "GET":
                    break;
                case "POST":
                    $config['json'] = $payload;
                    break;
                case "DELETE":
                    break;
                case "PUT":
                    break;
                default:
            }

            $response = $this->_client->request($method, $path, $config);
            $result = json_decode($response->getBody()->getContents(), true);
        } catch (\GuzzleHttp\Exception\RequestException  $e) {
            $result["error"] = 1;
            $result["message"] = "Server Kemenkes Bermasalah; Silakan Refresh";
        }

        return $result;
    }
}
