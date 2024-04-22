<?php
defined('BASEPATH') or exit('No direct script access allowed');


use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use LZCompressor\LZString as LZString;

require_once 'vendor/autoload.php';


class Vclaim_model  extends CI_Model
{
    private $_client;
    private $_header;
    private $_config;
    private $_dataid = BASE_DATAID;
    private $_secretKey = BASE_SECRET;
    private $_url = BASE_URL_PRODUCTION;



    public function __construct()
    {
        parent::__construct();
        $this->_client = new Client();

        date_default_timezone_set('UTC');
        $dataid                 = $this->_dataid;
        $secretKey              = $this->_secretKey;
        $userkey                = '7c7cf9f837e73e288da30be08eeeb49f';

        // $userkey                = '6da8e3a91732bf3b11827c091ac1b5f3';

        $tStamp                 = strval(time() - strtotime('1970-01-01 00:00:00'));
        $signature              = hash_hmac('sha256', $dataid . "&" . $tStamp, $secretKey, true);
        $encodedSignature       = base64_encode($signature);

        $this->_header = [
            'x-cons-id' => $dataid,
            'x-timestamp' => $tStamp,
            'x-signature' => $encodedSignature,
            'user_key' => $userkey,
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Accept' => 'application/json',
        ];
    }

    public function stringDecrypt($key, $string){
        $encrypt_method = 'AES-256-CBC';
        // hash
        $key_hash = hex2bin(hash('sha256', $key));
        $iv = substr(hex2bin(hash('sha256', $key)), 0, 16);
        $outputcoba = openssl_decrypt(base64_decode($string), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);
        $output = LZString::decompressFromEncodedURIComponent($outputcoba);
        return $output;
    }

    public function detailKepesertaan($type, $noKartu)
    {
        if (!$type || !$noKartu) {
            return null;
        }

        if ($type == 1) {
            $method         =   'Peserta/nik/' . $noKartu . '/tglSEP/' . date("Y-m-d") . '';
        } else {
            $method         =   'Peserta/nokartu/' . $noKartu . '/tglSEP/' . date("Y-m-d") . '';
        }

        try {
            $response = $this->_client->request('GET', $method, [
                'base_uri'          => $this->_url,
                'headers'           => $this->_header,
                'verify'            => false,
                'timeout'           => 10
            ]);
            $result = json_decode($response->getBody()->getContents(), true);
            // print_r($result);
        } catch (ConnectException  $e) {
            $response_temp = [
                "error" => 1,
                "metaData" => [
                    'code' => null,
                    'message' => 'Jaringan Sedang sibuk silakan coba Beberapa saat Lagi'
                ],
                "response" => null
            ];
            $result =  json_decode($response_temp, true);
        } catch (BadResponseException $e) {

            $response_temp = [
                "error" => 1,
                "metaData" => [
                    'code' => null,
                    'message' => 'Jaringan BPJS Bermasalah ' . $e->getMessage()
                ],
                "response" => null
            ];
            $result =  json_decode($response_temp, true);
        } catch (Exception $e) {

            $response_temp = [
                "error" => 1,
                "metaData" => [
                    'code' => null,
                    'message' => 'gagal mengambildata  ' . $e->getMessage()
                ],
                "response" => null
            ];
            $result =  json_decode($response_temp, true);
        }
        // print_r($result);
        return $result;
    }


    public function newSEP($data)
    {
        $method         =   'SEP/1.1/insert';
        $response = $this->_client->request('POST', $method, [
            'base_uri'          => $this->_url,
            'headers'           => $this->_header,
            'verify'            => false,
            'json'       => $data,
        ]);
        $result = json_decode($response->getBody()->getContents(), true);
        return $result;
    }

    public function detailSEP($noSEP)
    {
        $method = 'SEP/' . $noSEP;
        $response = $this->_client->request('GET', $method, [
            'base_uri'          => $this->_url,
            'headers'           => $this->_header,
            'verify'            => false,
        ]);
        $result = json_decode($response->getBody()->getContents(), true);
        return $result;
    }

    public function cariSuratKontrol($nosurat)
    {
        $method         =   'RencanaKontrol/noSuratKontrol/' . $nosurat . '';

        $response = $this->_client->request('GET', $method, [
            'base_uri'          => $this->_url,
            'headers'           => $this->_header,
            'timeout'           => 10,
            'verify'            => false,
        ]);
        $result = json_decode($response->getBody()->getContents(), true);
        return $result;
    }

    public function cariRujukanByNorujukan($faskes, $norujukan)
    {
        if (!$faskes || !$norujukan) {
            return null;
        }
        if ($faskes == 1) {
            //KTP
            $method         =   'Rujukan/' . $norujukan . '';
        } else {
            //NO kartu BPJS
            $method         =   'Rujukan/RS/' . $norujukan . '';
        }

        try {

            $response = $this->_client->request('GET', $method, [
                'base_uri'          => $this->_url,
                'headers'           => $this->_header,
                'verify'            => false,
            ]);

            $result = json_decode($response->getBody()->getContents(), true);
            //
        } catch (ConnectException  $e) {
            $response_temp = [
                "error" => 1,
                "metaData" => [
                    'code' => null,
                    'message' => 'Jaringan Sedang sibuk silakan coba Beberapa saat Lagi'
                ],
                "response" => null
            ];
            $result =  json_decode($response_temp, true);
            //
        } catch (BadResponseException $e) {

            $response_temp = [
                "error" => 1,
                "metaData" => [
                    'code' => null,
                    'message' => 'Jaringan Lokal Bermasalah ' . $e->getMessage()
                ],
                "response" => null
            ];
            $result =  json_decode($response_temp, true);
            //
        } catch (Exception $e) {

            $response_temp = [
                "error" => 1,
                "metaData" => [
                    'code' => null,
                    'message' => 'gagal mengambildata  ' . $e->getMessage()
                ],
                "response" => null
                //
            ];
            $result =  json_decode($response_temp, true);
        }

        return $result;
    }


    public function listRujukanByNoka($faskes, $noka)
    {
        if (!$faskes || !$noka) {
            return null;
        }
        if ($faskes == 1) {
            //KTP
            $method         =   'Rujukan/List/Peserta/' . $noka . '';
        } else {
            //NO kartu BPJS
            $method         =   'Rujukan/RS/List/Peserta/' . $noka . '';
        }

        $response = $this->_client->request('GET', $method, [
            'base_uri'          => $this->_url,
            'headers'           => $this->_header,
            'timeout'           => 10,
            'verify'            => false,
        ]);
        $result = json_decode($response->getBody()->getContents(), true);
        return $result;
    }

    public function detailrujukanByNoKa($faskes, $noka)
    {
        if ($faskes == 1) {
            //KTP
            $method         =   'Rujukan/Peserta/' . $noka . '';
        } else {
            //NO kartu BPJS
            $method         =   'Rujukan/RS/Peserta/' . $noka . '';
        }

        $response = $this->_client->request('GET', $method, [
            'base_uri'          => $this->_url,
            'headers'           => $this->_header,
            'verify'            => false,
        ]);
        $result = json_decode($response->getBody()->getContents(), true);
        return $result;
    }


    public function historyPelayananPeserta($noKa, $tglMulai, $tglAkhir)
    {
        $method         =   'monitoring/HistoriPelayanan/NoKartu/' . $noKa . '/tglAwal/' . $tglMulai . '/tglAkhir/' . $tglAkhir . '';
        $response = $this->_client->request('GET', $method, [
            'base_uri'          => $this->_url,
            'headers'           => $this->_header,
            'verify'            => false,
        ]);
        $result = json_decode($response->getBody()->getContents(), true);
        return $result;
    }

    public function ListRencanaKontrol($bulan, $tahun, $nokaBPJS)
    {
        $method         =   'RencanaKontrol/ListRencanaKontrol/Bulan/' . $bulan . '/Tahun/' . $tahun . '/Nokartu/' . $nokaBPJS . '/filter/2';
        $response = $this->_client->request('GET', $method, [
            'base_uri'          => $this->_url,
            'headers'           => $this->_header,
            'verify'            => false,
        ]);
        $result = json_decode($response->getBody()->getContents(), true);
        return $result;
    }


