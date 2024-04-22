<?php

// use function GuzzleHttp\json_encode;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;

use GuzzleHttp\Promise\Promise;

use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\RequestException;

use GuzzleHttp\Promise\RejectedPromise;

defined('BASEPATH') or exit('No direct script access allowed');

class Cek extends CI_Controller
{
    private $user;
    private $_client;
    private $_url = "https://jsonplaceholder.typicode.com/";
    public function __construct()
    {
        parent::__construct();

        $this->_client = new Client();
        // load Pagination library
        $this->load->library('pagination');
        $this->load->library('pdf');
        // load URL helper
        $this->load->helper('url');
        $this->load->model('Eklaim_model', 'eklaimmodel');
        $this->load->model('Pendaftaran_model', 'pendaftaran');
        $this->load->model('Dokter_model', 'dokter');
        $this->load->helper('eklaim');
        $this->user = "9999999999";
    }



    function ASYNCAPI()
    {

        $base_uri  = "https://jsonplaceholder.typicode.com/";
        $path = 'posts';
        $client = new \GuzzleHttp\Client([
            'base_uri'          =>  $base_uri,
            'verify'            => false,
            'timeout'  => 2.0
        ]);

        // start request
        $promise = $client->getAsync($path)->then(
            function ($response) {
                // return   $response->getStatusCode() . "\n";
                // return $response->getBody();
                return $response->getBody()->getContents();
            },
            function ($exception) {
                return $exception->getMessage();
                // return ".....loading ....";
            }
        );

        // do other things

        // wait for request to finish and display its response
        $response = $promise->wait();
        echo $response;
        echo '<b>This will not wait for the previous request to finish to be displayed!</b> <br>';
    }

    function ASYNCARRAY()
    {

        // $source = \Rx\Observable::fromArray([1, 2, 3, 4]);
        $datat = $this->pendaftaran->get_pendaftaran_list(100, 0, null);
        $source = \Rx\Observable::fromArray($datat);
        // $data["pendaftaran"] = array("a" => "red", "b" => "green");

        $a = array("red", "green");
        // array_push($a, "blue", "yellow");

        $subscription = $source->subscribe(new \Rx\Observer\CallbackObserver(
            function ($x) {
                array_push($a, $x["IDXDAFTAR"]);
                // echo 'Next: ', $x["KDDOKTER"], PHP_EOL;
                // $data["pendaftaran"][$x["IDXDAFTAR"]] = $x["IDXDAFTAR"]
                // $result = array_merge($x)

                // array_push($result, array($x));
                // $swwswsws["pendaftaran"] = $x;
                //  array_push($swwswsws, $x["IDXDAFTAR"]);
                // array_merge($result, $x);
                // this->array_push_assoc($result, $x);
                // $this->array_push_assoc();
            },
            function (Exception $ex) {
                echo 'Error: ', $ex->getMessage(), PHP_EOL;
                // echo 'Error: ', $ex->getMessage(), PHP_EOL;
                // $data["error"] = $ex->getMessage();
            },
            function () {
                echo 'Completed', PHP_EOL;
                // $data["isComplete"] = "complete";
            }
        ));

        // echo "jalan... <br>";
        // echo "jalan... <br>";
        // echo "jalan... <br>";
        echo "<pre>";
        print_r($a);
        echo "</pre>";
        // echo "jalan... <br>";
        // echo "jalan... <br>";
        // echo "jalan... <br>";
        // echo "jalan... <br>";
        // echo "jalan... <br>";

        // $data["title"] = "Judul";
        // $data["jalan"] = "Jalan";

        // $this->load->view('cek/cek', $data);

        // print_r($source);
    }

    function array_push_assoc($array, $key, $value)
    {
        $array[$key] = $value;
        return $array;
    }



