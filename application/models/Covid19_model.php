<?php
defined('BASEPATH') or exit('No direct script access allowed');


use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;

class Covid19_model  extends CI_Model
{

    private $_url = "https://covid19.mathdro.id/api/";
    private $_url_indo = "https://api.kawalcorona.com/";

    public function __construct()
    {
        parent::__construct();
        $this->_client = new Client();
    }

    public function listCovidOverCountries()
    {
        try {
            $method         =   'corona/?all=1';
            $response = $this->_client->request('GET', $method, [
                'base_uri'          => $this->_url,
                'verify'            => false,
                'timeout'           => 2,
            ]);
            $result = json_decode($response->getBody()->getContents(), true);
            $data = [
                "error" => 0,
                "message" => 'OK',
                "data" => $result
            ];
            return $data;
        } catch (ConnectException  $e) {
            $error = [
                "error" => 1,
                "data" => null,
                // "message" => 'Koneksi Bermasalah ' . $e->getMessage(),
                "message" => 'Jaringan Sedang sibuk silakan coba Beberapa saat Lagi',
            ];
            return $error;
        } catch (BadResponseException $e) {
            $error = [
                "error" => 1,
                "data" => null,
                "message" => 'Jaringan Lokal Bermasalah ' . $e->getMessage(),
            ];
            return $error;
        } catch (Exception $e) {
            $error = [
                "error" => 1,
                "data" => null,
                "message" => 'gagal mengambildata ' . $e->getMessage(),
            ];
            return $error;
        }
    }

    public function getdetailCovid19ByCountry($country = "Indonesia")
    {
        try {
            $method         =   'corona/?country=' . $country;
            $response = $this->_client->request('GET', $method, [
                'base_uri'          => $this->_url,
                'verify'            => false,
                'timeout'           => 2,
            ]);
            $result = json_decode($response->getBody()->getContents(), true);
            $data = [
                "error" => 0,
                "message" => 'OK',
                "data" => $result
            ];
            return $data;
        } catch (ConnectException  $e) {
            $error = [
                "error" => 1,
                "data" => null,
                // "message" => 'Koneksi Bermasalah ' . $e->getMessage(),
                "message" => 'Jaringan Sedang sibuk silakan coba Beberapa saat Lagi',
            ];
            return $error;
        } catch (BadResponseException $e) {
            $error = [
                "error" => 1,
                "data" => null,
                "message" => 'Jaringan Lokal Bermasalah ' . $e->getMessage(),
            ];
            return $error;
        } catch (Exception $e) {
            $error = [
                "error" => 1,
                "data" => null,
                "message" => 'gagal mengambildata ' . $e->getMessage(),
            ];
            return $error;
        }
    }

    public function getCountryDetails($country = "ID")
    {
        try {
            $method         =   'countries/' . $country;
            $response = $this->_client->request('GET', $method, [
                'base_uri'          => $this->_url,
                'verify'            => false,
                'timeout'           => 2,
            ]);
            $result = json_decode($response->getBody()->getContents(), true);
            $data = [
                "error" => 0,
                "message" => 'OK',
                "data" => $result
            ];
            return $data;
        } catch (ConnectException  $e) {
            $error = [
                "error" => 1,
                "data" => null,
                // "message" => 'Koneksi Bermasalah ' . $e->getMessage(),
                "message" => 'Jaringan Sedang sibuk silakan coba Beberapa saat Lagi',
            ];
            return $error;
        } catch (BadResponseException $e) {
            $error = [
                "error" => 1,
                "data" => null,
                "message" => 'Jaringan Lokal Bermasalah ' . $e->getMessage(),
            ];
            return $error;
        } catch (Exception $e) {
            $error = [
                "error" => 1,
                "data" => null,
                "message" => 'gagal mengambildata ' . $e->getMessage(),
            ];
            return $error;
        }
    }

