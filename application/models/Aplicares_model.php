<?php
defined('BASEPATH') or exit('No direct script access allowed');


use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;

class Aplicares_model  extends CI_Model
{
    private $_client;
    private $_header;
    private $_dataid = 1457;
    private $_secretKey = "5uR5F9F782";
    private $_url = "https://new-api.bpjs-kesehatan.go.id/aplicaresws/";
    private $_publicuses = "http://simrs.rsudajibarang/simrs2020/publicuses/";

    public function __construct()
    {
        parent::__construct();
        $this->_client = new Client();

        date_default_timezone_set('UTC');
        $dataid                 = $this->_dataid;
        $secretKey              = $this->_secretKey;

        $tStamp                 = strval(time() - strtotime('1970-01-01 00:00:00'));
        $signature              = hash_hmac('sha256', $dataid . "&" . $tStamp, $secretKey, true);
        $encodedSignature       = base64_encode($signature);
        //$urlencodedSignature    = urlencode($encodedSignature);

        $this->_header = [
            'x-cons-id' => $dataid,
            'x-timestamp' => $tStamp,
            'x-signature' => $encodedSignature,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }

    public function ketersediaankamarrs($kdPPKRS = "1111R010", $start = 1, $limit = 100)
    {
        $method = 'rest/bed/read/' . $kdPPKRS . '/' . $start . '/' . $limit . '';
        $response = $this->_client->request('GET', $method, [
            'base_uri'          => $this->_url,
            'headers'           => $this->_header,
            'verify'            => false,
        ]);
        $result = json_decode($response->getBody()->getContents(), true);
        return json_encode($result);
    }
    public function refkamar()
    {
        $method = 'rest/ref/kelas';
        $response = $this->_client->request('GET', $method, [
            'base_uri'          => $this->_url,
            'headers'           => $this->_header,
            'verify'            => false,
        ]);
        $result = json_decode($response->getBody()->getContents(), true);
        return $result;
    }

    public function createRoom($data)
    {
        // $data  =
        //     [
        //         'kodekelas' => 'ICU',
        //         'koderuang' => '16',
        //         'namaruang' => 'ICU',
        //         'kapasitas' => '7',
        //         'tersedia' => '0',
        //         'tersediapria' => '0',
        //         'tersediawanita' => '0',
        //         'tersediapriawanita' => '0'
        //     ];
        $data  =
            [
                'kodekelas' => $data["kodekelas"],
                'koderuang' => $data["koderuang"],
                'namaruang' => $data["namaruang"],
                'kapasitas' => $data["kapasitas"],
                'tersedia' => $data["tersedia"],
                'tersediapria' => $data["tersediapria"],
                'tersediawanita' => $data["tersediawanita"],
                'tersediapriawanita' => $data["tersediapriawanita"],
            ];

        $method         =   'rest/bed/create/1111R010';
        $response = $this->_client->request('POST', $method, [
            'base_uri'          => $this->_url,
            'headers'           => $this->_header,
            'verify'            => false,
            'json'       => $data,
        ]);
        $result = json_decode($response->getBody()->getContents(), true);
        return $result;
    }

    public function updateBed($data)
    {
        // $data  =
        //     [
        //         'kodekelas' => 'KL1',
        //         'koderuang' => '1',
        //         'namaruang' => 'KEPODANG_ATAS_KLS_1',
        //         'kapasitas' => '4',
        //         'tersedia' => '2',
        //         'tersediapria' => '0',
        //         'tersediawanita' => '0',
        //         'tersediapriawanita' => '0'
        //     ];


        $data  =
            [
                'kodekelas' => $data["kodekelas"],
                'koderuang' => $data["koderuang"],
                'namaruang' => $data["namaruang"],
                'kapasitas' => $data["kapasitas"],
                'tersedia' => $data["tersedia"],
                'tersediapria' => $data["tersediapria"],
                'tersediawanita' => $data["tersediawanita"],
                'tersediapriawanita' => $data["tersediapriawanita"],
            ];
        try {

            $method         =   'rest/bed/update/1111R010';
            $response = $this->_client->request('POST', $method, [
                'base_uri'          => $this->_url,
                'headers'           => $this->_header,
                'verify'            => false,
                'timeout'           => 2,
                'json'       => $data,
            ]);
            $result = json_decode($response->getBody()->getContents(), true);
        } catch (ConnectException  $e) {
            $result = [
                "error" => 1,
                "metaData" => [
                    'code' => null,
                    'messgae' => 'Jaringan Sedang sibuk silakan coba Beberapa saat Lagi'
                ],
                "response" => null
            ];
            return json_decode($result, true);
        } catch (BadResponseException $e) {

            $result = [
                "error" => 1,
                "metaData" => [
                    'code' => null,
                    'messgae' => 'Jaringan Lokal Bermasalah ' . $e->getMessage()
                ],
                "response" => null
            ];
            return json_decode($result, true);
        } catch (Exception $e) {

            $result = [
                "error" => 1,
                "metaData" => [
                    'code' => null,
                    'messgae' => 'gagal mengambildata  ' . $e->getMessage()
                ],
                "response" => null
            ];
            return json_decode($result, true);
        }

        $result["data"] = $data;

        return $result;
    }

    public function deleteRoom()
    {
        $data  =
            [
                'kodekelas' => 'ICU',
                'koderuang' => '16'
            ];


        $method         =   'rest/bed/delete/1111R010';
        $response = $this->_client->request('POST', $method, [
            'base_uri'          => $this->_url,
            'headers'           => $this->_header,
            'verify'            => false,
            'json'       => $data,
        ]);
        $result = json_decode($response->getBody()->getContents(), true);
        return $result;
    }

    public function _sql_new_room()
    {
        $sql  = "SELECT 
        (
            CASE
                WHEN nama = 'INSTALASI GAWAT DARURAT' THEN 'IGD'
                WHEN nama = 'ICU' THEN 'ICU'
                WHEN nama LIKE '%VK%' THEN  'SAL'
                WHEN kelas = 1 && nama != 'INSTALASI GAWAT DARURAT' && nama !=  'ICU'  AND nama NOT LIKE '%VK%'  THEN 'KL1'
                WHEN kelas = 2 && nama != 'INSTALASI GAWAT DARURAT' && nama !=  'ICU'  AND nama NOT LIKE '%VK%' THEN 'KL2'
                WHEN kelas = 3 && nama != 'INSTALASI GAWAT DARURAT' && nama !=  'ICU'  AND nama NOT LIKE '%VK%' THEN 'KL3'
            END
        ) as 'kodekelas',
        /*kelas,*/
        no as 'koderuang',
        nama as 'namaruang',
        jumlah_tt as 'kapasitas',
        sisa_tt as 'tersedia',
        0 as 'tersediapria',
        0 as 'tersediawanita',
        0 as 'tersediapriawanita'

        FROM simrs.m_ruang WHERE nama NOT LIKE '%POLI%' AND nama NOT LIKE '%OPERASI%' AND nama NOT LIKE '%PERINA%' AND nama NOT LIKE '%NURI%'
        ORDER BY kelas ASC";

        return $sql;
    }

    private function _sendRequest($method, $endpoint, $payload = null)
    {
        try {
            if ($method == "GET") {
                $response = $this->_client->request($method, $endpoint, [
                    'base_uri'          => $this->_publicuses,
                    'verify'            => false,
                    'timeout'           => 2,
                ]);
            } else {
                $response = $this->_client->request($method, $endpoint, [
                    'base_uri'          => $this->_url,
                    'verify'            => false,
                    'timeout'           => 2,
                    'json'              => $payload,
                ]);
            }
            $result["metaData"]["code"] =   $response->getStatusCode();
            $result["metaData"]["error"] =   0;
            $result["metaData"]["message"] = $response->getReasonPhrase();
            $result["response"]["posts"] = json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleHttp\Exception\GuzzleException $e) {
            $result["metaData"]["code"] =   $e->getCode();
            $result["metaData"]["error"] =   1;
            $result["metaData"]["message"] =  $e->getMessage();
            $result["response"]["posts"] = null;
        }
        return $result;
    }

    public function iniCobaCoba(){
        print_r("ini coba coba");
        die();
    }
}