    public function searchDiagnosa($keyword)
    {
        $method         =   'referensi/diagnosa/' . $keyword . '';
        $response = $this->_client->request('GET', $method, [
            'base_uri'          => $this->_url,
            'headers'           => $this->_header,
            'verify'            => false,
        ]);
        $result = json_decode($response->getBody()->getContents(), true);
        return $result;
    }


    public function searchPoli($keyword)
    {
        $method         =   'referensi/poli/' . $keyword . '';
        $response = $this->_client->request('GET', $method, [
            'base_uri'          => $this->_url,
            'headers'           => $this->_header,
            'verify'            => false,
        ]);
        $result = json_decode($response->getBody()->getContents(), true);
        return $result;
    }

    public function searchDPJP($jenispelayanan = 1, $tanggal, $spesialisasi)
    {
        $method         =   'referensi/dokter/pelayanan/' . $jenispelayanan . '/tglPelayanan/' . $tanggal . '/Spesialis/' . $spesialisasi . '';
        $response = $this->_client->request('GET', $method, [
            'base_uri'          => $this->_url,
            'headers'           => $this->_header,
            'verify'            => false,
        ]);
        $result = json_decode($response->getBody()->getContents(), true);
        return $result;
    }


    public function asalfaskesrujukan($id = null)
    {

        if ($id == 1) {
            $faskes =  [
                ["id" => "2", "faskes" => "Faskes Tingkat 2 (RUMAH SAKIT)"]
            ];
        } else {
            $faskes =  [
                ["id" => "1", "faskes" => "Faskes Tingkat 1 (PCARE/PUSKESMAS/DR KELUARGA)"],
                ["id" => "2", "faskes" => "Faskes Tingkat 2 (RUMAH SAKIT)"]
            ];
        }

        return $faskes;
    }
    public function statuskecelakaan()
    {
        $statuskecelakaan =  [
            ["id" => "0", "status" => "Bukan Kecelakaan lalu lintas [BKLL]"],
            ["id" => "1", "status" => "Kecelakaan Lalu Lintas dan Bukan Kecelakaan Kerja [BKK]"],
            ["id" => "2", "status" => "Kecelakaan Lalu Lintas dan Kecelakaan Kerja"],
            ["id" => "3", "status" => "Kecelakaan Kerja"]
        ];
        return $statuskecelakaan;
    }

    public function pembiayaan()
    {
        $pembiayaan =  [
            ["id" => "1", "pembiayaan" => "Pribadi"],
            ["id" => "2", "pembiayaan" => "Pemberi Kerja"],
            ["id" => "3", "pembiayaan" => "Asuransi Kesehatan Tambahan"]
        ];
        return $pembiayaan;
    }

    private function _listSuratKontrolByNoka($noka)
    {
        $year = date('Y');
        $month = date('m');
        $method         =   'RencanaKontrol/ListRencanaKontrol/Bulan/' . $month . '/Tahun/' . $year . '/Nokartu/' . $noka . '/filter/2';
        $response = $this->_client->request('GET', $method, [
            'base_uri'          => $this->_url,
            'headers'           => $this->_header,
            'verify'            => false,
        ]);
        $result = json_decode($response->getBody()->getContents(), true);
        return $result;
    }

    private function _listRujukanPcareByNoka($noka)
    {
        $method         =   'Rujukan/List/Peserta/' . $noka . '';
        $response = $this->_client->request('GET', $method, [
            'base_uri'          => $this->_url,
            'headers'           => $this->_header,
            'verify'            => false,
        ]);
        $result = json_decode($response->getBody()->getContents(), true);
        return $result;
    }

    private function _listRujukanRSByNoka($noka)
    {
        $method         =   'Rujukan/RS/List/Peserta/' . $noka . '';
        $response = $this->_client->request('GET', $method, [
            'base_uri'          => $this->_url,
            'headers'           => $this->_header,
            'verify'            => false,
        ]);
        $result = json_decode($response->getBody()->getContents(), true);
        return $result;
    }

    public function getAllRujukanBynoka($noka)
    {
        date_default_timezone_set('UTC');

        $dataid                 = $this->_dataid;
        $secretKey              = $this->_secretKey;
        $tStamp               = strval(time() - strtotime('1970-01-01 00:00:00'));
        $key = $dataid . $secretKey . $tStamp;


        $data["pcare"]        = $this->_listRujukanPcareByNoka($noka);
        $stringPcare        = $data["pcare"]["response"];
        $pcare = json_decode($this->vclaim->stringDecrypt($key, $stringPcare), true);

        $data["rs"]        = $this->_listRujukanRSByNoka($noka);
        $stringRS        = $data["rs"]["response"];
        $rs = json_decode($this->vclaim->stringDecrypt($key, $stringRS), true);

        $data["peserta"]        = $this->detailKepesertaan(2, $noka);
        $stringPeserta        = $data["peserta"]["response"];
        $peserta = json_decode($this->vclaim->stringDecrypt($key, $stringPeserta), true);

        $data["lastpcare"]        = $this->detailrujukanByNoKa(1, $noka);
        $stringlastpcare        = $data["lastpcare"]["response"];
        $lastpcare = json_decode($this->vclaim->stringDecrypt($key, $stringlastpcare), true);

        $data["lastrs"]        = $this->detailrujukanByNoKa(2, $noka);
        $stringlastrs        = $data["lastrs"]["response"];
        $lastrs = json_decode($this->vclaim->stringDecrypt($key, $stringlastrs), true);

        $list = [
            'peserta'       =>  $peserta,
            'pesertaMeta'   =>  $data["peserta"],
            'pcare'         =>  $pcare,
            'pcareMeta'   =>  $data["pcare"],
            'lastpcare'     =>  $lastpcare,
            'lastpcareMeta'   =>  $data["lastpcare"],
            'rs'            => $rs,
            'rsMeta'   =>  $data["rs"],
            'lastrs'        => $lastrs,
            'lastrsMeta'   =>  $data["lastrs"]
        ];
        return $list;
    }

    public function getAllSuratKontrolBynoka($noka)
    {
        date_default_timezone_set('UTC');

        $dataid                 = $this->_dataid;
        $secretKey              = $this->_secretKey;
        $tStamp               = strval(time() - strtotime('1970-01-01 00:00:00'));
        $key = $dataid . $secretKey . $tStamp;


        $data["suratkontrol"]        = $this->_listSuratKontrolBynoka($noka);
        $stringSuratKontrol        = $data["suratkontrol"]["response"];
        $suratkontrol = json_decode($this->vclaim->stringDecrypt($key, $stringSuratKontrol), true);

        $list = [
            'suratkontrol'       =>  $suratkontrol,
            'suratkontrolaMeta'   =>  $data["suratkontrol"]
        ];
        return $list;
    }

    public function newPengajuanSEP($data)
    {
        $method         =   'Sep/pengajuanSEP';
        $response = $this->_client->request('POST', $method, [
            'base_uri'          => $this->_url,
            'headers'           => $this->_header,
            'verify'            => false,
            'json'       => $data,
        ]);
        $result = json_decode($response->getBody()->getContents(), true);
        return $result;
    }


    public function approvalSEP($data)
    {
        $method         =   'Sep/aprovalSEP';
        $response = $this->_client->request('POST', $method, [
            'base_uri'          => $this->_url,
            'headers'           => $this->_header,
            'verify'            => false,
            'json'       => $data,
        ]);
        $result = json_decode($response->getBody()->getContents(), true);
        return $result;
    }


    public function updateTanggalPulangSEP($data)
    {
        $method         =   'Sep/updtglplg';
        $response = $this->_client->request('PUT', $method, [
            'base_uri'          => $this->_url,
            'headers'           => $this->_header,
            'verify'            => false,
            'json'       => $data,
        ]);
        $result = json_decode($response->getBody()->getContents(), true);
        return $result;
    }

    public function dataKunjunganPasienBPJS($tanggalSEP, $JnsPelayanan)
    {
        $method         =   'Monitoring/Kunjungan/Tanggal/' . $tanggalSEP . '/JnsPelayanan/' . $JnsPelayanan . '';
        $response = $this->_client->request('GET', $method, [
            'base_uri'          => $this->_url,
            'headers'           => $this->_header,
            'verify'            => false
        ]);
        $result = json_decode($response->getBody()->getContents(), true);
        return $result;
    }



