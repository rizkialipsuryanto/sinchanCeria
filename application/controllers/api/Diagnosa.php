<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Diagnosa extends CI_Controller
{
    private $_dataid = BASE_DATAID;
    private $_secretKey = BASE_SECRET;
    private $_url = BASE_URL_PRODUCTION;
    
    function __construct()
    {
        parent::__construct();
        // is_logged_in();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('Vclaim_model', 'vclaim');
    }


    public function search()
    {
        date_default_timezone_set('UTC');

        $dataid                 = $this->_dataid;
        $secretKey              = $this->_secretKey;
        $tStamp               = strval(time() - strtotime('1970-01-01 00:00:00'));
        $key = $dataid . $secretKey . $tStamp;
        if (isset($_GET['term'])) {
            // $resultold = $this->vclaim->searchDiagnosa($_GET['term']);
            // $string1 = $resultold["response"];
            // $result = json_decode($this->vclaim->stringDecrypt($key, $string1), true);

            $resultold = $this->vclaim->DIAGNOSA($_GET['term']);
            $string1 = $resultold["response"];
            $result = json_decode($this->vclaim->stringDecrypt($key, $string1), true);
            if (count($result["diagnosa"]) > 0) {
                foreach ($result["diagnosa"] as $row)
                    $arr_result[] = array(
                        'label'         => $row["nama"],
                        'description'   => $row["kode"],
                        'message'       => $resultold["metaData"]["message"],
                        'error' => 0
                    );
                echo json_encode($arr_result);
            } else {
                $arr_result[] = array(
                    'error' => 1,
                    'message'       => $resultold["metaData"]["message"]
                );
                echo json_encode($arr_result);
            }
        } else {
            $arr_result = array(
                'error' => 1,
                'message'       => "Parameter kosong"
            );

            echo json_encode($arr_result);
        }
    }
}