    function cekKlaim()
    {
        $ws_query["nomor_kartu"] = "0002737829463";
        $ws_query["nomor_sep"] = "1111R0100120V009935";
        $ws_query["nomor_rm"] =  "242273";
        $ws_query["nama_pasien"] =  "NURIYAH, Ny";
        $ws_query["tgl_lahir"] =  "	1972-08-17";
        $ws_query["gender"] = "2"; // 1 = Laki-laki, 2 = Perempuan 2
        return $ws_query;
    }
    function cekKlaimBaru($data)
    {
        $ws_query["nomor_kartu"] = $data["nomor_kartu"];
        $ws_query["nomor_sep"] = $data["nomor_sep"];
        $ws_query["nomor_rm"] =  $data["nomor_rm"];
        $ws_query["nama_pasien"] = $data["nama_pasien"];
        $ws_query["tgl_lahir"] =  $data["tgl_lahir"];
        $ws_query["gender"] = $data["gender"];

        $bridging = $this->eklaimmodel->newClaim($ws_query);

        if ($bridging["metadata"]["code"] != 200) {
            $bridging = $this->eklaimmodel->update_patient($ws_query);
        }
        return json_encode($bridging);
    }

    function brigingKlaim()
    {
        $data = $this->cekKlaim();
        $brging = $this->cekKlaimBaru($data);
        echo  $brging;
    }
    function set_claim_data()
    {
        $ws_query["nomor_kartu"] = "0002737829463";
        $ws_query["nomor_sep"] = "1111R0100120V009935";
        $ws_query["tgl_masuk"] = "2020-01-30 03:44:40";
        $ws_query["tgl_pulang"] = "2020-01-30 03:44:40";
        $ws_query["jenis_rawat"] = "2";  //1 = rawat inap, 2 = rawat jalan 

        $ws_query["penunjang"] = "500";
        $ws_query["coder_nik"] =  $this->user;

        $bridging = $this->eklaimmodel->setClaim($ws_query);

        echo  json_encode($bridging);
    }

    function send_claim_collective()
    {

        $ws_query["start_dt"] = "2020-01-01";
        $ws_query["stop_dt"] = "2020-01-31";

        $ws_query["jenis_rawat"] = "2";
        $ws_query["date_type"] = "1";  //1 = tanggal pulang, 2 = tanggal grouping, default = 1 

        $bridging = $this->eklaimmodel->send_claim_collective($ws_query);

        echo  json_encode($bridging);
    }

    function send_claim_individual()
    {
        $ws_query["nomor_sep"] = "1111R0100120V000404";
        $bridging = $this->eklaimmodel->send_claim_individual($ws_query);
        echo  json_encode($bridging);
    }

    function get_claim_data()
    {
        $ws_query["nomor_sep"] = "1111R0100120V000404";
        $bridging = $this->eklaimmodel->get_claim_data($ws_query);
        echo  json_encode($bridging);
    }


    function diagnosis()
    {
        $ws_query["keyword"] = "corona";
        $bridging = $this->eklaimmodel->diagnosis($ws_query);
        echo  json_encode($bridging);
    }

    function tindakan($keyword)
    {
        $ws_query["keyword"] = $keyword;
        $bridging = $this->eklaimmodel->search_procedures($ws_query);
        echo  json_encode($bridging);
    }




    function cobacetak()
    {
        $pdf = new FPDF('l', 'mm', 'A5');
        // membuat halaman baru
        $pdf->AddPage();
        // setting jenis font yang akan digunakan
        $pdf->SetFont('Arial', 'B', 16);
        // mencetak string 
        $pdf->Cell(190, 7, 'JUDUL', 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(190, 7, 'SUBJUDUL', 0, 1, 'C');
        // Memberikan space kebawah agar tidak terlalu rapat
        $pdf->Cell(10, 7, '', 0, 1);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(20, 6, 'NIM', 1, 0);
        $pdf->Cell(85, 6, 'NAMA MAHASISWA', 1, 0);
        $pdf->Cell(27, 6, 'NO HP', 1, 0);
        $pdf->Cell(25, 6, 'TANGGAL LHR', 1, 1);
        $pdf->SetFont('Arial', '', 10);
        $mahasiswa = $this->dokter->getlistDokter();
        foreach ($mahasiswa as $row) {
            $pdf->Cell(20, 6, $row["KDDOKTER"], 1, 0);
            $pdf->Cell(85, 6, $row["NAMADOKTER"], 1, 0);
            $pdf->Cell(27, 6, $row["SIP"], 1, 0);
            $pdf->Cell(25, 6, "", 1, 1);
        }

        $pdf->Output();
    }

    function generatePDF()
    {
        $data['title'] = "OK";
        $this->load->library('pdfgenerator');
        $html = $this->load->view('blog_template', $data, true);
        $this->pdfgenerator->generate($html, "contoh");
    }
}