    public function DIAGNOSA($keyword)
    {
        $path = 'referensi/diagnosa/' . $keyword . '';
        $result = $this->_send("GET", $path);
        return $result;
    }


    public function DPJP_POLI($jenispelayanan = 1, $tanggal, $spesialisasi)
    {
        $path = 'referensi/dokter/pelayanan/' . $jenispelayanan . '/tglPelayanan/' . $tanggal . '/Spesialis/' . $spesialisasi . '';
        $result = $this->_send("GET", $path);
        return $result;
    }



    public function UPTDPULANG($data)
    {
        $path = 'SEP/2.0/updtglplg';
        $result = $this->_send("PUT", $path, $data);
        return $result;
    }


    public function DETAILRUJUKAN($noRujukan, $faskes)
    {

        if ($faskes == 1) {
            $path = 'Rujukan/' . $noRujukan . '';
        } else {
            $path = 'Rujukan/RS/' . $noRujukan . '';
        }
        $result = $this->_send("GET", $path);
        return $result;
    }

    public function DETAILSURATKONTROL($noSuratKontrol)
    {
        $path = 'RencanaKontrol/noSuratKontrol/' . $noSuratKontrol . '';
        
        $result = $this->_send("GET", $path);
        return $result;
    }


    public function DOKTER($jenispelayanan = 1, $tanggal = null, $spesialisasi = null)
    {

        $path = 'referensi/dokter/pelayanan/' . $jenispelayanan . '/tglPelayanan/' . $tanggal . '/Spesialis/' . $spesialisasi . '';
        $result = $this->_send("GET", $path);
        return $result;
    }

    public function newCreateSEP($data)
    {
        $path =   'SEP/2.0/insert';
        $result = $this->_send("POST", $path, $data);
        return $result;
    }

    public function newDeleteSEP($data)
    {
        $path =   'SEP/2.0/delete';
        $result = $this->_send("DELETE", $path, $data);
        return $result;
    }

    public function newCreateSuratKontrol($data)
    {
        $path =   'RencanaKontrol/insert';
        $result = $this->_send("POST", $path, $data);
        return $result;
    }

    public function updateSuratKontrol($data)
    {
        $path =   'RencanaKontrol/Update';
        $result = $this->_send("PUT", $path, $data);
        return $result;
    }

    public function SPRI($data)
    {
        $path =   'RencanaKontrol/InsertSPRI';
        $result = $this->_send("POST", $path, $data);
        return $result;
    }

    public function updateSpri($data)
    {
        $path =   'RencanaKontrol/UpdateSPRI';
        $result = $this->_send("PUT", $path, $data);
        return $result;
    }

    public function findSEPBYnoSEP($noSEP)
    {
        $path =   'SEP/' . $noSEP;
        $result = $this->_send("GET", $path);
        return $result;
    }

    public function historyPelayanan($noKa, $tglMulai, $tglAkhir)
    {
        $path =   'monitoring/HistoriPelayanan/NoKartu/' . $noKa . '/tglAwal/' . $tglMulai . '/tglAkhir/' . $tglAkhir . '';
        $result = $this->_send("GET", $path);
        return $result;
    }


    public function Kunjungan($tanggalSEP, $JnsPelayanan)
    {
        $path =   'Monitoring/Kunjungan/Tanggal/' . $tanggalSEP . '/JnsPelayanan/' . $JnsPelayanan . '';
        $result = $this->_send("GET", $path);
        return $result;
    }

    public function decompress($string)
    {
        $result = LZString::decompressFromEncodedURIComponent($string);
        return $result;
    }


    public function kepesertaan($type, $noKartu)
    {
        if (!$type || !$noKartu) {
            return null;
        }

        if ($type == 1) {
            $path         =   'Peserta/nik/' . $noKartu . '/tglSEP/' . date("Y-m-d") . '';
        } else {
            $path         =   'Peserta/nokartu/' . $noKartu . '/tglSEP/' . date("Y-m-d") . '';
        }

        $result = $this->_send("GET", $path);
        return $result;
    }

    public function _toFormatSuratKontrol($data)
    {
        date_default_timezone_set('UTC');

        $dataid                 = $this->_dataid;
        $secretKey              = $this->_secretKey;
        $tStamp               = strval(time() - strtotime('1970-01-01 00:00:00'));
        $key = $dataid . $secretKey . $tStamp;

        $payload  =
            [
                'request' => [
                            'noSEP'   => trim($this->input->post("tx_sep")),
                            'kodeDokter'  => $this->input->post("cb_dokterdpjp"),
                            'poliKontrol'  => $this->input->post("cb_polikontrol"),
                            'tglRencanaKontrol'  => $this->input->post("dtp_tanggal"),
                            'user'   =>   'RSUD AJIBARANG'
                                        // $data["user"]["firstname"] . ' ' .  $data["user"]["lastname"]
                    ]
            ];
        return $payload;
    }

    public function _toFormatSuratKontrolUpdate($data)
    {
        date_default_timezone_set('UTC');
        
        $dataid                 = $this->_dataid;
        $secretKey              = $this->_secretKey;
        $tStamp               = strval(time() - strtotime('1970-01-01 00:00:00'));
        $key = $dataid . $secretKey . $tStamp;

        $payload  =
            [
                'request' => [
                            'noSuratKontrol'   => $this->input->post("tx_nosurat"),
                            'noSEP'   => trim($this->input->post("tx_sep")),
                            'kodeDokter'  => $this->input->post("cb_dokterdpjp"),
                            'poliKontrol'  => $this->input->post("cb_polikontrol"),
                            'tglRencanaKontrol'  => $this->input->post("dtp_tanggal"),
                            'user'   =>'RSUD AJIBARANG'
                                        // $data["user"]["firstname"] . ' ' .  $data["user"]["lastname"]
                    ]
            ];
        return $payload;
    }

    public function _toFormatSpri($data)
    {
        $dataid                 = $this->_dataid;
        $secretKey              = $this->_secretKey;
        $tStamp               = strval(time() - strtotime('1970-01-01 00:00:00'));
        $key = $dataid . $secretKey . $tStamp;

        $payload  =
            [
                'request' => [
                            'noKartu'   => trim($this->input->post("tx_nokartu")),
                            'kodeDokter'  => $this->input->post("cb_dokterdpjp"),
                            'poliKontrol'  => $this->input->post("cb_polikontrol"),
                            'tglRencanaKontrol'  => $this->input->post("dtp_tanggal"),
                            'user'   =>   'RSUD AJIBARANG'
                                        // $data["user"]["firstname"] . ' ' .  $data["user"]["lastname"]
                    ]
            ];
        return $payload;
    }

    public function _toFormatSpriUpdate($data)
    {
        $dataid                 = $this->_dataid;
        $secretKey              = $this->_secretKey;
        $tStamp               = strval(time() - strtotime('1970-01-01 00:00:00'));
        $key = $dataid . $secretKey . $tStamp;

        $payload  =
            [
                'request' => [
                            'noSPRI'   => $this->input->post("tx_nosurat"),
                            'kodeDokter'  => $this->input->post("cb_dokterdpjp"),
                            'poliKontrol'  => $this->input->post("cb_polikontrol"),
                            'tglRencanaKontrol'  => $this->input->post("dtp_tanggal"),
                            'user'   =>'RSUD AJIBARANG'
                                        // $data["user"]["firstname"] . ' ' .  $data["user"]["lastname"]
                    ]
            ];
        return $payload;
    }