    public function listCountries()
    {
        try {
            $method         =   'countries';
            $response = $this->_client->request('GET', $method, [
                'base_uri'          => $this->_url,
                'verify'            => false,
                'timeout'           => 2,
            ]);
            $result = json_decode($response->getBody()->getContents(), true);
            $data = [
                "error" => 0,
                "message" => 'OK',
                "data" => $result
            ];
            return $data;
        } catch (ConnectException  $e) {
            $error = [
                "error" => 1,
                "data" => null,
                "message" => 'Jaringan Sedang sibuk silakan coba Beberapa saat Lagi',
            ];
            return $error;
        } catch (BadResponseException $e) {
            $error = [
                "error" => 1,
                "data" => null,
                "message" => 'Jaringan Lokal Bermasalah ' . $e->getMessage(),
            ];
            return $error;
        } catch (Exception $e) {
            $error = [
                "error" => 1,
                "data" => null,
                "message" => 'gagal mengambildata ' . $e->getMessage(),
            ];
            return $error;
        }
    }
    public function totaldunia()
    {
        try {
            $method         =   '';
            $response = $this->_client->request('GET', $method, [
                'base_uri'          => $this->_url,
                'verify'            => false,
                'timeout'           => 2,
            ]);
            $result = json_decode($response->getBody()->getContents(), true);
            $data = [
                "error" => 0,
                "message" => 'OK',
                "data" => $result
            ];
            return $data;
        } catch (ConnectException  $e) {
            $error = [
                "error" => 1,
                "data" => null,
                "message" => 'Jaringan Sedang sibuk silakan coba Beberapa saat Lagi',
            ];
            return $error;
        } catch (BadResponseException $e) {
            $error = [
                "error" => 1,
                "data" => null,
                "message" => 'Jaringan Lokal Bermasalah ' . $e->getMessage(),
            ];
            return $error;
        } catch (Exception $e) {
            $error = [
                "error" => 1,
                "data" => null,
                "message" => 'gagal mengambildata ' . $e->getMessage(),
            ];
            return $error;
        }
    }


    public function listSebaranCovidIndonesiaByProvinsi()
    {
        try {
            $method         =   'indonesia/provinsi/';
            $response = $this->_client->request('GET', $method, [
                'base_uri'          => $this->_url_indo,
                'verify'            => false,
                'timeout'           => 5,
            ]);
            $result = json_decode($response->getBody()->getContents(), true);
            $data = [
                "error" => 0,
                "message" => 'OK',
                "data" => $result
            ];
            return $data;
        } catch (ConnectException  $e) {
            $error = [
                "error" => 1,
                "data" => null,
                "message" => 'Jaringan Sedang sibuk silakan coba Beberapa saat Lagi',
            ];
            return $error;
        } catch (BadResponseException $e) {
            $error = [
                "error" => 1,
                "data" => null,
                "message" => 'Jaringan Lokal Bermasalah ' . $e->getMessage(),
            ];
            return $error;
        } catch (Exception $e) {
            $error = [
                "error" => 1,
                "data" => null,
                "message" => 'gagal mengambildata ' . $e->getMessage(),
            ];
            return $error;
        }
    }

    public function totaldetailIndonesia()
    {
        try {
            $method         =   'indonesia/';
            $response = $this->_client->request('GET', $method, [
                'base_uri'          => $this->_url_indo,
                'verify'            => false,
                'timeout'           => 2,
            ]);
            $result = json_decode($response->getBody()->getContents(), true);
            $data = [
                "error" => 0,
                "message" => 'OK',
                "data" => $result
            ];
            return $data;
        } catch (ConnectException  $e) {
            $error = [
                "error" => 1,
                "data" => null,
                "message" => 'Jaringan Sedang sibuk silakan coba Beberapa saat Lagi',
            ];
            return $error;
        } catch (BadResponseException $e) {
            $error = [
                "error" => 1,
                "data" => null,
                "message" => 'Jaringan Lokal Bermasalah ' . $e->getMessage(),
            ];
            return $error;
        } catch (Exception $e) {
            $error = [
                "error" => 1,
                "data" => null,
                "message" => 'gagal mengambildata ' . $e->getMessage(),
            ];
            return $error;
        }
    }
}
