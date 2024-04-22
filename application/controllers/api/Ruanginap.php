<?php

use function GuzzleHttp\json_encode;

defined('BASEPATH') or exit('No direct script access allowed');

class Ruanginap extends CI_Controller
{
    private $_dataid = BASE_DATAID;
    private $_secretKey = BASE_SECRET;
    private $_url = BASE_URL_PRODUCTION;
    
    function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->helper('wpu');
        $this->load->helper('url');
        $this->load->model('Vclaim_model', 'vclaim');
        $this->load->model('Ruang_model', 'ruangan');
        $this->load->model('Aplicares_model', 'aplicares');
        $this->load->helper('pendaftaran');
    }

    function getListRuang()
    {
        $this->_getDetailRuangBed();
    }
    function cariDiagnosa($diagnosa)
    {
        date_default_timezone_set('UTC');

        $dataid                 = $this->_dataid;
        $secretKey              = $this->_secretKey;
        $tStamp               = strval(time() - strtotime('1970-01-01 00:00:00'));
        $key = $dataid . $secretKey . $tStamp;


        $result = null;
        if ($diagnosa) {
            // $result = $this->vclaim->searchDiagnosa($diagnosa);

            $data["search"]  = $this->vclaim->searchDiagnosa($diagnosa);
            $stringData = $data["search"]["response"];
            $result = json_decode($this->vclaim->stringDecrypt($key, $stringData), true);
            // $result1 = json_decode($data["search"], true);
        } else {
            // echo json_encode("error");
        }
        //echo json_encode($this->aplicares->refkamar());
        echo json_encode($result, true);
        // echo json_encode($data["search"],true);
    }





    // -----------------------------------------------------------------------------------------
    private function _ruangActive()
    {
        $ruangan["response"]['ruangan'] = $this->ruangan->getList();
        echo json_encode($ruangan, false);
    }

    private function _getDetailRuangBed()
    {
        $ruang  = $this->ruangan->getList();
        $result["response"]['ruangan'] = [];
        $result["response"]['ruangan']["jumlah"] = count($this->ruangan->getList());


        foreach ($ruang  as $key => $r) {
            $result["response"]['ruangan']['data'][$key]["kodeRuang"] = $r["no"];
            $result["response"]['ruangan']['data'][$key]["namaRuang"] = $r["nama"];
            $result["response"]['ruangan']['data'][$key]["kelas"] = $r["kelas"];
            $result["response"]['ruangan']['data'][$key]["keterangan"] = $r["keterangan"];
            $result["response"]['ruangan']['data'][$key]["bed"]['jumlah'] = count($this->ruangan->getRuangDetails($r["no"]));
            $result["response"]['ruangan']['data'][$key]["bed"]['data'] = $this->ruangan->getRuangDetails($r["no"]);
        }

        $result["metaData"]['code'] = 200;
        $result["metaData"]['message'] = 'Sukses';
        echo json_encode($result, false);
    }
}