    public function _toFormatTes($data)
    {
        $dataid                 = $this->_dataid;
        $secretKey              = $this->_secretKey;
        $tStamp               = strval(time() - strtotime('1970-01-01 00:00:00'));
        $key = $dataid . $secretKey . $tStamp;

        $user           =   $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $eksekutif      =   $data["chkpoliesekutif"] ? $data["chkpoliesekutif"] : "0";
        


        if ($data["jnsPelayanan"] == 1) {
            $nosurat = $data["txtnospri"];
        } else {
            $nosurat = $data["txtnoSurat"];
        }

            $DPJPLAYAN = $data['tx_kddpjplay'];

        if ($data["cb_statuspoli"] == "YA") {
            if ($data["cb_tujuankunj"] == 0) {
                $assesmentpelayanan = "";
                $flagprocedure = "";
                $penunjang = "";
                $tujuankunjungan = "0";
            }
            else if ($data["cb_tujuankunj"] == 1) {
                $tujuankunjungan = "1";
                $assesmentpelayanan = "";
                $flagprocedure = $data['cb_flagProcedure'];
                $penunjang = $data['cb_kdPenunjang'];
            }
            else if ($data["cb_tujuankunj"] == 2) {
                $tujuankunjungan = "2";
                $assesmentpelayanan = $data['cb_assesmentPel'];
                $flagprocedure = "";
                $penunjang = "";
            }
        }

        else {
            $flagprocedure = "";
            $penunjang = "";
            $assesmentpelayanan = $data['cb_assesmentPel'];
            $tujuankunjungan = "0";
        }

        if ($data["cb_asalrujukan"] == "2" && $data["ppkRujukan"] == "") {
            $ppkRujukan =  "1111R010";
        }
        else
        {
            $ppkRujukan =  $data["ppkRujukan"];
        }
        $tujuankunjungan_ = $tujuankunjungan;
        $assesmentpelayanan_ = $assesmentpelayanan;
        $flagprocedure_ = $flagprocedure;
        $penunjang_ = $penunjang;

        $cob        = $data["chkCOB"] ?  $data["chkCOB"] : "0";
        $katarak    = $data["chkkatarak"] ?   $data["chkkatarak"] : "0";
        $politujuan = isset($data['politujuan']) ? $data['politujuan'] : "";
        // $ppkRujukan = isset($data["ppkRujukan"]) ? $data["ppkRujukan"] : "1111R010";
        $payload  =
            [
                'request' => [
                    't_sep' => [
                        'noKartu'   =>  $data["noka"],
                        'tglSep'   =>  $data["txttglsep"],
                        'ppkPelayanan'   =>  $data["kdppkPelayanan"], //KODE RS
                        'jnsPelayanan'   =>  $data["jnsPelayanan"],
                        'klsRawat'   =>  [
                            'klsRawatHak'   =>   $data["cb_kelasrawat"],
                            'klsRawatNaik'   =>  "",
                            'pembiayaan'   =>  "",
                            'penanggungJawab'   =>  "",
                        ],
                        'noMR'   =>  $data["nomr"],
                        'rujukan'   =>  [
                            'asalRujukan'   =>   $data["cb_asalrujukan"],
                            'tglRujukan'   =>  $data["txttglrujukan"],
                            'noRujukan'   =>  $data["txtnorujukan"],
                            // 'ppkRujukan'   =>  $data['ppkRujukan'], //PPK FASKES 1
                            'ppkRujukan'   =>  $ppkRujukan,
                        ],
                        'catatan'   =>   $data["txtcatatan"],
                        'diagAwal'   =>  $data["txt_kddiagnosa"],
                        'poli'   =>  [
                            'tujuan'   =>  $politujuan,
                            'eksekutif'   =>  $eksekutif,
                        ],
                        'cob'   =>  [
                            'cob'   =>  $cob,
                        ],
                        'katarak'   =>  [
                            'katarak'   =>  $katarak,
                        ],
                        'jaminan'   =>  [
                            'lakaLantas'   => $data["cb_statuskecelakaan"],
                            'noLP'     => "123456789",
                            'penjamin'   =>  [
                                'tglKejadian'   =>  "",
                                'keterangan'   =>  "",
                                'suplesi'   =>  [
                                    'suplesi'   =>  "0",
                                    'noSepSuplesi'   =>  "",
                                    'lokasiLaka'   =>  [
                                        'kdPropinsi'   =>  "",
                                        'kdKabupaten'   =>  "",
                                        'kdKecamatan'   =>  ""
                                    ]
                                ]
                            ],
                        ],
                        'tujuanKunj'=> $tujuankunjungan_,
                        'flagProcedure'=> $flagprocedure_,
                        'kdPenunjang'=> $penunjang_,
                        'assesmentPel'=> $assesmentpelayanan_,
                        'skdp'   =>  [
                            'noSurat'   =>  $nosurat,
                            'kodeDPJP'   =>  $data["tx_kddpjp"],
                        ],
                        'dpjpLayan' => $DPJPLAYAN,
                        'noTelp'   =>  $data["txtnotelp"],
                        'user'   =>  $user["firstname"] . " " . $user["lastname"]

                    ]
                ]
            ];
        return $payload;
    }

    public function _toFormatIgd($data)
    {
        $dataid                 = $this->_dataid;
        $secretKey              = $this->_secretKey;
        $tStamp               = strval(time() - strtotime('1970-01-01 00:00:00'));
        $key = $dataid . $secretKey . $tStamp;

        $user           =   $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $eksekutif      =   $data["chkpoliesekutif"] ? $data["chkpoliesekutif"] : "0";
        $cob            = $data["chkCOB"] ?  $data["chkCOB"] : "0";
        $katarak        = $data["chkkatarak"] ?   $data["chkkatarak"] : "0";
        $DPJPLAYAN = $data['tx_kddpjp1'];
        $politujuan = $data['politujuan'];
        $payload  =
            [
                'request' => [
                    't_sep' => [
                        'noKartu'   =>  $data["noka"],
                        'tglSep'   =>  $data["txttglsep"],
                        'ppkPelayanan'   =>  $data["kdppkPelayanan"], //KODE RS
                        'jnsPelayanan'   =>  $data["jnsPelayanan"],
                        'klsRawat'   =>  [
                            'klsRawatHak'   =>   $data["cb_kelasrawat"],
                            'klsRawatNaik'   =>  "",
                            'pembiayaan'   =>  "",
                            'penanggungJawab'   =>  "",
                        ],
                        'noMR'   =>  $data["nomr"],
                        'rujukan'   =>  [
                            'asalRujukan'   =>   $data["cb_asalrujukan"],
                            'tglRujukan'   =>  $data["txttglrujukan"],
                            'noRujukan'   =>  $data["txtnorujukan"],
                            'ppkRujukan'   =>  $data['ppkRujukan'], //PPK FASKES 1
                        ],
                        'catatan'   =>   $data["txtcatatan"],
                        'diagAwal'   =>  $data["txt_kddiagnosa"],
                        'poli'   =>  [
                            'tujuan'   =>  $politujuan,
                            'eksekutif'   =>  $eksekutif,
                        ],
                        'cob'   =>  [
                            'cob'   =>  $cob,
                        ],
                        'katarak'   =>  [
                            'katarak'   =>  $katarak,
                        ],
                        'jaminan'   =>  [
                            'lakaLantas'   => $data["cb_statuskecelakaan"],
                            'noLP'     => $data["txtnotelp"],
                            'penjamin'   =>  [
                                'tglKejadian'   =>  "",
                                'keterangan'   =>  "",
                                'suplesi'   =>  [
                                    'suplesi'   =>  "0",
                                    'noSepSuplesi'   =>  "",
                                    'lokasiLaka'   =>  [
                                        'kdPropinsi'   =>  "",
                                        'kdKabupaten'   =>  "",
                                        'kdKecamatan'   =>  ""
                                    ]
                                ]
                            ],
                        ],
                        'tujuanKunj'=> "0",
                        'flagProcedure'=> "",
                        'kdPenunjang'=> "",
                        'assesmentPel'=> "",
                        'skdp'   =>  [
                            'noSurat'   =>  "",
                            'kodeDPJP'   =>  "",
                        ],
                        'dpjpLayan' => $DPJPLAYAN,
                        'noTelp'   =>  $data["txtnotelp"],
                        'user'   =>  $user["firstname"] . " " . $user["lastname"]

                    ]
                ]
            ];
        return $payload;
    }

