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

class Antrian_model  extends CI_Model
{
    private $_client;
    private $_header;
    private $_config;
    private $_dataid = BASE_ANTREAN_DATAID;
    private $_secretKey = BASE_ANTREAN_SECRET;
    private $_url = BASE_ANTREAN_URL_PRODUCTION;

    private $dbAntiran;
    /*public function __construct()
    {
        parent::__construct();
    }*/


    public function __construct()
    {
        parent::__construct();
        $this->_client = new Client();

        date_default_timezone_set('UTC');
        $dataid                 = $this->_dataid;
        $secretKey              = $this->_secretKey;
        // $userkey                = '2ef9ac0bb6a1f75bb06c2eacc62bdc11';
        $user_key               = '73b1a0e915a1416962ce62419956db98';


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

    public function loadPoli()
    {
        $dbAntiran = $this->load->database('mesinAntrian', true);
        //$queryKlinik =
        return $this->dbAntiran->get('tbklinik')->result_array();
    }

    public function _formatTambahAntrian($data,$nomrbaru)
    {
        $dataid                 = $this->_dataid;
        $secretKey              = $this->_secretKey;
        $tStamp               = strval(time() - strtotime('1970-01-01 00:00:00'));
        $key = $dataid . $secretKey . $tStamp;

        $angkaantrian = $data['noantrian'];
        $noantrian = $data['kdAntrian'].''.$data['noantrian'];
        $tipe_pasien = $data['rbflagstatusPasienDaftar'];
            $norm = $nomrbaru;
        if ($data['rbParentCarabayar'] == 1) {
            $jenis_pasien = "NON JKN";
        }
        else{
            $jenis_pasien = "JKN";
        }
        $no_kartu = $data['nokabpjs'];
        $nik = $data['noktp'];
        $nohp = $data['tx_notelepon'];
        $tanggalperiksa = $data['dtp_tanggal_daftar'];
        $jenis_kunjungan = $data['cb_jeniskunjungan'];
        $no_referensi = $data['tx_no_rujukan_bpjs'];
        $poli = $data['cb_poly'];
        $dokter = $data['cb_dokterjaga'];
        $nama_pasien = $data['tx_nama'];
        $tgl_lahir = $data['tgllahir'];
        $alamat_lengkap = $data['alamatktp'];
        $nama_pj = $data['tx_namapenanggungjawab'];
        $hubungan_pj = $data['cb_hubungan'];
        $notel_pj = $data['tx_notel_penanggungjawab'];
        $alamat_pj = $data['tx_alamatpenanggungjawab'];
        $var = $tanggalperiksa;
        $date = str_replace('-', '-', $var);
        $tanggalperiksaconvert = date('Y-m-d', strtotime($date));

        $kodebooking = date("Ymd", strtotime($tanggalperiksaconvert)).''.$noantrian;
        $jambuka = "06:20:00";
        $jumlah = $angkaantrian*10;
            
        $newDate = date(''.$tanggalperiksaconvert.' H:i:s', strtotime($jambuka. ' +'.$jumlah.' minutes'));
        $estimasidilayani =  strtotime($newDate)*1000;
        $estimasi =  strval($estimasidilayani);
        $hari = $tanggalperiksaconvert;
        $namahari =  getNamaHari($hari);
        $waktu =  strtotime(date("Y-m-d H:i:s"))*1000;

            //ini get kode bpjs
        $data["polibpjs"] = $this->poli->getListPoli($poli);
        $data["dokterbpjs"] = $this->dokterjaga->getDokterBpjs($dokter,$namahari);
        $data["sisajkn"] = $this->dokterjaga->getSisaJKN($tanggalperiksa,$dokter);
        $data["sisanonjkn"] = $this->dokterjaga->getSisaNonJKN($tanggalperiksa,$dokter);


        $payload  =
                        [
                            
                            'kodebooking'   => $kodebooking,
                            'jenispasien'  => $jenis_pasien,
                            'nomorkartu'  => $no_kartu,
                            'nik'  => $nik,
                            'nohp'   =>  $nohp,
                            'kodepoli'    => $data["polibpjs"][0]['maping_bpjs'],
                            'namapoli'   =>  $data["polibpjs"][0]['maping_bpjs_nama'],
                            'pasienbaru' => $tipe_pasien,
                            'norm' => $norm,
                            'tanggalperiksa' => $tanggalperiksaconvert,
                            'kodedokter' => $data["dokterbpjs"][0]['mapping_dokter_bpjs'],
                            'namadokter' => $dokter,
                            'jampraktek' => $data["dokterbpjs"][0]['jam_praktek'],
                            'jeniskunjungan' => $jenis_kunjungan,
                            'nomorreferensi' => $no_referensi,
                            'nomorantrean' => $noantrian,
                            'angkaantrean' => $angkaantrian,
                            'estimasidilayani' => $estimasi,
                            'sisakuotajkn' => $data["sisajkn"][0]['jml'],
                            'kuotajkn' => $data["dokterbpjs"][0]['kuota_jkn'],
                            'sisakuotanonjkn' => $data["sisanonjkn"][0]['jml'],
                            'kuotanonjkn' => $data["dokterbpjs"][0]['kuota_nonjkn'],
                            'keterangan' => 'Peserta harap 30 menit lebih awal guna pencatatan administrasi.'

                        ];
        
        return $payload;
    }

    public function _formatUpdateWaktu($data)
    {
        $dataid                 = $this->_dataid;
        $secretKey              = $this->_secretKey;
        $tStamp               = strval(time() - strtotime('1970-01-01 00:00:00'));
        $key = $dataid . $secretKey . $tStamp;

        $angkaantrian = $data['noantrian'];
        $noantrian = $data['kdAntrian'].''.$data['noantrian'];
        $tipe_pasien = $data['rbflagstatusPasienDaftar'];
        $tanggalperiksa = $data['dtp_tanggal_daftar'];
        $var = $tanggalperiksa;
        $date = str_replace('-', '-', $var);
        $tanggalperiksaconvert = date('Y-m-d', strtotime($date));

        $kodebooking = date("Ymd", strtotime($tanggalperiksaconvert)).''.$noantrian;
        $waktu =  strtotime(date("Y-m-d H:i:s"))*1000;

        if ($tipe_pasien == 1) {
            $payload  =
                        [
                            'kodebooking'   => $kodebooking,
                            'taskid'  => '1',
                            'waktu'  => $waktu
                        ];
        }
        else {
            $payload  =
                        [
                            'kodebooking'   => $kodebooking,
                            'taskid'  => '3',
                            'waktu'  => $waktu
                        ];
        }
        
        
        return $payload;
    }

    public function _formatUpdateWaktuTask2($data)
    {
        $dataid                 = $this->_dataid;
        $secretKey              = $this->_secretKey;
        $tStamp               = strval(time() - strtotime('1970-01-01 00:00:00'));
        $key = $dataid . $secretKey . $tStamp;

        $noantrian = str_replace(' ', '', $data['no_antian']);
        $tanggalperiksa = $data['TGLREG'];

        $kodebooking = date("Ymd", strtotime($tanggalperiksa)).''.$noantrian;
        $waktu =  strtotime(date("Y-m-d H:i:s"))*1000;

            $payload  =
                        [
                            'kodebooking'   => $kodebooking,
                            'taskid'  => '2',
                            'waktu'  => $waktu
                        ];
        
        
        return $payload;
    }

    public function _formatUpdateWaktuTask2PB($data)
    {
        $dataid                 = $this->_dataid;
        $secretKey              = $this->_secretKey;
        $tStamp               = strval(time() - strtotime('1970-01-01 00:00:00'));
        $key = $dataid . $secretKey . $tStamp;

        $angkaantrian = $data['noantrian'];
        $noantrian = $data['kdAntrian'].''.$data['noantrian'];
        $tipe_pasien = $data['rbflagstatusPasienDaftar'];
        $tanggalperiksa = $data['dtp_tanggal_daftar'];
        $var = $tanggalperiksa;
        $date = str_replace('-', '-', $var);
        $tanggalperiksaconvert = date('Y-m-d', strtotime($date));

        $kodebooking = date("Ymd", strtotime($tanggalperiksaconvert)).''.$noantrian;
        $waktu =  strtotime(date("Y-m-d H:i:s"))*1000;

            $payload  =
                        [
                            'kodebooking'   => $kodebooking,
                            'taskid'  => '2',
                            'waktu'  => $waktu
                        ];
        
        
        return $payload;
    }

    public function _formatUpdateWaktuTask3($data)
    {
        $dataid                 = $this->_dataid;
        $secretKey              = $this->_secretKey;
        $tStamp               = strval(time() - strtotime('1970-01-01 00:00:00'));
        $key = $dataid . $secretKey . $tStamp;

        $noantrian = str_replace(' ', '', $data['no_antian']);
        $tanggalperiksa = $data['TGLREG'];

        $kodebooking = date("Ymd", strtotime($tanggalperiksa)).''.$noantrian;
        $waktu =  strtotime(date("Y-m-d H:i:s"))*1000;

            $payload  =
                        [
                            'kodebooking'   => $kodebooking,
                            'taskid'  => '3',
                            'waktu'  => $waktu
                        ];
        
        
        return $payload;
    }

    public function _formatUpdateWaktuTask3PB($data)
    {
        $dataid                 = $this->_dataid;
        $secretKey              = $this->_secretKey;
        $tStamp               = strval(time() - strtotime('1970-01-01 00:00:00'));
        $key = $dataid . $secretKey . $tStamp;

        $angkaantrian = $data['noantrian'];
        $noantrian = $data['kdAntrian'].''.$data['noantrian'];
        $tipe_pasien = $data['rbflagstatusPasienDaftar'];
        $tanggalperiksa = $data['dtp_tanggal_daftar'];
        $var = $tanggalperiksa;
        $date = str_replace('-', '-', $var);
        $tanggalperiksaconvert = date('Y-m-d', strtotime($date));

        $kodebooking = date("Ymd", strtotime($tanggalperiksaconvert)).''.$noantrian;
        $waktu =  strtotime(date("Y-m-d H:i:s"))*1000;

            $payload  =
                        [
                            'kodebooking'   => $kodebooking,
                            'taskid'  => '3',
                            'waktu'  => $waktu
                        ];
        
        
        return $payload;
    }

    public function tambahAntrean($data)
    {
        $path =   'antrean/add';
        $result = $this->_send("POST", $path, $data);
        return $result;
    }

    public function updateWaktuAntrean($data)
    {
        $path =   'antrean/updatewaktu';
        $result = $this->_send("POST", $path, $data);
        return $result;
    }

    public function updateWaktuAntreanDB($task,$idx)
    {
        $this->db->set('taskid', $task);
        $this->db->where('IDXDAFTAR', $idx);
        $this->db->update('t_pendaftaran');
        return  $this->db->affected_rows();
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

    function antrianResponse($idxdaftar,$task,$code,$message,$kodebooking)
    {
        date_default_timezone_set('Asia/Jakarta');
        $user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data["idxdaftar"]           = $idxdaftar;
        $data["task"]           = $task;
        $data["datetime"]       = date("Y-m-d H:i:s");
        $data["code"]           = $code;
        $data["message"]        = $message;
        $data["kodebooking"]    = $kodebooking;

        $this->db->insert('simrs.antrian_response', $data);
    }

    function antrianRequest($input,$idxdaftar,$nomrbaru)
    {
        date_default_timezone_set('Asia/Jakarta');
        $user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $dataid                 = $this->_dataid;
        $secretKey              = $this->_secretKey;
        $tStamp               = strval(time() - strtotime('1970-01-01 00:00:00'));
        $key = $dataid . $secretKey . $tStamp;

        $angkaantrian = $input['noantrian'];
        $noantrian = $input['kdAntrian'].''.$input['noantrian'];
        $tipe_pasien = $input['rbflagstatusPasienDaftar'];
            $norm = $nomrbaru;
        if ($input['rbParentCarabayar'] == 1) {
            $jenis_pasien = "NON JKN";
        }
        else{
            $jenis_pasien = "JKN";
        }
        $no_kartu = $input['nokabpjs'];
        $nik = $input['noktp'];
        $nohp = $input['tx_notelepon'];
        $tanggalperiksa = $input['dtp_tanggal_daftar'];
        $jenis_kunjungan = $input['cb_jeniskunjungan'];
        $no_referensi = $input['tx_no_rujukan_bpjs'];
        $poli = $input['cb_poly'];
        $dokter = $input['cb_dokterjaga'];
        $nama_pasien = $input['tx_nama'];
        $tgl_lahir = $input['tgllahir'];
        $alamat_lengkap = $input['alamatktp'];
        $nama_pj = $input['tx_namapenanggungjawab'];
        $hubungan_pj = $input['cb_hubungan'];
        $notel_pj = $input['tx_notel_penanggungjawab'];
        $alamat_pj = $input['tx_alamatpenanggungjawab'];
        $var = $tanggalperiksa;
        $date = str_replace('-', '-', $var);
        $tanggalperiksaconvert = date('Y-m-d', strtotime($date));

        $kodebooking = date("Ymd", strtotime($tanggalperiksaconvert)).''.$noantrian;
        $jambuka = "06:20:00";
        $jumlah = $angkaantrian*10;
            
        $newDate = date(''.$tanggalperiksaconvert.' H:i:s', strtotime($jambuka. ' +'.$jumlah.' minutes'));
        $estimasidilayani =  strtotime($newDate)*1000;
        $estimasi =  strval($estimasidilayani);
        $hari = $tanggalperiksaconvert;
        $namahari =  getNamaHari($hari);
        $waktu =  strtotime(date("Y-m-d H:i:s"))*1000;

            //ini get kode bpjs
        $input["polibpjs"] = $this->poli->getListPoli($poli);
        $input["dokterbpjs"] = $this->dokterjaga->getDokterBpjs($dokter,$namahari);
        $input["sisajkn"] = $this->dokterjaga->getSisaJKN($tanggalperiksa,$dokter);
        $input["sisanonjkn"] = $this->dokterjaga->getSisaNonJKN($tanggalperiksa,$dokter);


        $data["idxdaftar"]          = $idxdaftar;
        $data["kodebooking"]        = $kodebooking;
        $data["jenispasien"]        = $jenis_pasien;
        $data["nomorkartu"]         = $no_kartu;
        $data["nik"]                = $nik;
        $data["nohp"]               = $nohp;
        $data["kodepoli"]           = $input["polibpjs"][0]['maping_bpjs'];
        $data["namapoli"]           = $input["polibpjs"][0]['maping_bpjs_nama'];
        $data["pasienbaru"]         = $tipe_pasien;
        $data["norm"]               = $norm;
        $data["tanggalperiksa"]     = $tanggalperiksaconvert;
        $data["kodedokter"]         = $input["dokterbpjs"][0]['mapping_dokter_bpjs'];
        $data["namadokter"]         = $dokter;
        $data["jampraktek"]         = $input["dokterbpjs"][0]['jam_praktek'];
        $data["jeniskunjungan"]     = $jenis_kunjungan;
        $data["nomorreferensi"]     = $no_referensi;
        $data["nomorantrean"]       = $noantrian;
        $data["angkaantrean"]       = $angkaantrian;
        $data["estimasidilayani"]   = $estimasi;
        $data["sisakuotajkn"]       = $input["sisajkn"][0]['jml'];
        $data["kuotajkn"]           = $input["dokterbpjs"][0]['kuota_jkn'];
        $data["sisakuotanonjkn"]    = $input["sisanonjkn"][0]['jml'];
        $data["kuotanonjkn"]        = $input["dokterbpjs"][0]['kuota_nonjkn'];
        $data["keterangan"]         = 'Peserta harap 30 menit lebih awal guna pencatatan administrasi.';
        $data["datetime"]           = date("Y-m-d H:i:s");
        // $data["code"]           = $code;
        // $data["message"]        = $message;
        $this->db->insert('simrs.antrian_request', $data);
    }
}
