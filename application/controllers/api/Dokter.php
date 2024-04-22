<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dokter extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('Vclaim_model', 'vclaim');
    }


    function index()
    {
        echo "d3dd3d";
    }


    public function search($jenispelayanan = null, $spesialisasi = null)
    {
        $tanggal = date('Y-m-d');
        $result = $this->vclaim->DOKTER($jenispelayanan, $tanggal, $spesialisasi);
        if (count($result["response"]["list"]) > 0) {
            foreach ($result["response"]["list"] as $row)
                $arr_result[] = array(
                    'label'         => $row["nama"],
                    'description'   => $row["kode"]
                );
            echo json_encode($arr_result);
        } else {
            $arr_result[] = array(
                'error' => 1,
                'message'       => $result["metaData"]["message"]
            );
            echo json_encode($arr_result);
        }
    }

    public function searchDPJP($jenispelayanan, $spesialisasi)
    {
        $tanggal = date('Y-m-d');
        if ($jenispelayanan) {
            $result = $this->vclaim->searchDPJP($jenispelayanan, $tanggal, $spesialisasi);
            if (count($result["response"]["list"]) > 0) {
                foreach ($result["response"]["list"] as $row)
                    $arr_result[] = array(
                        'label'            => $row["nama"] . " (" . $row["kode"] . ")",
                        'description'    => $row["kode"]
                    );
                echo json_encode($arr_result);
            }
        }
    }
}