    public function _toFormatInap($data)
    {
        $dataid                 = $this->_dataid;
        $secretKey              = $this->_secretKey;
        $tStamp               = strval(time() - strtotime('1970-01-01 00:00:00'));
        $key = $dataid . $secretKey . $tStamp;

        $user           =   $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $eksekutif      =   $data["chkpoliesekutif"] ? $data["chkpoliesekutif"] : "0";
        $cob            = $data["chkCOB"] ?  $data["chkCOB"] : "0";
        $katarak        = $data["chkkatarak"] ?   $data["chkkatarak"] : "0";


        if ($data["jnsPelayanan"] == 1) {
            $nosurat = $data["txtnospri"];
        } else {
            $nosurat = $data["txtnoSurat"];
        }

        if ($data["cb_naikkelas"] != "") {
            $pembiayaan = $data["cb_pembiayaan"];
            $penanggungJawab = $data["tx_nmpembiayaan"];
        }
        else{
            $pembiayaan = "";
            $penanggungJawab = "";
        }
        $DPJPLAYAN = $data['tx_kddpjplay'];

        $politujuan = isset($data['politujuan']) ? $data['politujuan'] : "";
        $payload  =
            [
                'request' => [
                    't_sep' => [
                        'noKartu'   =>  $data["noka"],
                        'tglSep'   =>  $data["txttglsep"],
                        'ppkPelayanan'   =>  $data["kdppkPelayanan"], //KODE RS
                        'jnsPelayanan'   =>  $data["jnsPelayanan"],
                        'klsRawat'   =>  [
                            'klsRawatHak'   =>   $data["cb_kelasrawat"],
                            'klsRawatNaik'   =>  $data["cb_naikkelas"],
                            'pembiayaan'   =>  $pembiayaan,
                            'penanggungJawab'   =>  $penanggungJawab,
                        ],
                        'noMR'   =>  $data["nomr"],
                        'rujukan'   =>  [
                            'asalRujukan'   =>   $data["cb_asalrujukan"],
                            'tglRujukan'   =>  $data["txttglrujukan"],
                            'noRujukan'   =>  $nosurat,
                            'ppkRujukan'   =>  "1111R010", //PPK FASKES 1
                        ],
                        'catatan'   =>   $data["txtcatatan"],
                        'diagAwal'   =>  $data["txt_kddiagnosa"],
                        'poli'   =>  [
                            'tujuan'   =>  "",
                            'eksekutif'   =>  "0",
                        ],
                        'cob'   =>  [
                            'cob'   =>  "0",
                        ],
                        'katarak'   =>  [
                            'katarak'   =>  "0",
                        ],
                        'jaminan'   =>  [
                            'lakaLantas'   => "0",
                            'noLP'     => "",
                            'penjamin'   =>  [
                                'tglKejadian'   =>  "",
                                'keterangan'   =>  "",
                                'suplesi'   =>  [
                                    'suplesi'   =>  "0",
                                    'noSepSuplesi'   =>  "",
                                    'lokasiLaka'   =>  [
                                        'kdPropinsi'   =>  "",
                                        'kdKabupaten'   =>  "",
                                        'kdKecamatan'   =>  ""
                                    ]
                                ]
                            ],
                        ],
                        'tujuanKunj'=>"0",
                        'flagProcedure'=>"",
                        'kdPenunjang'=>"",
                        'assesmentPel'=>"",
                        'skdp'   =>  [
                            'noSurat'   =>  $nosurat,
                            'kodeDPJP'   =>  $data["tx_kddpjp"],
                        ],
                        'dpjpLayan' => "",
                        'noTelp'   =>  $data["txtnotelp"],
                        'user'   =>  $user["firstname"] . " " . $user["lastname"]

                    ]
                ]
            ];
        return $payload;
    }

    public function _toFormat($data)
    {
        $user           =   $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $eksekutif      =   $data["chkpoliesekutif"] ? $data["chkpoliesekutif"] : "0";
        $cob            = $data["chkCOB"] ?  $data["chkCOB"] : "0";
        $katarak        = $data["chkkatarak"] ?   $data["chkkatarak"] : "0";


        if ($data["jnsPelayanan"] == 1) {
            $nosurat = $data["txtnospri"];
        } else {
            $nosurat = $data["txtnoSurat"];
        }

        if ($data["cb_asalrujukan"] == 1) {
            $ppkRujukan =  $data["ppkRujukan"];
        } else if ($data["cb_asalrujukan"] == 2) {

            $rujukan = $this->DETAILRUJUKAN($data["txtnorujukan"], 2);
            $ppkRujukan = $rujukan["response"]["rujukan"]["provPerujuk"]["kode"];
        } else {
            $ppkRujukan =  "";
        }

        $politujuan = isset($data['politujuan']) ? $data['politujuan'] : "";
        $ppkRujukan_ = isset($ppkRujukan) ? $ppkRujukan : "1111R010";
        $ppkRujukanRS = "1111R010";

        $payload  =
            [
                'request' => [
                    't_sep' => [
                        'noKartu'   =>  $data["noka"],
                        'tglSep'   =>  $data["txttglsep"],
                        'ppkPelayanan'   =>  $data["kdppkPelayanan"], //KODE RS
                        'jnsPelayanan'   =>  $data["jnsPelayanan"],
                        // 'klsRawat'   =>  $data["cb_kelasrawat"],
                        'klsRawat'   =>  [
                            'klsRawatHak'   =>   $data["cb_kelasrawat"],
                            'klsRawatNaik'   =>  "",
                            'pembiayaan'   =>  "",
                            'penanggungJawab'   =>  "",
                        ],
                        'noMR'   =>  $data["nomr"],
                        'rujukan'   =>  [
                            'asalRujukan'   =>   $data["cb_asalrujukan"],
                            'tglRujukan'   =>  $data["txttglrujukan"],
                            'noRujukan'   =>  $data["txttglrujukan"],
                            'ppkRujukan'   =>  $ppkRujukan_, //PPK FASKES 1
                        ],
                        'catatan'   =>   $data["txtcatatan"],
                        'diagAwal'   =>  $data["txt_kddiagnosa"],
                        'poli'   =>  [
                            'tujuan'   =>  $politujuan,
                            'eksekutif'   =>  $eksekutif,
                        ],
                        'cob'   =>  [
                            'cob'   =>  $cob,
                        ],
                        'katarak'   =>  [
                            'katarak'   =>  $katarak,
                        ],
                        'jaminan'   =>  [
                            'lakaLantas'   => $data["cb_statuskecelakaan"],
                            'noLP'     => "123456789",
                            'penjamin'   =>  [
                                'tglKejadian'   =>  "",
                                'keterangan'   =>  "",
                                'suplesi'   =>  [
                                    'suplesi'   =>  "0",
                                    'noSepSuplesi'   =>  "",
                                    'lokasiLaka'   =>  [
                                        'kdPropinsi'   =>  "",
                                        'kdKabupaten'   =>  "",
                                        'kdKecamatan'   =>  ""
                                    ]
                                ]
                            ],
                        ],
                        'tujuanKunj'=>"0",
                        'flagProcedure'=>"",
                        'kdPenunjang'=>"",
                        'assesmentPel'=>"",
                        'skdp'   =>  [
                            'noSurat'   =>  $nosurat,
                            'kodeDPJP'   =>  $data["tx_kddpjp"],
                        ],
                        'dpjpLayan' => $data["tx_kddpjp"],
                        'noTelp'   =>  $data["txtnotelp"],
                        'user'   =>  $user["firstname"] . " " . $user["lastname"]

                    ]
                ]
            ];
        return $payload;
    }

    public function _toFormatDelete($input,$instansi)
    {
        $dataid                 = $this->_dataid;
        $secretKey              = $this->_secretKey;
        $tStamp               = strval(time() - strtotime('1970-01-01 00:00:00'));
        $key = $dataid . $secretKey . $tStamp;

        $payload  =
            [
                'request' => [
                    't_sep' => [
                        'noSep'   =>  $input,
                        'user'   =>  $instansi
                    ]
                ]
            ];
        return $payload;
    }
    
    private function _send($method, $path, $payload = null)
    {
        try {
            $config['base_uri'] = $this->_url;
            $config['headers'] = $this->_header;
            $config['verify'] = false;
            $config['timeout'] = 20;

            switch ($method) {
                case "GET":
                    break;
                case "POST":
                    $config['json'] = $payload;
                    break;
                case "DELETE":
                    $config['json'] = $payload;
                    break;
                case "PUT":
                    $config['json'] = $payload;
                    break;
                default:
            }

            $response = $this->_client->request($method, $path, $config);
            $result = json_decode($response->getBody()->getContents(), true);
            $result["error"] = 0;
        } catch (\GuzzleHttp\Exception\RequestException  $e) {
            $result["error"] = 1;
            $result["message"] = "BPJS Kemenkes Bermasalah; Silakan Refresh";
        }

        return $result;
    }


    public function saveToLocal($resultsep, $result, $input, $formatdata, $formatrujukan)
    {

        if ($resultsep["metaData"]["code"] == 200) {
			
			 

        if ($formatrujukan["metaData"]["code"] == 200) {
			     $sep["tglKunjungan"] = $formatdata["rujukan"]["tglKunjungan"] ? $formatdata["rujukan"]["tglKunjungan"] : null;
                $sep["provPerujuk_kode"] = $formatdata["rujukan"]["provPerujuk"]["kode"] ? $formatdata["rujukan"]["provPerujuk"]["kode"] : null;
                $sep["provPerujuk_nama"] = $formatdata["rujukan"]["provPerujuk"]["nama"] ? $formatdata["rujukan"]["provPerujuk"]["nama"] : null;
                $sep["ppk_asal"] = $formatdata["rujukan"]["peserta"]["provUmum"]["kdProvider"] ? $formatdata["rujukan"]["peserta"]["provUmum"]["kdProvider"] : null;
                $sep["nama_ppk"] = $formatdata["rujukan"]["peserta"]["provUmum"]["nmProvider"] ? $formatdata["rujukan"]["peserta"]["provUmum"]["nmProvider"] : null;
                $sep["kode_ppk_asal"] = $formatdata["rujukan"]["peserta"]["provUmum"]["kdProvider"] ? $formatdata["rujukan"]["peserta"]["provUmum"]["kdProvider"] : null;
                $sep["nama_ppk_asal"] = $formatdata["rujukan"]["peserta"]["provUmum"]["nmProvider"] ? $formatdata["rujukan"]["peserta"]["provUmum"]["nmProvider"] : null;
                $sep["kelas_rawat"] = $formatdata["rujukan"]["peserta"]["hakKelas"]["kode"] ? $formatdata["rujukan"]["peserta"]["hakKelas"]["kode"] : null;
                $sep["ppk_pelayanan"] = "1111R010";
                $sep["kode_diagnosaawal"] = $formatdata["rujukan"]["diagnosa"]["kode"] ? $formatdata["rujukan"]["diagnosa"]["kode"] : null;
                $sep["nama_diagnosaawal"] = $formatdata["rujukan"]["diagnosa"]["nama"] ? $formatdata["rujukan"]["diagnosa"]["nama"] : null;
                $sep["table_source"] = "t_pendaftaran";
            }
			
			
            $this->updateSEP($input["idadmission"], $result["sep"]["noSep"]);
            //die();

            $userDetail = $this->getUserDetails();
            $sep["nomer_sep"] =  $result["sep"]["noSep"] ?  $result["sep"]["noSep"] : null;
            $sep["nomr"] = $result["sep"]["peserta"]["noMr"] ? $result["sep"]["peserta"]["noMr"] : null;
            $sep["no_kartubpjs"] =  $result["sep"]["peserta"]["noKartu"] ? $result["sep"]["peserta"]["noKartu"] : null;
            $sep["jenis_layanan"] = $input["jnsPelayanan"] ? $input["jnsPelayanan"] : null;
            $sep["tgl_sep"] = $result["sep"]["tglSep"] ? $result["sep"]["tglSep"] : null;
            $sep["tgl_rujukan"] = $input["txttglrujukan"] ?  $input["txttglrujukan"] : null;
            $sep["kelas_rawat"] = $result["sep"]["kelasRawat"] ?  $result["sep"]["kelasRawat"] : null;
            $sep["no_rujukan"] = $input["txtnorujukan"] ?  $input["txtnorujukan"] : null;
            $sep["catatan"] =  $result["sep"]["catatan"] ? $result["sep"]["catatan"] : null;
            $sep["nama_diagnosaawal"] =  $result["sep"]["diagnosa"] ?  $result["sep"]["diagnosa"] : null;
            $sep["laka_lantas"] = $formatdata["request"]["t_sep"]["jaminan"]["lakaLantas"] ? $formatdata["request"]["t_sep"]["jaminan"]["lakaLantas"] : null;
            if ($input['politujuan'] == 'IGD') {
                $sep["kddpjpvclaim"] = $input["tx_kddpjp1"] ? $input["tx_kddpjp1"] : null;
                $sep["nmkddpjpvclaim"] = $input["tx_nmdpjp1"] ?  $input["tx_nmdpjp1"] : null;
            }
            else{
                $sep["kddpjpvclaim"] = $input["tx_kddpjp"] ? $input["tx_kddpjp"] : null;
                $sep["nmkddpjpvclaim"] = $input["tx_nmdpjp"] ?  $input["tx_nmdpjp"] : null;
            }
            $sep["faskes_id"] = $input["cb_asalrujukan"] ? $input["cb_asalrujukan"] : null;
            $sep["spri"] = $formatdata["request"]["t_sep"]["skdp"]["noSurat"] ? $formatdata["request"]["t_sep"]["skdp"]["noSurat"] : null;


        
            //  $sep["last_update"] = date('Y-m-d H:m:s');
            $sep["no_telp"] = $input["txtnotelp"]  ? $input["txtnotelp"] : null;
            $sep["idx"] = $input["idadmission"] ? $input["idadmission"] : null;

            $sep["poli_eksekutif"] = $formatdata["request"]["t_sep"]["poli"]["eksekutif"]  ? $formatdata["request"]["t_sep"]["poli"]["eksekutif"] : 0;
            $sep["cob"] = $formatdata["request"]["t_sep"]["cob"]["cob"] ? $formatdata["request"]["t_sep"]["cob"]["cob"] : 0;
            $sep["katarak"] = $formatdata["request"]["t_sep"]["katarak"]["katarak"] ? $formatdata["request"]["t_sep"]["katarak"]["katarak"] : 0;
            $sep["user_id"] = $userDetail["id"] ? $userDetail["id"] : null;


            $sep["nama_peserta"] = $result["sep"]["peserta"]["nama"] ? $result["sep"]["peserta"]["nama"] : null;
            $sep["prolanisPRB"] = $result["sep"]["informasi"]["prolanisPRB"] ?  $result["sep"]["informasi"]["prolanisPRB"]  : null;
            $sep["jenisPeserta_keterangan"] =  $result["sep"]["peserta"]["jnsPeserta"]  ?  $result["sep"]["peserta"]["jnsPeserta"] : null;
            $sep["tglLahir"] =  $result["sep"]["peserta"]["tglLahir"]  ?  $result["sep"]["peserta"]["tglLahir"] : null;
            $sep["nama_kelas"] =  $result["sep"]["peserta"]["hakKelas"]  ?  $result["sep"]["peserta"]["hakKelas"] : null;
            $sep["nama_layanan"] =  $result["sep"]["jnsPelayanan"]  ?  $result["sep"]["jnsPelayanan"] : null;
            $sep["kelamin"] =  $result["sep"]["peserta"]["kelamin"]  ?  $result["sep"]["peserta"]["kelamin"] : null;
            $sep["penjamin"] =  $result["sep"]["penjamin"]  ?  $result["sep"]["penjamin"] : null;
            $sep["kode_politujuan"] = $input["politujuan"] ?  $input["politujuan"] : null;
            $sep["nama_politujuan"] =  $input["txtnmpoli"]  ?  $input["txtnmpoli"] : null;
            $sep["nosuratkontrol"] = $input["txtnoSurat"] ?  $input["txtnoSurat"] : null;
            $sep["naikkelas"] = $input["cb_naikkelas"]  ? $input["cb_naikkelas"] : null;
            $sep["pembiayaan"] = $input["cb_pembiayaan"]  ? $input["cb_pembiayaan"] : null;
            $sep["penanggungJawab"] = $input["tx_nmpembiayaan"]  ? $input["tx_nmpembiayaan"] : null;


            if($input["cb_asalrujukan"]==1){
                $sep["ppkRujukan"] = $input["ppkRujukan"] ?  $input["ppkRujukan"] : null;
            }else if($input["cb_asalrujukan"]==2){
                $sep["ppkRujukan"] = null;
            }else{
                //
            }

            $this->db->insert('t_sep', $sep);
            return $this->db->affected_rows();
        } else {
            return 0;
        }
    }

    public function saveToLocalRajal($resultsep, $result, $input, $formatdata, $formatrujukan)
    {

        if ($resultsep["metaData"]["code"] == 200) {
            
             

        if ($formatrujukan["metaData"]["code"] == 200) {
                 $sep["tglKunjungan"] = $formatdata["rujukan"]["tglKunjungan"] ? $formatdata["rujukan"]["tglKunjungan"] : null;
                $sep["provPerujuk_kode"] = $formatdata["rujukan"]["provPerujuk"]["kode"] ? $formatdata["rujukan"]["provPerujuk"]["kode"] : null;
                $sep["provPerujuk_nama"] = $formatdata["rujukan"]["provPerujuk"]["nama"] ? $formatdata["rujukan"]["provPerujuk"]["nama"] : null;
                $sep["ppk_asal"] = $formatdata["rujukan"]["peserta"]["provUmum"]["kdProvider"] ? $formatdata["rujukan"]["peserta"]["provUmum"]["kdProvider"] : null;
                $sep["nama_ppk"] = $formatdata["rujukan"]["peserta"]["provUmum"]["nmProvider"] ? $formatdata["rujukan"]["peserta"]["provUmum"]["nmProvider"] : null;
                $sep["kode_ppk_asal"] = $formatdata["rujukan"]["peserta"]["provUmum"]["kdProvider"] ? $formatdata["rujukan"]["peserta"]["provUmum"]["kdProvider"] : null;
                $sep["nama_ppk_asal"] = $formatdata["rujukan"]["peserta"]["provUmum"]["nmProvider"] ? $formatdata["rujukan"]["peserta"]["provUmum"]["nmProvider"] : null;
                $sep["kelas_rawat"] = $formatdata["rujukan"]["peserta"]["hakKelas"]["kode"] ? $formatdata["rujukan"]["peserta"]["hakKelas"]["kode"] : null;
                $sep["ppk_pelayanan"] = "1111R010";
                $sep["kode_diagnosaawal"] = $formatdata["rujukan"]["diagnosa"]["kode"] ? $formatdata["rujukan"]["diagnosa"]["kode"] : null;
                $sep["nama_diagnosaawal"] = $formatdata["rujukan"]["diagnosa"]["nama"] ? $formatdata["rujukan"]["diagnosa"]["nama"] : null;
                $sep["table_source"] = "t_pendaftaran";
            }
            
            
            $this->updateSEP($input["idadmission"], $result["sep"]["noSep"]);

            $userDetail = $this->getUserDetails();
            $sep["nomer_sep"] =  $result["sep"]["noSep"] ?  $result["sep"]["noSep"] : null;
            $sep["nomr"] = $result["sep"]["peserta"]["noMr"] ? $result["sep"]["peserta"]["noMr"] : null;
            $sep["no_kartubpjs"] =  $result["sep"]["peserta"]["noKartu"] ? $result["sep"]["peserta"]["noKartu"] : null;
            $sep["jenis_layanan"] = $input["jnsPelayanan"] ? $input["jnsPelayanan"] : null;
            $sep["tgl_sep"] = $result["sep"]["tglSep"] ? $result["sep"]["tglSep"] : null;
            $sep["tgl_rujukan"] = $input["txttglrujukan"] ?  $input["txttglrujukan"] : null;
            $sep["kelas_rawat"] = $result["sep"]["kelasRawat"] ?  $result["sep"]["kelasRawat"] : null;
            $sep["no_rujukan"] = $input["txtnorujukan"] ?  $input["txtnorujukan"] : null;
            $sep["catatan"] =  $result["sep"]["catatan"] ? $result["sep"]["catatan"] : null;
            $sep["nama_diagnosaawal"] =  $result["sep"]["diagnosa"] ?  $result["sep"]["diagnosa"] : null;
            $sep["laka_lantas"] = $formatdata["request"]["t_sep"]["jaminan"]["lakaLantas"] ? $formatdata["request"]["t_sep"]["jaminan"]["lakaLantas"] : null;
            $sep["kddpjpvclaim"] = $input["tx_kddpjplay"] ? $input["tx_kddpjplay"] : null;
            $sep["nmkddpjpvclaim"] = $input["namadpjplay"] ?  $input["namadpjplay"] : null;
            $sep["faskes_id"] = $input["cb_asalrujukan"] ? $input["cb_asalrujukan"] : null;
            $sep["spri"] = $formatdata["request"]["t_sep"]["skdp"]["noSurat"] ? $formatdata["request"]["t_sep"]["skdp"]["noSurat"] : null;


        
            //  $sep["last_update"] = date('Y-m-d H:m:s');
            $sep["no_telp"] = $input["txtnotelp"]  ? $input["txtnotelp"] : null;
            $sep["idx"] = $input["idadmission"] ? $input["idadmission"] : null;

            $sep["poli_eksekutif"] = $formatdata["request"]["t_sep"]["poli"]["eksekutif"]  ? $formatdata["request"]["t_sep"]["poli"]["eksekutif"] : 0;
            $sep["cob"] = $result["sep"]["cob"] ?  $result["sep"]["cob"] : 0;
            // $sep["cob"] = $input['chkCOB'];
            // $sep["katarak"] = $result["sep"]["katarak"] ?  $result["sep"]["katarak"] : 0;
            $sep["katarak"] = $input["chkkatarak"];
            $sep["user_id"] = $userDetail["id"] ? $userDetail["id"] : null;


            $sep["nama_peserta"] = $result["sep"]["peserta"]["nama"] ? $result["sep"]["peserta"]["nama"] : null;
            $sep["prolanisPRB"] = $result["sep"]["informasi"]["prolanisPRB"] ?  $result["sep"]["informasi"]["prolanisPRB"]  : null;
            $sep["jenisPeserta_keterangan"] =  $result["sep"]["peserta"]["jnsPeserta"]  ?  $result["sep"]["peserta"]["jnsPeserta"] : null;
            $sep["tglLahir"] =  $result["sep"]["peserta"]["tglLahir"]  ?  $result["sep"]["peserta"]["tglLahir"] : null;
            $sep["nama_kelas"] =  $result["sep"]["peserta"]["hakKelas"]  ?  $result["sep"]["peserta"]["hakKelas"] : null;
            $sep["nama_layanan"] =  $result["sep"]["jnsPelayanan"]  ?  $result["sep"]["jnsPelayanan"] : null;
            $sep["kelamin"] =  $result["sep"]["peserta"]["kelamin"]  ?  $result["sep"]["peserta"]["kelamin"] : null;
            $sep["penjamin"] =  $result["sep"]["penjamin"]  ?  $result["sep"]["penjamin"] : null;
            $sep["kode_politujuan"] = $input["politujuan"];
            $sep["nama_politujuan"] =  $input["txtnmpoli"];
            $sep["nosuratkontrol"] = $input["txtnoSurat"] ?  $input["txtnoSurat"] : null;



            if($input["cb_asalrujukan"]==1){
                $sep["ppkRujukan"] = $input["ppkRujukan"] ?  $input["ppkRujukan"] : null;
            }else if($input["cb_asalrujukan"]==2){
                $sep["ppkRujukan"] = null;
            }else{
                //
            }
            

            if ($input["cb_statuspoli"] == "YA") {
                if ($input["cb_tujuankunj"] == 0) {
                    $sep["assesmentPelayanan"] = "";
                    $sep["tujuanKunj"] = "0";
                }
                else if ($input["cb_tujuankunj"] == 1) {
                    $sep["flagProcedure"] = $input['cb_flagProcedure'];
                    $sep["kdPenunjang"] = $input['cb_kdPenunjang'];
                    $sep["tujuanKunj"] = "1";
                }
                else if ($input["cb_tujuankunj"] == 2) {
                    $sep["assesmentPelayanan"] = $input['cb_assesmentPel'];
                    $sep["tujuanKunj"] = "2";
                }
            }

            else {
                $sep["assesmentPelayanan"] = $input['cb_assesmentPel'];
                $sep["tujuanKunj"] = "0";
            }

            $sep["status_poli_sama"] = $input["cb_statuspoli"];



            $this->db->insert('t_sep', $sep);
            return $this->db->affected_rows();
        } else {
            return 0;
        }
    }

    public function  saveToLocalRencanaKontrol($iniresponse, $datauser, $nomr, $poli, $sep, $idxdaftarlast, $idbilldetailtariflast)
    {
        $nomer_suratkontrol = $iniresponse["noSuratKontrol"];

        $data = array(
            'id_bill_detail_tarif' => $idbilldetailtariflast,
            'idxdaftar' => $idxdaftarlast,
            'jenispelayanan'=> '2',
            'nomer_suratkontrol'=>$nomer_suratkontrol,
            'tanggal_rencana_kontrol' => $iniresponse["tglRencanaKontrol"],
            'poli_tujuan' => $poli,
            'nomer_sep' => $sep,
            'nomr' => $nomr,
            'no_kartu' => $iniresponse["noKartu"],
            'dokter' => $iniresponse["namaDokter"],
            'nama_pasien' => $iniresponse["nama"],
            'kelamin' => $iniresponse["kelamin"],
            'tgllahir' => $iniresponse["tglLahir"],
            'petugas_entry' => $datauser
        );

        $this->db->insert('simrs.bill_detail_suratkontrol_bpjs',$data);
        return $this->db->affected_rows();
    }

    public function  saveToLocalRencanaInap($iniresponse, $datauser, $nomr, $poli, $idxdaftar)
    {
        $nomer_suratkontrol = $iniresponse["noSPRI"];

        $data = array(
            'idxdaftar' => $idxdaftar,
            'jenispelayanan'=> '1',
            'nomer_spri'=>$nomer_suratkontrol,
            'tanggal_rencana_kontrol' => $iniresponse["tglRencanaKontrol"],
            'poli_tujuan' => $poli,
            'nomr' => $nomr,
            'no_kartu' => $iniresponse["noKartu"],
            'dokter' => $iniresponse["namaDokter"],
            'nama_pasien' => $iniresponse["nama"],
            'kelamin' => $iniresponse["kelamin"],
            'tgllahir' => $iniresponse["tglLahir"],
            'petugas_entry' => $datauser
        );

        $this->db->insert('simrs.bill_detail_suratkontrol_bpjs',$data);
        return $this->db->affected_rows();
    }

    public function deleteInLocal($sep)
    {
        return $this->db->delete('t_sep', array('nomer_sep' => $sep));
    }

    public function isSuccess($result, $data, $formatdata)
    {
        $this->saveToLocal($result, $data, $formatdata);
        return 1;
    }

    private function getUserDetails()
    {
        $this->db->limit("1");
        return  $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
    }


    public function saveSepSignature($data)
    {
        $input = $this->_findSEPdetails($data);
        if ($input) {
            $this->db->set('signature', $data["json"]);
            $this->db->where('id', $input["id"]);
            $this->db->update('t_sep');
            return $this->db->affected_rows();
        } else {
            return 0;
        }
    }
    public function updateSEP($idx, $nosep)
    {
        if ($idx) {
            $this->db->set('NOJAMINAN', $nosep);
            $this->db->set('NO_SJP', $nosep);
            $this->db->where('IDXDAFTAR', $idx);
            $this->db->update('t_pendaftaran');
            return $this->db->affected_rows();
        }
    }

    public function _findSEPdetails($data)
    {
        $this->db->limit(1);
        $this->db->where('nomr', $data["modal_nomr"]);
        $this->db->where('jenis_layanan', $data["modal_jenispelayanan"]);
        $this->db->where('idx', $data["modal_idadmission"]);
        return $this->db->get('t_sep')->row_array();
    }

    public function getTujuanKunj()
    {
        // return $this->db->get('l_tujuan_kunjungan')->result_array();
        return $this->db->get('l_tujuan_kunjungan')->result_array();
    }

    public function getFlagProcedure()
    {
        // return $this->db->get('l_tujuan_kunjungan')->result_array();
        return $this->db->get_where('l_flag_procedure', ['flagProcedure' => '1'])->result_array();
    }

    public function getAsesmentPel()
    {
        return $this->db->get('l_assesmentpelayanan')->result_array();
    }
    public function getKdPenunjang()
    {
        return $this->db->get_where('l_kdpenunjang', ['procedure' => '1'])->result_array();
    }

    public function kelas()
    {
        return $this->db->get('l_naikkelas')->result_array();
    }

    function countTpprj($tanggal)
    {
        date_default_timezone_set('Asia/Jakarta');

        $queryMenu = "SELECT COUNT(id) as jumlah, SUBSTRING(tgl_sep, 1,10) as tanggal from t_sep where SUBSTRING(tgl_sep, 1,10) = '$tanggal' and (kode_politujuan != 'IGD' and jenis_layanan = '2')";

        return $this->db->query($queryMenu)->row_array();
    }

    function countTppri($tanggal)
    {
        date_default_timezone_set('Asia/Jakarta');

        $queryMenu = "SELECT COUNT(id) as jumlah, SUBSTRING(tgl_sep, 1,10) as tanggal from t_sep where SUBSTRING(tgl_sep, 1,10) = '$tanggal' and jenis_layanan = '1'";

        return $this->db->query($queryMenu)->row_array();
    }

    function countIgd($tanggal)
    {
        date_default_timezone_set('Asia/Jakarta');

        $queryMenu = "SELECT COUNT(id) as jumlah, SUBSTRING(tgl_sep, 1,10) as tanggal from t_sep where SUBSTRING(tgl_sep, 1,10) = '$tanggal' and (kode_politujuan = 'IGD' and jenis_layanan = '2')";

        return $this->db->query($queryMenu)->row_array();
    }

    public function getSensusSuratKontrol()
    {
        $queryMenu = "SELECT
                        m_poly.kode,
                        m_poly.nama,
                        (
                        SELECT
                            count( simrs.bill_detail_suratkontrol_bpjs.id ) 
                        FROM
                            simrs.bill_detail_suratkontrol_bpjs 
                        WHERE
                            simrs.bill_detail_suratkontrol_bpjs.jenispelayanan = '2' 
                            AND simrs.bill_detail_suratkontrol_bpjs.userlevelid_kontrol = m_poly.kode 
                        ) AS jumlah_surat_kontrol,
                        (
                        SELECT
                            count( simrs.bill_detail_suratkontrol_bpjs.id ) 
                        FROM
                            simrs.bill_detail_suratkontrol_bpjs 
                        WHERE
                            simrs.bill_detail_suratkontrol_bpjs.jenispelayanan = '1' 
                            AND simrs.bill_detail_suratkontrol_bpjs.userlevelid_kontrol = m_poly.kode 
                        ) AS jumlah_spri 
                    FROM
                        m_poly
                        LEFT JOIN simrs.bill_detail_suratkontrol_bpjs ON simrs.bill_detail_suratkontrol_bpjs.userlevelid_kontrol = m_poly.kode 
                    WHERE
                        m_poly.isOpen = 1 
                        AND (
                            m_poly.kode != '0' 
                            AND m_poly.kode != 10 
                            AND m_poly.kode != '48' 
                            AND m_poly.kode != '106' 
                            AND m_poly.kode != '16' 
                            AND m_poly.kode != '17' 
                            AND m_poly.kode != '9' 
                        ) 
                    GROUP BY
                        m_poly.kode";
        return $this->db->query($queryMenu)->result_array();
    
    }

    function countSuratKontrol()
    {
        date_default_timezone_set('Asia/Jakarta');

        $queryMenu = "SELECT COUNT(id) as jumlah from simrs.bill_detail_suratkontrol_bpjs where jenispelayanan = '2'";

        return $this->db->query($queryMenu)->row_array();
    }

    function countSPRI()
    {
        date_default_timezone_set('Asia/Jakarta');

        $queryMenu = "SELECT COUNT(id) as jumlah from simrs.bill_detail_suratkontrol_bpjs where jenispelayanan = '1'";

        return $this->db->query($queryMenu)->row_array();
    }

    public function get_dpjpSuratKontrol($id){
        $hasil=$this->db->query("SELECT uid, pd_nickname as nama, mapping_dokter_bpjs,kode_spesialis FROM simrs.master_login WHERE kode_spesialis='$id' ORDER BY pd_nickname ASC");
        return $hasil->result();
    }
}
