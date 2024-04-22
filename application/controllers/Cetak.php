<?php

use function GuzzleHttp\json_decode;

defined('BASEPATH') or exit('No direct script access allowed');


use Dompdf\Options;

class Cetak extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('wpu');
        $this->load->helper('pendaftaran');
        $this->load->model('Poli_model', 'poli');
        $this->load->model('Carabayar_model', 'carabayar');
        $this->load->model('Pasien_model', 'pasien');
        $this->load->model('Pendaftaran_model', 'pendaftaran');
        $this->load->model('Sep_model', 'seplokal');
        $this->load->model('Vclaim_model', 'vclaim');
        $this->load->model('Admission_model', 'admission');
        $this->load->helper('user');
        $this->load->helper('pendaftaran');
    }

    public function index()
    {
        redirect(base_url());
    }

    public function printPDF()
    {

        $idx = '500234';
        $nomr = '066597';

        $data["spri"] = $this->poli->getSPRI($idx);
        $data["pasien"] = $this->pasien->getDetailsPasien($nomr);



        $mpdf = new \Mpdf\Mpdf();
        $data = $this->load->view('crud_view', $data, true);
        $mpdf->WriteHTML($data);
        $mpdf->Output();
    }
    public function tandabuktiPendaftaran()
    {
        $mpdf = new \Mpdf\Mpdf();
        $data = $this->load->view('cetak/tandabuktipendaftaranpasien', [], true);
        $mpdf->WriteHTML($data);
        $mpdf->Output();
    }

    public function labelidentitasPasien($nomr)
    {
        /*$data['title'] = "Cetak Label Identitas Pasien";
        $this->load->model('Pasien_model', 'pasien');
		
		$data['pasien'] =  $this->pasien->getDetailsPasien($nomr);
        $data['idx'] =  $nomr;
		
		
        $this->load->library('pdf');
        $this->pdf->setPaper('A4', 'potrait');
		$this->pdf->set_option('defaultMediaType', 'all');
		//$this->pdf->setDefaultFont('Courier');
		$this->pdf->set_option('isFontSubsettingEnabled', true);
        // $this->pdf->setOptions($options);
        $this->pdf->filename = "Label Identitas Pasien";
        $this->pdf->load_view('cetak/cetakLabel', $data);*/


        $data['title'] = "Cetak Label Identitas Pasien";
        $this->load->model('Pasien_model', 'pasien');

        $mpdf = new \Mpdf\Mpdf([
            'format' => [60, 25],
            'mode' => 'utf-8',
            'default_font_size' => 10,

            'margin_left' => 4,
            'margin_right' => 0,
            'margin_top' => 1,
            'margin_bottom' => 0,
            'orientation' => 'P',
            'default_font' => 'calibri'
        ]);

        $data['pasien'] =  $this->pasien->getDetailsPasien($nomr);
        $data['idx'] =  $nomr;

        $html = '<!--mpdf
        
                <ul class="b">
                    <li>NOMR : <strong>' . $data['pasien']["NOMR"] . '</strong></li>
                    <li>NAMA : <strong>' . $data['pasien']["NAMA"] . '</strong></li>
                    <li>TGL.LHR : <strong>' . $data['pasien']["TGLLAHIR"] . '</strong></li>
                </ul>
        
        mpdf-->
        
        <style>
            ul.b {
                list-style-type: square;
                margin: 1;
                padding: 5;
            }
        </style>
        ';


        $mpdf->useSubstitutions = false;
        $mpdf->simpleTables = true;
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }

    public function labelgelangPasien($nomr)
    {
        $data['title'] = "Cetak Label Gelang Pasien";
        $this->load->model('Pasien_model', 'pasien');

        $this->load->library('pdf');

        $data["pasien"] =  $this->pasien->getDetailsPasien($nomr);
        $paper_size = array(0, 0, 2.36 * 72, 2.95 * 72);
        $this->pdf->setPaper($paper_size, 'potrait');
        $this->pdf->filename = "Gelang Pasien";
        $this->pdf->load_view('cetak/gelangPasien', $data);
    }


    public function tandabuktipendaftaranrajal($idx)
    {
        $data['title'] = "Tanda Bukti Pendaftaran Rawat Jalan";
        $this->load->model('Pendaftaran_model', 'pendaftaran');
        $user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['pendaftaran'] =  $this->pendaftaran->getDetailPendaftaranRajal($idx);
        $data['idx'] =  $idx;

        if ($data["pendaftaran"]['KDCARABAYAR'] > 1) {
            $data["nomer_kartu"] = getDetailPasien($data["pendaftaran"]["NOMR"], "NO_KARTU");
        } else {
            $data["nomer_kartu"] = "";
        }

        if ($data["pendaftaran"]['KDCARABAYAR'] > 1) {
            $data["asal_faskes"] = "   asal faskes";
        } else {
            $data["asal_faskes"]  = "";
        }

        $this->load->library('pdf');
        $this->pdf->setPaper('A4', 'potrait');
        $this->pdf->filename = "Label Identitas Pasien";
        $this->pdf->load_view('cetak/buktipendaftaranrajal', $data);
    }

    public function cetakLHK()
    {
        $data['title'] = "Cetak Surat Elegibilitas Peserta ";
        print_r($data['title']);
        // $xs = "window.print()";

        // $mpdf = new \Mpdf\Mpdf([
        //     'format' => [210, 148],
        //     'mode' => 'utf-8',
        //     'orientation' => 'P',
        //     'default_font_size' => 12,
        //     'margin_left' => 5,
        //     'margin_right' => 5,
        //     'margin_top' => 7,
        //     'margin_bottom' => 5,
        //     'default_font' => 'ubuntu'
        // ]);

        // $cetakSEPPasien = '<!--mpdf
        
        //             <table width="100%" style="border:0;" cellpadding="0">
        //             <tbody>
        //                 <tr>
        //                     <td width="14%" rowspan="2" style="text-align:left;" vtext-align="top"><img src="logobpjs.png" width="200" height="50" alt="" /></td>
        //                     <td width="3%" height="20">&nbsp;</td>
        //                     <td width="79%"><span class="header"><strong>PEMERINTAH KABUPATEN BANYUMAS

        //                                 <br>RUMAH SAKIT UMUM DAERAH AJIBARANG                                                                               
        //                                 <br>LAPORAN HASIL KERJA PEGAWAI NON PNS                                                                                                                                     
        //                             </strong></span></td>
        //                     <td width="4%">&nbsp;</td>
        //                 </tr>
        //                 <tr>
        //                     <td height="20">&nbsp;</td>
        //                     <td style="text-align:left;" vtext-align="top"></td>
        //                     <td>&nbsp;</td>
        //                 </tr>
        //             </tbody>




        //             </table>

    

        // mpdf--> ';

        // $mpdf->SetFooter($footer);
        // $mpdf->SetBasePath(IMAGE_BASE_URL);
        // $mpdf->WriteHTML($cetakSEPPasien);
        // $mpdf->SetJS($xs);
        // $mpdf->SetDisplayMode(93);
        // $mpdf->useSubstitutions = false;
        // $mpdf->simpleTables = true;

        // $mpdf->Output("LHK.pdf", "i");
    }

    public function cetakSEP($jenislayanan = null, $nosep, $idx)
    {

        $data['title'] = "Cetak Surat Elegibilitas Peserta ";
        $xs = "window.print()";
        $data["user"] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data["sep"] = $this->vclaim->detailSEP($nosep);

        if ($jenislayanan == 2) {

            $data["pendaftaran"] =  $this->pendaftaran->getDetailPendaftaranRajal($idx);
            $data["seplokal"] = $this->seplokal->getDetailSEPbyIDX($jenislayanan, $idx);
        }

        if ($data["sep"]["response"]["peserta"]["noKartu"]) {
            if ($jenislayanan == 2) {
                $data["peserta"] = $this->vclaim->detailKepesertaan(2, $data["sep"]["response"]["peserta"]["noKartu"]);
            }
        }

        if ($data["sep"]["response"]["noRujukan"]) {

            if (strlen($data["sep"]["response"]["noRujukan"]) > 12) {

                $rujukan = $this->vclaim->cariRujukanByNorujukan(1, $data["sep"]["response"]["noRujukan"]);

                if ($rujukan["response"] != null) {
                    $data["rujukan"] =  $rujukan;
                } else {
                    $data["rujukan"] = $this->vclaim->cariRujukanByNorujukan(2, $data["sep"]["response"]["noRujukan"]);
                }
            }
        }

        if ($jenislayanan == 2) {
            $data["petugascetak"] = $data["user"]["firstname"] . " " . $data["user"]["lastname"];
        }

        date_default_timezone_set('Asia/Jakarta');
        $footer = "dicetak oleh " . $data["user"]["firstname"] . "  " . $data["user"]["lastname"] . "    " . date("Y-m-d H:i:s") . " - SIM RSUD Ajibarang";




        $mpdf = new \Mpdf\Mpdf([
            'format' => [210, 148],
            'mode' => 'utf-8',
            'orientation' => 'P',
            'default_font_size' => 12,
            'margin_left' => 5,
            'margin_right' => 5,
            'margin_top' => 7,
            'margin_bottom' => 5,
            'default_font' => 'ubuntu'
        ]);





        $cetakSEPPasien = '<!--mpdf
        
                    <table width="100%" style="border:0;" cellpadding="0">
                    <tbody>
                        <tr>
                            <td width="14%" rowspan="2" style="text-align:left;" vtext-align="top"><img src="logobpjs.png" width="200" height="50" alt="" /></td>
                            <td width="3%" height="20">&nbsp;</td>
                            <td width="79%"><span class="header"><strong>SURAT ELEGIBILITAS PESERTA

                                        <br>RSUD AJIBARANG
                                    </strong></span></td>
                            <td width="4%">&nbsp;</td>
                        </tr>
                        <tr>
                            <td height="20">&nbsp;</td>
                            <td style="text-align:left;" vtext-align="top"></td>
                            <td>&nbsp;</td>
                        </tr>
                    </tbody>




                    </table>

    

        mpdf--> ';
        if ($data["sep"]["metaData"]["code"] == 200) {
            $cetakSEPPasien .= '
                        <table width="100%" style="border:0;" cellspacing="4px" cellpadding="0">
                        <tbody>
                            <tr>
                                <td width="19%" style="text-align:left;" vtext-align="bottom">No.SEP</td>
                                <td width="1%" style="text-align:left;" vtext-align="bottom">:</td>
                                <td style="text-align:left;" vtext-align="bottom">
                                    <span class="fontNoSEP">&nbsp;' . $data["sep"]["response"]["noSep"] . '</span> </td>
                                <td style="text-align:left;" vtext-align="bottom">&nbsp;</td>
                                <td style="text-align:left;" vtext-align="bottom">&nbsp;</td>
                                <td style="text-align:left;" vtext-align="bottom">&nbsp;<strong>' . $data["peserta"]["response"]["peserta"]["informasi"]["prolanisPRB"] . '</strong></td>
                            </tr>
                            <tr>
                                <td style="text-align:left;" vtext-align="top">Tgl.SEP</td>
                                <td style="text-align:left;" vtext-align="top">:</td>
                                <td width="40%" style="text-align:left;" vtext-align="top">&nbsp;' . $data["sep"]["response"]["tglSep"] . '</td>
                                <td width="15%" style="text-align:left;" vtext-align="top">Peserta</td>
                                <td width="1%" style="text-align:left;" vtext-align="top">:</td>
                                <td width="35%" style="text-align:left;" vtext-align="top">&nbsp;' . $data["sep"]["response"]["peserta"]["jnsPeserta"] . '</td>
                            </tr>
                            <tr>
                                <td style="text-align:left;" vtext-align="top">No.Kartu</td>
                                <td style="text-align:left;" vtext-align="top">:</td>
                                <td style="text-align:left;" vtext-align="top">&nbsp;' . $data["sep"]["response"]["peserta"]["noKartu"] . ' ( ' . $data["sep"]["response"]["peserta"]["noMr"] . ')</td>
                                <td style="text-align:left;" vtext-align="top">COB</td>
                                <td style="text-align:left;" vtext-align="top">:</td>
                                <td style="text-align:left;" vtext-align="top">&nbsp;' . $data["sep"]["response"]["peserta"]["asuransi"] . '</td>
                            </tr>
                            <tr>
                                <td style="text-align:left;" vtext-align="top">Nama Peserta</td>
                                <td style="text-align:left;" vtext-align="top">:</td>
                                <td style="text-align:left;" vtext-align="top">&nbsp;' . $data["sep"]["response"]["peserta"]["nama"] . ', (' . $data["sep"]["response"]["peserta"]["kelamin"] . ')</td>
                                <td style="text-align:left;" vtext-align="top">Jns.Rawat</td>
                                <td style="text-align:left;" vtext-align="top">:</td>
                                <td style="text-align:left;" vtext-align="top">&nbsp;' . $data["sep"]["response"]["jnsPelayanan"] . '</td>
                            </tr>
                            <tr>
                                <td style="text-align:left;" vtext-align="top">Tgl.Lahir</td>
                                <td style="text-align:left;" vtext-align="top">:</td>
                                <td style="text-align:left;" vtext-align="top">&nbsp;' . $data["sep"]["response"]["peserta"]["tglLahir"] . '</td>
                                <td style="text-align:left;" vtext-align="top">Kls.Rawat</td>
                                <td style="text-align:left;" vtext-align="top">:</td>
                                <td style="text-align:left;" vtext-align="top">&nbsp;' . $data["sep"]["response"]["peserta"]["hakKelas"] . '</td>
                            </tr>
                            <tr>
                                <td style="text-align:left;" vtext-align="top">No.Telepon</td>
                                <td style="text-align:left;" vtext-align="top">:</td>
                                <td style="text-align:left;" vtext-align="top">&nbsp;' . $data["peserta"]["response"]["peserta"]["mr"]["noTelepon"] . '</td>
                                <td style="text-align:left;" vtext-align="top">Penjamin</td>
                                <td style="text-align:left;" vtext-align="top">:</td>
                                <td style="text-align:left;" vtext-align="top">&nbsp;' . $data["sep"]["response"]["penjamin"] . '</td>
                            </tr>
                            <tr>
                                <td style="text-align:left;" vtext-align="top">Sub/Spesialis</td>
                                <td style="text-align:left;" vtext-align="top">:</td>
                                <td style="text-align:left;" vtext-align="top">&nbsp;' . $data["sep"]["response"]["poli"] . ', ' . $data["sep"]["response"]["poliEksekutif"] . '</td>
                                <td style="text-align:left;" vtext-align="top">No.Rujukan</td>
                                <td style="text-align:left;" vtext-align="top">:</td>
                                <td style="text-align:left;" vtext-align="top">&nbsp;' . $data["sep"]["response"]["noRujukan"] . '</td>
                            </tr>
                            <tr>
                                <td style="text-align:left;" vtext-align="top">FaskesPerujuk</td>
                                <td style="text-align:left;" vtext-align="top">:</td>
                                <td style="text-align:left;" vtext-align="top">&nbsp;' . $data["peserta"]["response"]["peserta"]["provUmum"]["kdProvider"] . '/' . $data["peserta"]["response"]["peserta"]["provUmum"]["nmProvider"] . '</td>
                                <td style="text-align:left;" vtext-align="top">&nbsp;</td>
                                <td>&nbsp;</td>
                                <td style="text-align:left;" vtext-align="top">&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="text-align:left;" vtext-align="top">Diagnosa Awal</td>
                                <td style="text-align:left;" vtext-align="top">:</td>
                                <td colspan="2" style="text-align:left;" vtext-align="top">&nbsp;' . $data["sep"]["response"]["diagnosa"] . '</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="text-align:left;" vtext-align="top">Catatan</td>
                                <td style="text-align:left;" vtext-align="top">:</td>
                                <td colspan="2" style="text-align:left;" vtext-align="top">&nbsp;' . $data["sep"]["response"]["catatan"] . '</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                        </tbody>
                    </table>';
        } else {
            $cetakSEPPasien .= '<h1>' . $data["sep"]["metaData"]["message"] . '</h1>';
        }


        $cetakSEPPasien .= '<table width="100%" style="border:0;" cellspacing="5px" cellpadding="0">
                    <tbody>
                        <tr>
                            <td width="72%">
                                <p class="style11">*Saya Menyetujui BPJS Kesehatan menggunakan informasi Medis Pasien jika diperlukan
                                    <br>*SEP bukan sebagai bukti penjamin peserta . ';

        if ($data["rujukan"]["response"] != null) {
            $cetakSEPPasien .= ' <br> <h2>tgl berlaku rujukan ' . $data["rujukan"]["response"]["rujukan"]["tglKunjungan"] . '  - s/d -';
            $cetakSEPPasien .= ' ' . date('Y-m-d', strtotime($data["rujukan"]["response"]["rujukan"]["tglKunjungan"] . ' + 88 days')) . '</h2>';
        }

        $cetakSEPPasien .= '<br>Cetakan Ke 1
                                    <br>Dibuat Pertama Oleh:


                                </p>
                            </td>
                            <td width="1%">&nbsp;</td>
                            <td width="27%"><span class="style11">Pasien/Keluarga Pasien</span></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td><span class="style11">' . $data["seplokal"]["user"] . '</span></td>
                            <td>&nbsp;</td>
                            <td><span class="style12"><span class="style11">' . $data["pendaftaran"]["PENANGGUNGJAWAB_NAMA"] . '</span></span></td>
                        </tr>
                    </tbody>
                </table>';


        $cetakSEPPasien .= '
                        <style>
                        @page {
                            /* size: 21cm 14cm;
                            margin: 20px; */
                        }

                        body {
                            /* margin: 10px; */
                            font-family: "Courier";
                            font-size: 16px;
                        }

                        .style11 {
                            font-size: 10px;
                        }

                        .fontNoSEP {
                            font-size: 23px;
                            font-weight: bold;
                        }

                        .header {
                            font-size: 20px;
                            font-weight: bold;
                        }
                        </style>
                        ';



        $mpdf->SetFooter($footer);
        $mpdf->SetBasePath(IMAGE_BASE_URL);
        //$mypdf = $this->load->view('cetak/sep', $data, true);
        // $html = '<img src="logobpjs.png" width="200" height="50" alt="" />';
        $mpdf->WriteHTML($cetakSEPPasien);
        $mpdf->SetJS($xs);
        $mpdf->SetDisplayMode(93);
        $mpdf->useSubstitutions = false;
        $mpdf->simpleTables = true;

        $mpdf->Output("SEP.pdf", "i");
    }



    public function cetakSPRI_old($idx, $nokaBPJS, $nomr)
    {
        $data['title'] = "Surat Perintah Rawat Inap";


        // $mpdf = new \Mpdf\Mpdf([
        //     'format'        => [210, 160],
        //     'mode'          => 'utf-8',
        //     'orientation'   => 'P',

        //     'margin_top' => 5,
        //     'margin_left' => 5,
        //     'margin_right' => 5,


        //     'default_font_size' => 10,
        //     'default_font' => 'Times New Roman'
        // ]);

        $data['idx'] = $this->uri->segment(3);
        $data['nomr'] = $this->uri->segment(4);
        $data['nospri'] = $this->uri->segment(5);

        $data["spri"] = $this->poli->getSPRI($data['idx']);
        $data["pasien"] = $this->pasien->getDetailsPasien($data['nomr']);

        date_default_timezone_set('UTC');

        $dataid                 = $this->_dataid;
        $secretKey              = $this->_secretKey;
        $tStamp               = strval(time() - strtotime('1970-01-01 00:00:00'));
        $key = $dataid . $secretKey . $tStamp;
        $data['noKartu'] = $nokaBPJS;
        $data['nomr'] = $nomr;
        $data['idx'] = $idx;

        $str=date('Y-m-d');
        $explode=explode("-",$str);  

        $bulan = $explode[1];
        $tahun = $explode[0];


        $data["js_arr_foot"] = array("controllers/rekammedis/formPasienPulangbpjsSet.js");
        $data["listSPRI"] = $this->vclaim->ListRencanaKontrol($bulan, $tahun, $nokaBPJS);
        $stringhistory = $data["listSPRI"]["response"];
        $data["listSPRINew"] = json_decode($this->vclaim->stringDecrypt($key, $stringhistory), true);

        print_r($data["listSPRINew"]);
        die();

        // $mypdf = $this->load->view('cetak/spri', $data, true);
        // $mpdf->WriteHTML($mypdf);
        // $mpdf->Output();
    }

    public function cetakSPRI($idx, $nokaBPJS, $nomr, $noSuratKontrol, $tglRencanaKontrol, $tglTerbitKontrol, $kodeDokter)
    {
        $data['title'] = "Surat Perintah Rawat Inap";

        $data['noKartu'] = $nokaBPJS;
        $data['nomr'] = $nomr;
        $data['idx'] = $idx;
        $data['noSuratKontrol'] = $noSuratKontrol;
        $data['tglRencanaKontrol'] = $tglRencanaKontrol;
        $data['tglTerbitKontrol'] = $tglTerbitKontrol;
        $data['kodeDokter'] = $kodeDokter;
        $mpdf = new \Mpdf\Mpdf([
            'format' => [210, 148],
                'mode' => 'utf-8',
                'orientation' => 'P',
                'default_font_size' => 12,
                'margin_left' => 5,
                'margin_right' => 5,
                'margin_top' => 7,
                'margin_bottom' => 5,
                'default_font' => 'ubuntu'
        ]);

        // $data["spri"] = $this->poli->getSPRI($data['idx']);
        $data["pasien"] = $this->pasien->getDetailsPasien($data['nomr']);


        $data["js_arr_foot"] = array("controllers/rekammedis/formPasienPulangbpjsSet.js");
        // die();

        $mypdf = $this->load->view('cetak/cetakspri', $data, true);
        $mpdf->WriteHTML($mypdf);
        $mpdf->Output();
    }



    function outpatientCensus($tanggal)
    {

        $data["title"] = "Judul";
        $data["tanggal"] = $tanggal;

        $date = $tanggal;
        $queryMenu = "SELECT distinct(KDPOLY),a.TGLREG FROM vw_sensus_harian_rawat_jalan a  where a.TGLREG = '" . $date . "' and a.KDPOLY NOT in (8,9,10,11,17,34,16,40,42)  ";


        $poli = $this->db->query($queryMenu)->result_array();

        $carabayar = $this->carabayar->getCarabayar();



        $mpdf = new \Mpdf\Mpdf([
            'format' => 'A4',
            'mode' => 'utf-8',
            'orientation' => 'L',
            'default_font_size' => 9,
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 10,
            'margin_bottom' => 3,
            'default_font' => 'Courier',
            'falseBoldWeight' => 0
        ]);



        $xs = "window.print()";
        $cssipun = "<style>

        .pagebreak { 
    		page-break-before: always; 
    	}

        </style>";

        $mpdf->SetBasePath(IMAGE_BASE_URL);
        $html = "";

        foreach ($poli as $p) {
            $html .= "Kunjungan Pasien Poli " . getNamaPoliKlinik($p["KDPOLY"]) . "   " . $date . "";

            $html .= '<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">';
            $html .= '<tr>
                        <td>&nbsp;No&nbsp;</td>
                        <td>&nbsp;NO SEP </td>
                        <td>&nbsp;NOMR</td>
                        <td width="22%">&nbsp;&nbsp;&nbsp;NAMA&nbsp;&nbsp;&nbsp;</td>
                        <td>&nbsp;CARA BAYAR </td>
                        <td>&nbsp;B/L</td>
                        <td>&nbsp;DOKTER</td>
                        <td>&nbsp;RANAP</td>
                        <td>&nbsp;PULANG</td>
                    </tr>';

            $query2 = 'SELECT a.NOMR,a.IDXDAFTAR,
    					a.TGLREG,
    					b.NAMADOKTER,
    					c.nama,
    					d.NAMA as "rujukan",
    					e.NAMA as "CARABAYAR",
    					a.SHIFT,
    					f.pasienbaru,
    					g.NAMA,
    					g.ALAMAT,
    					g.JENISKELAMIN,
    					a.KETRUJUK,
    					a.NO_SJP,
    					a.PASIENBARU
    					FROM vw_sensus_harian_rawat_jalan a 
    					LEFT OUTER JOIN m_dokter b ON (a.KDDOKTER = b.KDDOKTER)
    					LEFT OUTER JOIN m_poly c ON (a.KDPOLY = c.kode)
    					LEFT OUTER JOIN m_rujukan d ON (a.KDRUJUK= d.KODE)
    					LEFT OUTER JOIN m_carabayar e ON (a.KDCARABAYAR = e.KODE)
    					LEFT OUTER JOIN l_pasienbaru f ON (a.PASIENBARU=f.id)
    					LEFT OUTER JOIN m_pasien g ON (a.NOMR = g.NOMR)
    					where a.TGLREG = "' . $date . '" AND a.KDPOLY = ' . $p["KDPOLY"] . '
                        group by NOMR ORDER BY g.NAMA ASC,b.NAMADOKTER ASC';

            $data = $this->db->query($query2)->result_array();
            $no_urut2 = 1;
            foreach ($data as $d) {
                $html .= "<tr>";
                $html .= "<td>&nbsp;&nbsp;" . $no_urut2 . "&nbsp;&nbsp;</td>";
                $html .= "<td>&nbsp;&nbsp;" . getDetailSepByIDXandType(2, $d["IDXDAFTAR"], "nomer_sep") . "&nbsp;&nbsp;</td>";
                // $html .= "<td>&nbsp;&nbsp;" . $d["NO_SJP"] . "&nbsp;&nbsp;</td>";
                $html .= "<td>&nbsp;&nbsp;" . $d["NOMR"] . "&nbsp;&nbsp;</td>";
                $html .= "<td>&nbsp;" . $d["NAMA"] . " </td>";
                $html .= "<td>&nbsp;" . $d["CARABAYAR"] . "&nbsp;</td>";
                $html .= "<td>&nbsp;&nbsp;" . pasienBaru($d["PASIENBARU"]) . "&nbsp;&nbsp;</td>";
                $html .= "<td>&nbsp;&nbsp;" . $d["NAMADOKTER"] . "&nbsp;&nbsp;</td>";
                $html .= "<td>&nbsp;&nbsp;&nbsp;</td>";
                $html .= "<td>&nbsp;&nbsp;&nbsp;</td>";
                $html .= "</tr>";

                $no_urut2++;
            }

            $html .= '</table>';
            $html .= '<br>';

            $html .= "- Ringkasan --";

            $html .= '<table width="70%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">';
            $html .= '<tr>';
            $html .= '<tr align="center" valign="top">';
            $html .= '<td colspan="2">&nbsp;Poli: ' . getNamaPoliKlinik($p["KDPOLY"]) . '/' . $date . '</td>';
            $html .= '<td>Total</td>';
            $html .= '<td>Pasien Baru</td>';
            $html .= '<td>Pasien Lama</td>';
            $html .= '</tr>';


            $html .= "<tr>";
            $html .= '<td width="31%">&nbsp;Jumlah Pasien</td>';
            $html .= '<td width="3%">:</td>';
            $html .= '<td width="20%">&nbsp;&nbsp;' . getJumlahTotalPasien($p["KDPOLY"], $date, null, null) . '&nbsp;&nbsp;</td>';
            $html .= '<td width="24%">&nbsp;&nbsp;' . getJumlahTotalPasien($p["KDPOLY"], $date, null, 1) . '&nbsp;&nbsp;</td>';
            $html .= '<td width="22%">&nbsp;&nbsp;' . getJumlahTotalPasien($p["KDPOLY"], $date, null, 0) . '&nbsp;&nbsp;</td>';
            $html .= "</tr>";


            foreach ($carabayar as $cb) {
                $html .= "<tr>";
                $html .= '<td width="31%">&nbsp;' . $cb["NAMA"] . '</td>';
                $html .= '<td width="3%">:</td>';
                $html .= '<td width="20%">&nbsp;&nbsp;' . getJumlahTotalPasien($p["KDPOLY"], $date,  $cb["KODE"], null) . '&nbsp;&nbsp;</td>';
                $html .= '<td width="24%">&nbsp;&nbsp;' . getJumlahTotalPasien($p["KDPOLY"], $date,  $cb["KODE"], 1) . '&nbsp;&nbsp;</td>';
                $html .= '<td width="22%">&nbsp;&nbsp;' . getJumlahTotalPasien($p["KDPOLY"], $date,  $cb["KODE"], 0) . '&nbsp;&nbsp;</td>';
                $html .= "</tr>";
            }



            $html .= '</table>';

            $html .= '<div class="pagebreak"> </div>';
        }


        $mpdf->WriteHTML($cssipun);
        $mpdf->WriteHTML($html);
        $mpdf->SetJS($xs);
        $mpdf->SetDisplayMode(93);
        $mpdf->useSubstitutions = false;
        $mpdf->simpleTables = true;
        $mpdf->Output("SENSUS RAWAT JALAN.pdf", "i");
    }



    public function cetakSEPBaru($layanan = null, $nosep, $idx)
    {
        $jenislayanan = base64_decode($layanan);
        $xs = "window.print()";
        $data["user"] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data["sep"] = $this->vclaim->detailSEP(base64_decode($nosep));

        if ($jenislayanan == 2) {

            $data["pendaftaran"] =  $this->pendaftaran->getDetailPendaftaranRajal(base64_decode($idx));
            $data["seplokal"] = $this->seplokal->getDetailSEPbyIDX($jenislayanan, base64_decode($idx));
        }

        if ($data["sep"]["response"]["peserta"]["noKartu"]) {
            if ($jenislayanan == 2) {
                $data["peserta"] = $this->vclaim->detailKepesertaan(2, $data["sep"]["response"]["peserta"]["noKartu"]);
            }
        }

        if ($data["sep"]["response"]["noRujukan"]) {

            if (strlen($data["sep"]["response"]["noRujukan"]) > 12) {

                $rujukan = $this->vclaim->cariRujukanByNorujukan(1, $data["sep"]["response"]["noRujukan"]);

                if ($rujukan["response"] != null) {
                    $data["rujukan"] =  $rujukan;
                } else {
                    $data["rujukan"] = $this->vclaim->cariRujukanByNorujukan(2, $data["sep"]["response"]["noRujukan"]);
                }
            }
        }

        if ($jenislayanan == 2) {
            $data["petugascetak"] = $data["user"]["firstname"] . " " . $data["user"]["lastname"];
        }

        date_default_timezone_set('Asia/Jakarta');
        $footer = "dicetak oleh " . $data["user"]["firstname"] . "  " . $data["user"]["lastname"] . "    " . date("Y-m-d H:i:s") . " - SIM RSUD Ajibarang";


        $mpdf = new \Mpdf\Mpdf([
            'format' => [210, 148],
            'mode' => 'utf-8',
            'orientation' => 'P',
            'default_font_size' => 12,
            'margin_left' => 5,
            'margin_right' => 5,
            'margin_top' => 7,
            // 'margin_bottom' => 5,
            'margin_footer' => 1,
            'default_font' => 'ubuntu'
        ]);





        $cetakSEPPasien = '<!--mpdf
        
                    <table width="100%" style="border:0;" cellpadding="0">
                    <tbody>
                        <tr>
                            <td width="14%" rowspan="2" style="text-align:left;" vtext-align="top"><img src="logobpjs.png" width="200" height="50" alt="" /></td>
                            <td width="3%" height="20">&nbsp;</td>
                            <td width="79%"><span class="header"><strong>SURAT ELEGIBILITAS PESERTA

                                        <br>RSUD AJIBARANG
                                    </strong></span></td>
                            <td width="4%">&nbsp;</td>
                        </tr>
                        <tr>
                            <td height="20">&nbsp;</td>
                            <td style="text-align:left;" vtext-align="top"></td>
                            <td>&nbsp;</td>
                        </tr>
                    </tbody>




                    </table>

    

        mpdf--> ';
        $cetakTgl  = "";
        if ($data["rujukan"]["response"] != null) {
            $cetakTgl .= '  tgl berlaku rujukan <b>' . $data["rujukan"]["response"]["rujukan"]["tglKunjungan"] . '</b>  - s/d -';
            $cetakTgl .= '<b> ' . date('Y-m-d', strtotime($data["rujukan"]["response"]["rujukan"]["tglKunjungan"] . ' + 88 days')) . '</b>';
        }

        if ($data["sep"]["metaData"]["code"] == 200) {
            $cetakSEPPasien .= '
                        <table width="100%" style="border:0;" cellspacing="4px" cellpadding="0">
                        <tbody>
                            <tr>
                                <td width="19%" style="text-align:left;" vtext-align="bottom">No.SEP</td>
                                <td width="1%" style="text-align:left;" vtext-align="bottom">:</td>
                                <td style="text-align:left;" vtext-align="bottom">
                                    <span class="fontNoSEP">&nbsp;' . $data["sep"]["response"]["noSep"] . '</span> </td>
                                <td style="text-align:left;" vtext-align="bottom">&nbsp;</td>
                                <td style="text-align:left;" vtext-align="bottom">&nbsp;</td>
                                <td style="text-align:left;" vtext-align="bottom">&nbsp;<strong>' . $data["peserta"]["response"]["peserta"]["informasi"]["prolanisPRB"] . '</strong></td>
                            </tr>
                            <tr>
                                <td style="text-align:left;" vtext-align="top">Tgl.SEP</td>
                                <td style="text-align:left;" vtext-align="top">:</td>
                                <td width="40%" style="text-align:left;" vtext-align="top">&nbsp;' . $data["sep"]["response"]["tglSep"] . '</td>
                                <td width="15%" style="text-align:left;" vtext-align="top">Peserta</td>
                                <td width="1%" style="text-align:left;" vtext-align="top">:</td>
                                <td width="35%" style="text-align:left;" vtext-align="top">&nbsp;' . $data["sep"]["response"]["peserta"]["jnsPeserta"] . '</td>
                            </tr>
                            <tr>
                                <td style="text-align:left;" vtext-align="top">No.Kartu</td>
                                <td style="text-align:left;" vtext-align="top">:</td>
                                <td style="text-align:left;" vtext-align="top">&nbsp;' . $data["sep"]["response"]["peserta"]["noKartu"] . ' ( ' . $data["sep"]["response"]["peserta"]["noMr"] . ')</td>
                                <td style="text-align:left;" vtext-align="top">COB</td>
                                <td style="text-align:left;" vtext-align="top">:</td>
                                <td style="text-align:left;" vtext-align="top">&nbsp;' . $data["sep"]["response"]["peserta"]["asuransi"] . '</td>
                            </tr>
                            <tr>
                                <td style="text-align:left;" vtext-align="top">Nama Peserta</td>
                                <td style="text-align:left;" vtext-align="top">:</td>
                                <td style="text-align:left;" vtext-align="top">&nbsp;' . $data["sep"]["response"]["peserta"]["nama"] . ', (' . $data["sep"]["response"]["peserta"]["kelamin"] . ')</td>
                                <td style="text-align:left;" vtext-align="top">Jns.Rawat</td>
                                <td style="text-align:left;" vtext-align="top">:</td>
                                <td style="text-align:left;" vtext-align="top">&nbsp;' . $data["sep"]["response"]["jnsPelayanan"] . '</td>
                            </tr>
                            <tr>
                                <td style="text-align:left;" vtext-align="top">Tgl.Lahir</td>
                                <td style="text-align:left;" vtext-align="top">:</td>
                                <td style="text-align:left;" vtext-align="top">&nbsp;' . $data["sep"]["response"]["peserta"]["tglLahir"] . '</td>
                                <td style="text-align:left;" vtext-align="top">Kls.Rawat</td>
                                <td style="text-align:left;" vtext-align="top">:</td>
                                <td style="text-align:left;" vtext-align="top">&nbsp;' . $data["sep"]["response"]["peserta"]["hakKelas"] . '</td>
                            </tr>
                            <tr>
                                <td style="text-align:left;" vtext-align="top">No.Telepon</td>
                                <td style="text-align:left;" vtext-align="top">:</td>
                                <td style="text-align:left;" vtext-align="top">&nbsp;' . $data["peserta"]["response"]["peserta"]["mr"]["noTelepon"] . '</td>
                                <td style="text-align:left;" vtext-align="top">Penjamin</td>
                                <td style="text-align:left;" vtext-align="top">:</td>
                                <td style="text-align:left;" vtext-align="top">&nbsp;' . $data["sep"]["response"]["penjamin"] . '</td>
                            </tr>
                            <tr>
                                <td style="text-align:left;" vtext-align="top">Sub/Spesialis</td>
                                <td style="text-align:left;" vtext-align="top">:</td>
                                <td style="text-align:left;" vtext-align="top">&nbsp;' . $data["sep"]["response"]["poli"] . ', ' . $data["sep"]["response"]["poliEksekutif"] . '</td>
                                <td style="text-align:left;" vtext-align="top">No.Rujukan</td>
                                <td style="text-align:left;" vtext-align="top">:</td>
                                <td style="text-align:left;" vtext-align="top">&nbsp;' . $data["sep"]["response"]["noRujukan"] . '</td>
                            </tr>
                            <tr>
                                <td style="text-align:left;" vtext-align="top">FaskesPerujuk</td>
                                <td style="text-align:left;" vtext-align="top">:</td>
                                <td style="text-align:left;" vtext-align="top">&nbsp;' . $data["peserta"]["response"]["peserta"]["provUmum"]["kdProvider"] . '/' . $data["peserta"]["response"]["peserta"]["provUmum"]["nmProvider"] . '</td>
                                <td style="text-align:left;border:0;" colspan="3" vtext-align="top">' . $cetakTgl . '</td>
                                <td>&nbsp;</td>
                                <td style="text-align:left;" vtext-align="top">&nbsp;</td>
                            </tr>
                            <tr border="1">
                                <td style="text-align:left;" vtext-align="top">Diagnosa Awal</td>
                                <td style="text-align:left;" vtext-align="top">:</td>
                                <td colspan="4" style="text-align:left;border:0;" vtext-align="top">&nbsp;' . $data["sep"]["response"]["diagnosa"] . '</td>
                                
                            </tr>
                            <tr>
                                <td style="text-align:left;" vtext-align="top">Catatan</td>
                                <td style="text-align:left;" vtext-align="top">:</td>
                                <td colspan="2" style="text-align:left;" vtext-align="top">&nbsp;' . $data["sep"]["response"]["catatan"] . '</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                        </tbody>
                    </table>';
        } else {
            $cetakSEPPasien .= '<h1>' . $data["sep"]["metaData"]["message"] . '</h1>';
        }


        $cetakSEPPasien .= '<table width="100%" style="border:0;" >
                    <tbody>
                        <tr>
                            <td width="72%">
                                <p class="style11">*Saya Menyetujui BPJS Kesehatan menggunakan informasi Medis Pasien jika diperlukan
                                    <br>*SEP bukan sebagai bukti penjamin peserta . ';








        $cetakSEPPasien .= '<br>Cetakan Ke 1 Dibuat Pertama Oleh:
                                </p>
                            </td>
                            <td width="1%">&nbsp;  </td>
                            <td width="27%"><span class="style11">Pasien/Keluarga Pasien</span></td>
                        </tr>
                        <tr>
                            <td>
                            
                            <img id="salinan" width="150" height="75" src=" ' . getDetailUser($data["seplokal"]["user_id"], "signature") . '" class="resize" alt="tanda tangan petugas">
                            <img src="cap_rs.png" 
                            style="position:fixed; right:0px; bottom:0px; width:90; height:90; border:none;"
                            alt="fixed position "
                            title="fixed position" />
                            </td>
                            <td>
                            
                            
                            
                            </td>
                            <td>
                            <img id="salinan" width="150" height="75" src=" ' . $data["seplokal"]["signature"] . '" class="resize" alt="tanda tangan pasien">
                            
                            </td>
                        </tr>
                        <tr>
                            <td><span class="style11">' . $data["seplokal"]["user"] . '</span></td>
                            <td>&nbsp;</td>
                            <td><span class="style12"><span class="style11">' . $data["pendaftaran"]["PENANGGUNGJAWAB_NAMA"] . '</span></span></td>
                        </tr>
                    </tbody>
                </table>';


        $cetakSEPPasien .= '
                        <style>

                        #boxsatu, #boxdua, #boxtiga, #boxempat, #boxlima{
                            position: absolute;
                            height: 100px;
                        }
                        #boxsatu{
    width: 100px;
    left: 0px;
    top: 0px;
    background-color:red;
    z-index: 1;
}
#boxdua{
    width: 100px;
    left: 25px;
    top: 50px;
    background-color:green;
    z-index: 2;
}
                        body {
                        }

                        .style11 {
                            font-size: 10px;
                        }

                        .fontNoSEP {
                            font-size: 18px;
                            font-weight: bold;
                        }

                        .header {
                            font-size: 17px;
                            font-weight: bold;
                        }
                        </style>
                        ';


        $mpdf->SetTitle($data["sep"]["response"]["noSep"]);
        $mpdf->SetFooter($footer);
        $mpdf->SetBasePath(IMAGE_BASE_URL);
        $mpdf->WriteHTML($cetakSEPPasien);
        $mpdf->SetJS($xs);
        $mpdf->SetDisplayMode(93);
        $mpdf->useSubstitutions = false;
        $mpdf->simpleTables = true;
        $mpdf->Output($data["sep"]["response"]["noSep"] . ".pdf", "i");
    }

    public function cetakSEPKie($jenislayanan = null, $nosep, $idx)
    {
        $data['jenis_layanan']         = $this->uri->segment(3);
        $jenislayanan = base64_decode($data['jenis_layanan']);
        $data['nomer_sep']         = $this->uri->segment(4);
        $nosep = base64_decode($data['nomer_sep']);
        $data['idx']         = $this->uri->segment(5);
        $idx = base64_decode($data['idx']);


        $data['title'] = "Cetak Surat Elegibilitas Peserta ";
        $this->load->model('Vclaim_model', 'vclaim');
        $xs = "window.print()";
        $data["user"] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data["sep"] = $this->vclaim->detailSEP($nosep);

        if ($jenislayanan == 2) {

            $data["pendaftaran"] =  $this->pendaftaran->getDetailPendaftaranRajal($idx);
            $data["seplokal"] = $this->seplokal->getDetailSEPbyIDX($jenislayanan, $idx);
        }

        if ($data["sep"]["response"]["peserta"]["noKartu"]) {
            if ($jenislayanan == 2) {
                $data["peserta"] = $this->vclaim->detailKepesertaan(2, $data["sep"]["response"]["peserta"]["noKartu"]);
            }
        }

        if ($data["sep"]["response"]["noRujukan"]) {

            if (strlen($data["sep"]["response"]["noRujukan"]) > 12) {

                $rujukan = $this->vclaim->cariRujukanByNorujukan(1, $data["sep"]["response"]["noRujukan"]);

                if ($rujukan["response"] != null) {
                    $data["rujukan"] =  $rujukan;
                } else {
                    $data["rujukan"] = $this->vclaim->cariRujukanByNorujukan(2, $data["sep"]["response"]["noRujukan"]);
                }
            }
        }

        if ($jenislayanan == 2) {
            $data["petugascetak"] = $data["user"]["firstname"] . " " . $data["user"]["lastname"];
        }

        date_default_timezone_set('Asia/Jakarta');
        $footer = "dicetak oleh " . $data["user"]["firstname"] . "  " . $data["user"]["lastname"] . "    " . date("Y-m-d H:i:s") . " - SIM RSUD Ajibarang";


        $mpdf = new \Mpdf\Mpdf([
            'format' => [210, 148],
            'mode' => 'utf-8',
            'orientation' => 'P',
            'default_font_size' => 10,
            'margin_left' => 5,
            'margin_right' => 3,
            'margin_top' => 3,
            'margin_bottom' => 3,
            'default_font' => 'Courier New'
        ]);



        $cetakSEPPasien = '<!--mpdf
        
                    <table width="100%" style="border:0;" cellpadding="0">
                    <tbody>
                        <tr>
                            <td width="14%" rowspan="2" style="text-align:left;" vtext-align="top"><img src="logobpjs.png" width="200" height="50" alt="" /></td>
                            <td width="3%" height="20">&nbsp;</td>
                            <td width="79%"><span class="header"><strong>SURAT ELEGIBILITAS PESERTA

                                        <br>RSUD AJIBARANG
                                    </strong></span></td>
                            <td width="4%">&nbsp;</td>
                        </tr>
                        <tr>
                            <td height="20">&nbsp;</td>
                            <td style="text-align:left;" vtext-align="top"></td>
                            <td>&nbsp;</td>
                        </tr>
                    </tbody>




                    </table>

    

        mpdf--> ';
        if ($data["sep"]["metaData"]["code"] == 200) {
            $cetakSEPPasien .= '
                        <table width="100%" style="border:0;" cellspacing="4px" cellpadding="0">
                        <tbody>
                            <tr>
                                <td width="19%" style="text-align:left;" vtext-align="bottom">No.SEP</td>
                                <td width="1%" style="text-align:left;" vtext-align="bottom">:</td>
                                <td style="text-align:left;" vtext-align="bottom">
                                    <span class="fontNoSEP">&nbsp;' . $data["sep"]["response"]["noSep"] . '</span> </td>
                                <td style="text-align:left;" vtext-align="bottom">&nbsp;</td>
                                <td style="text-align:left;" vtext-align="bottom">&nbsp;</td>
                                <td style="text-align:left;" vtext-align="bottom">&nbsp;<strong>' . $data["peserta"]["response"]["peserta"]["informasi"]["prolanisPRB"] . '</strong></td>
                            </tr>
                            <tr>
                                <td style="text-align:left;" vtext-align="top">Tgl.SEP</td>
                                <td style="text-align:left;" vtext-align="top">:</td>
                                <td width="40%" style="text-align:left;" vtext-align="top">&nbsp;' . $data["sep"]["response"]["tglSep"] . '</td>
                                <td width="15%" style="text-align:left;" vtext-align="top">Peserta</td>
                                <td width="1%" style="text-align:left;" vtext-align="top">:</td>
                                <td width="35%" style="text-align:left;" vtext-align="top">&nbsp;' . $data["sep"]["response"]["peserta"]["jnsPeserta"] . '</td>
                            </tr>
                            <tr>
                                <td style="text-align:left;" vtext-align="top">No.Kartu</td>
                                <td style="text-align:left;" vtext-align="top">:</td>
                                <td style="text-align:left;" vtext-align="top">&nbsp;' . $data["sep"]["response"]["peserta"]["noKartu"] . ' ( ' . $data["sep"]["response"]["peserta"]["noMr"] . ')</td>
                                <td style="text-align:left;" vtext-align="top">COB</td>
                                <td style="text-align:left;" vtext-align="top">:</td>
                                <td style="text-align:left;" vtext-align="top">&nbsp;' . $data["sep"]["response"]["peserta"]["asuransi"] . '</td>
                            </tr>
                            <tr>
                                <td style="text-align:left;" vtext-align="top">Nama Peserta</td>
                                <td style="text-align:left;" vtext-align="top">:</td>
                                <td style="text-align:left;" vtext-align="top">&nbsp;' . $data["sep"]["response"]["peserta"]["nama"] . ', (' . $data["sep"]["response"]["peserta"]["kelamin"] . ')</td>
                                <td style="text-align:left;" vtext-align="top">Jns.Rawat</td>
                                <td style="text-align:left;" vtext-align="top">:</td>
                                <td style="text-align:left;" vtext-align="top">&nbsp;' . $data["sep"]["response"]["jnsPelayanan"] . '</td>
                            </tr>
                            <tr>
                                <td style="text-align:left;" vtext-align="top">Tgl.Lahir</td>
                                <td style="text-align:left;" vtext-align="top">:</td>
                                <td style="text-align:left;" vtext-align="top">&nbsp;' . $data["sep"]["response"]["peserta"]["tglLahir"] . '</td>
                                <td style="text-align:left;" vtext-align="top">Kls.Rawat</td>
                                <td style="text-align:left;" vtext-align="top">:</td>
                                <td style="text-align:left;" vtext-align="top">&nbsp;' . $data["sep"]["response"]["peserta"]["hakKelas"] . '</td>
                            </tr>
                            <tr>
                                <td style="text-align:left;" vtext-align="top">No.Telepon</td>
                                <td style="text-align:left;" vtext-align="top">:</td>
                                <td style="text-align:left;" vtext-align="top">&nbsp;' . $data["peserta"]["response"]["peserta"]["mr"]["noTelepon"] . '</td>
                                <td style="text-align:left;" vtext-align="top">Penjamin</td>
                                <td style="text-align:left;" vtext-align="top">:</td>
                                <td style="text-align:left;" vtext-align="top">&nbsp;' . $data["sep"]["response"]["penjamin"] . '</td>
                            </tr>
                            <tr>
                                <td style="text-align:left;" vtext-align="top">Sub/Spesialis</td>
                                <td style="text-align:left;" vtext-align="top">:</td>
                                <td style="text-align:left;" vtext-align="top">&nbsp;' . $data["sep"]["response"]["poli"] . ', ' . $data["sep"]["response"]["poliEksekutif"] . '</td>
                                <td style="text-align:left;" vtext-align="top">No.Rujukan</td>
                                <td style="text-align:left;" vtext-align="top">:</td>
                                <td style="text-align:left;" vtext-align="top">&nbsp;' . $data["sep"]["response"]["noRujukan"] . '</td>
                            </tr>
                            <tr>
                                <td style="text-align:left;" vtext-align="top">FaskesPerujuk</td>
                                <td style="text-align:left;" vtext-align="top">:</td>
                                <td style="text-align:left;" vtext-align="top">&nbsp;' . $data["peserta"]["response"]["peserta"]["provUmum"]["kdProvider"] . '/' . $data["peserta"]["response"]["peserta"]["provUmum"]["nmProvider"] . '</td>
                                <td style="text-align:left;" vtext-align="top">&nbsp;</td>
                                <td>&nbsp;</td>
                                <td style="text-align:left;" vtext-align="top">&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="text-align:left;" vtext-align="top">Diagnosa Awal</td>
                                <td style="text-align:left;" vtext-align="top">:</td>
                                <td colspan="2" style="text-align:left;" vtext-align="top">&nbsp;' . $data["sep"]["response"]["diagnosa"] . '</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="text-align:left;" vtext-align="top">Catatan</td>
                                <td style="text-align:left;" vtext-align="top">:</td>
                                <td colspan="2" style="text-align:left;" vtext-align="top">&nbsp;' . $data["sep"]["response"]["catatan"] . '</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                        </tbody>
                    </table>';
        } else {
            $cetakSEPPasien .= '<h1>' . $data["sep"]["metaData"]["message"] . '</h1>';
        }


        $cetakSEPPasien .= '<table width="100%" style="border:0;" cellspacing="5px" cellpadding="0">
            <tbody>
                <tr>
                    <td colspan="6">
                        <p class="style11">*Saya Menyetujui BPJS Kesehatan menggunakan informasi Medis Pasien jika diperlukan
                            <br>*SEP bukan sebagai bukti penjamin peserta .';

        if ($data["rujukan"]["response"] != null) {
            $cetakSEPPasien .= ' <br> <h2>tgl berlaku rujukan ' . $data["rujukan"]["response"]["rujukan"]["tglKunjungan"] . '  - s/d -';
            $cetakSEPPasien .= ' ' . date('Y-m-d', strtotime($data["rujukan"]["response"]["rujukan"]["tglKunjungan"] . ' + 88 days')) . '</h2>';
        }

        $cetakSEPPasien .= '<br>Cetakan Ke 1
                                    <br>Dibuat Pertama Oleh:


                                </p>
                            </td>
                            <td colspan="1">&nbsp;</td>
                            <td colspan="3"><span class="style11">Pasien/Keluarga Pasien</span></td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                            <td colspan="4">&nbsp;</td>
                            <td colspan="4"><span class="style11sign">' . $data["seplokal"]["signature"] . '</span></td>
                        </tr>
                        <tr>
                            <td><span class="style11">' . $data["seplokal"]["user"] . '</span></td>
                            <td>&nbsp;</td>
                            <td><span class="style12"><span class="style11">' . $data["pendaftaran"]["PENANGGUNGJAWAB_NAMA"] . '</span></span></td>
                        </tr>
                    </tbody>
                </table>';


        $cetakSEPPasien .= '
                        <style>
                        @page {
                            /* size: 21cm 14cm;
                            margin: 20px; */
                        }

                        body {
                            /* margin: 10px; */
                            font-family: "Courier";
                            font-size: 16px;
                        }

                        .style11 {
                            font-size: 10px;
                        }

                        .fontNoSEP {
                            font-size: 23px;
                            font-weight: bold;
                        }

                        .header {
                            font-size: 20px;
                            font-weight: bold;
                        }
                        .kbw-signature {
                            height: 150px;
                            width: 300px;
                        }
                        .style11sign {
                            height: 150px;
                            width: 300px;
                        }
                        </style>
                        ';

        $cetakSEPPasien .= '
                        <script src="<?php echo site_url("assets/js/controllers/tandatangan/"); ?>js-lib/jquery.min.js" type="text/javascript"></script>
                        <script src="<?php echo site_url("assets/js/controllers/tandatangan/"); ?>js-lib/jquery-ui.min.js" type="text/javascript"> </script>
                        <script src="<?php echo site_url("assets/js/controllers/tandatangan/"); ?>js-lib/jquery.signature.js" type="text/javascript"></script>
                        <script src="<?php echo site_url("assets/js/controllers/tandatangan/"); ?>js-lib/jquery.ui.touch-punch.min.js" type="text/javascript"></script>
                        ';
        $cetakSEPPasien .= '
                        <script type="text/javascript">
                            $(document).ready(function() {
                                $("#salinan").signature({
                                    disabled: false,
                                    guideline: false,
                                });
                                $("#salinan").signature("draw", <?php echo $data["seplokal"]["signature"]; ?>);
                            });
                        </script>
                        ';


        $mpdf->SetFooter($footer);
        $mpdf->SetBasePath(IMAGE_BASE_URL);
        $mpdf->WriteHTML($cetakSEPPasien);
        $mpdf->SetJS($xs);
        $mpdf->SetDisplayMode(93);
        $mpdf->useSubstitutions = false;
        $mpdf->simpleTables = true;
        $mpdf->Output("SEP.pdf", "i");
    }

    public function sepDetails($noSEP)
    {
        $data['title'] = "Detail SEP";
        $detail = $this->vclaim->findSEPBYnoSEP($noSEP);
        if ($detail["metaData"]["code"] != 200) {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-danger" role="alert"> ' . $detail["metaData"]["message"] . '</div>'
            );

            redirect(site_url('rekammedis/dashboard'));
        }

        $mpdf = new \Mpdf\Mpdf([
            'format' => [210, 148],
            'mode' => 'utf-8',
            'orientation' => 'P',
            'default_font_size' => 12,
            'margin_left' => 5,
            'margin_right' => 5,
            'margin_top' => 7,
            'margin_bottom' => 5,
            'default_font' => 'ubuntu'
        ]);
        $mpdf->SetTitle($detail["response"]["peserta"]["noMr"] . " - " . $detail["response"]["peserta"]["nama"] . ""   . " (" . $detail["response"]["noSep"] . ")");
        $footer = "";
        $xs = "";
        $html = json_encode($detail);
        $mpdf->SetFooter($footer);
        $mpdf->SetBasePath(IMAGE_BASE_URL);
        $mpdf->WriteHTML($html);
        $mpdf->SetJS($xs);
        $mpdf->SetDisplayMode(93);
        $mpdf->useSubstitutions = false;
        $mpdf->simpleTables = true;

        $mpdf->Output($detail["response"]["peserta"]["noMr"] . " - " . $detail["response"]["peserta"]["nama"] . ""   . " (" . $detail["response"]["noSep"] . ")" . ".pdf", "i");
    }




    public function SepDetailprintOut($idadmission, $jenispelayanan, $nomr)
    {
        date_default_timezone_set('Asia/Jakarta');
        $data["penanggungjawab"] = "Penanggung Jawab";
        if ($jenispelayanan == 1) {
            $pendaftaran = $this->admission->getAdmissionDetailbyID($idadmission);
            $data["penanggungjawab"] = $pendaftaran["panggungjawab"];
        } else {
            $data["pasiendaftar"] = $this->pendaftaran->getDetailPendaftaranRajal($idadmission);
            $data["penanggungjawab"] = $data["pasiendaftar"]["PENANGGUNGJAWAB_NAMA"];
        }

        $param = [
            "modal_nomr" => $nomr,
            "modal_jenispelayanan" => $jenispelayanan,
            "modal_idadmission" => $idadmission
        ];

        $data["pasiendaftar"] = $this->pendaftaran->getDetailPendaftaranRajal($idadmission);
        $data['title'] = "Detail Surat Elegibilitas Peserta";
        $data["sep"] = $this->vclaim->_findSEPdetails($param);
        // print_r($data["sep"]);
        // die();
		
        if ($data["sep"]) {
            // $data["detailsep"] = $this->vclaim->findSEPBYnoSEP($data["sep"]["nomer_sep"]);
            // $data["kepesertaan"] = $this->vclaim->kepesertaan(2, $data["sep"]["no_kartubpjs"]);
          
			//$data["rujukan"]  = $this->vclaim->DETAILRUJUKAN($data["sep"]["no_rujukan"], $data["sep"]["faskes_id"]);
           // if ($data["rujukan"]["metaData"]["code"] == 200) {
                //$data["statussimpan"] = $this->seplokal->simpanPembaharuanRujukanBPJS($data["sep"]["id"], $data["rujukan"]["response"]);
           // }

          

            $mpdf = new \Mpdf\Mpdf([
                'format' => [210, 148],
                'mode' => 'utf-8',
                'orientation' => 'P',
                'default_font_size' => 12,
                'margin_left' => 5,
                'margin_right' => 5,
                'margin_top' => 7,
                'margin_bottom' => 5,
                'default_font' => 'ubuntu'
            ]);
            $data = $this->load->view('cetak/cek', $data, TRUE);
            $mpdf->WriteHTML($data);
            $mpdf->Output();
        } else {
            echo "<h1>Tidak Ada SEP</h1>";
        }
    }

    public function SepDetailprintOutDouble($idadmission, $jenispelayanan, $nomr)
    {
        date_default_timezone_set('Asia/Jakarta');
        $data["penanggungjawab"] = "Penanggung Jawab";
        if ($jenispelayanan == 1) {
            $pendaftaran = $this->admission->getAdmissionDetailbyID($idadmission);
            $data["penanggungjawab"] = $pendaftaran["panggungjawab"];
        } else {
            $data["pasiendaftar"] = $this->pendaftaran->getDetailPendaftaranRajal($idadmission);
            $data["penanggungjawab"] = $data["pasiendaftar"]["PENANGGUNGJAWAB_NAMA"];
        }

        $param = [
            "modal_nomr" => $nomr,
            "modal_jenispelayanan" => $jenispelayanan,
            "modal_idadmission" => $idadmission
        ];

        $data["pasiendaftar"] = $this->pendaftaran->getDetailPendaftaranRajal($idadmission);
        $data['title'] = "Detail Surat Elegibilitas Peserta";
        $data["sep"] = $this->vclaim->_findSEPdetails($param);
        if ($data["sep"]) {

            $mpdf = new \Mpdf\Mpdf([
                'format' => [210, 297],
                'mode' => 'utf-8',
                'orientation' => 'P',
                'default_font_size' => 12,
                'margin_left' => 5,
                'margin_right' => 5,
                'margin_top' => 7,
                'margin_bottom' => 5,
                'default_font' => 'ubuntu'
            ]);
            $data = $this->load->view('cetak/sepdouble', $data, TRUE);
            $mpdf->WriteHTML($data);
            $mpdf->Output();
        } else {
            echo "<h1>Tidak Ada SEP</h1>";
        }
    }

    public function sepManual($idx)
    {

        $jenislayanan = base64_decode($layanan);

        $data["user"] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data["pendaftaran"] =  $this->pendaftaran->getDetailPendaftaranRajal($idx);
        date_default_timezone_set('Asia/Jakarta');
        $footer = "dicetak oleh " . $data["user"]["firstname"] . "  " . $data["user"]["lastname"] . "    " . date("Y-m-d H:i:s") . " - SIM RSUD Ajibarang";


        $mpdf = new \Mpdf\Mpdf([
            'format' => [210, 148],
            'mode' => 'utf-8',
            'orientation' => 'P',
            'default_font_size' => 12,
            'margin_left' => 5,
            'margin_right' => 5,
            'margin_top' => 7,
            // 'margin_bottom' => 5,
            'margin_footer' => 1,
            'default_font' => 'ubuntu'
        ]);





        $cetakSEPPasien = '<!--mpdf
        
                    <table width="100%" style="border:0;" cellpadding="0">
                    <tbody>
                        <tr>
                            <td width="14%" rowspan="2" style="text-align:left;" vtext-align="top"><img src="http://localhost/simrs2022/assets/img/logobpjs.png" width="200" height="50" alt="" /></td>
                            <td width="3%" height="20">&nbsp;</td>
                            <td width="79%"><span class="header"><strong>TANDA BUKTI PELAYANAN SEP

                                        <br>RSUD AJIBARANG
                                    </strong></span></td>
                            <td width="4%">&nbsp;</td>
                        </tr>
                        <tr>
                            <td height="20">&nbsp;</td>
                            <td style="text-align:left;" vtext-align="top"></td>
                            <td>&nbsp;</td>
                        </tr>
                    </tbody>




                    </table>

    

        mpdf--> ';
        $cetakTgl = "";
        if ($data["rujukan"]["response"] != null) {
            $cetakTgl .= '  tgl berlaku rujukan <b>' . $data["rujukan"]["response"]["rujukan"]["tglKunjungan"] . '</b>  - s/d -';
            $cetakTgl .= '<b> ' . date('Y-m-d', strtotime($data["rujukan"]["response"]["rujukan"]["tglKunjungan"] . ' + 88 days')) . '</b>';
        }


        $cetakSEPPasien .= '
                        <table width="100%" style="border:0;" cellspacing="4px" cellpadding="0">
                        <tbody>

                             <tr>
                                <td style="text-align:left;" vtext-align="top">No.RM</td>
                                <td style="text-align:left;" vtext-align="top">:</td>
                                <td style="text-align:left;" vtext-align="top">&nbsp;' . $data["pendaftaran"]["NOMR"] . '</td>
                               
                            </tr>
                            
                            <tr>
                                <td style="text-align:left;" vtext-align="top">No.Kartu bpjs</td>
                                <td style="text-align:left;" vtext-align="top">:</td>
                                <td style="text-align:left;" vtext-align="top">&nbsp;' . getDetailPasien($data["pendaftaran"]["NOMR"], "NO_KARTU") . '</td>
                                
                            </tr>
                            <tr>
                                <td style="text-align:left;" vtext-align="top">Nama Peserta</td>
                                <td style="text-align:left;" vtext-align="top">:</td>
                                <td style="text-align:left;" vtext-align="top">&nbsp;' . getDetailPasien($data["pendaftaran"]["NOMR"], "NAMA") . '</td>
                               
                            </tr>

                            <tr>
                                <td style="text-align:left;" vtext-align="top">Alamat</td>
                                <td style="text-align:left;" vtext-align="top">:</td>
                                <td style="text-align:left;" vtext-align="top">&nbsp;' . getDetailPasien($data["pendaftaran"]["NOMR"], "ALAMAT") . '</td>
                               
                            </tr>

                            <tr>
                                <td style="text-align:left;" vtext-align="top">Tanggal Pelayanan</td>
                                <td style="text-align:left;" vtext-align="top">:</td>
                                <td style="text-align:left;" vtext-align="top">&nbsp;' . $data["pendaftaran"]["TGLREG"] . '</td>
                                
                            </tr>
                            
                           
                        </tbody>
                    </table>';



        $cetakSEPPasien .= '<br><br><table width="100%" style="border:0;" >
                    <tbody>

                        <tr>
                            <td width="72%">
                                <p>*Apabila halaman ini dicetak sedang terjadi gangguan sistem pelayanan SEP
                                    <br>*Formulir ini hanya sebagai tanda bukti pelayanan
                                    <br>*SEP akan di susulkan jika sistem sudah kembali normal';








        $cetakSEPPasien .= '<br>Cetakan Ke 1 Dibuat Pertama Oleh:
                                </p>
                            </td>
                            <td width="1%">&nbsp;  </td>
                            <td width="27%"><span class="style11">Pasien/Keluarga Pasien</span></td>
                        </tr>
                        <tr>
                            <td>
                            
                            <img id="salinan" width="150" height="75" src="' . getDetailUser($data["pendaftaran"]["uid"], "signature") . '" class="resize" alt="tanda tangan petugas">
                            <img src="http://localhost/simrs2022/assets/img/cap_rs.png" 
                            style="position:fixed; right:0px; bottom:0px; width:90; height:90; border:none;"
                            alt="fixed position "
                            title="fixed position" />
                            </td>
                            <td>
                            
                            
                            
                            </td>
                            <td>
                            
                            </td>
                        </tr>
                        <tr>
                            <td><span class="style11">' . getDetailUser($data["pendaftaran"]["uid"], "firstname") . '</span></td>
                            <td>&nbsp;</td>
                            <td><span class="style12"><span class="style11">' . $data["pendaftaran"]["PENANGGUNGJAWAB_NAMA"] . '</span></span></td>
                        </tr>
                    </tbody>
                </table>';


        $cetakSEPPasien .= '
                        <style>

                        #boxsatu, #boxdua, #boxtiga, #boxempat, #boxlima{
                            position: absolute;
                            height: 100px;
                        }
                        #boxsatu{
                            width: 100px;
                            left: 0px;
                            top: 0px;
                            background-color:red;
                            z-index: 1;
                        }
                        #boxdua{
                            width: 100px;
                            left: 25px;
                            top: 50px;
                            background-color:green;
                            z-index: 2;
                        }
                        body {
                        }

                        .style11 {
                            font-size: 10px;
                        }

                        .fontNoSEP {
                            font-size: 18px;
                            font-weight: bold;
                        }

                        .header {
                            font-size: 17px;
                            font-weight: bold;
                        }
                        </style>
                        ';


        $mpdf->SetTitle($data["sep"]["response"]["noSep"]);
        $mpdf->SetFooter($footer);
        $mpdf->SetBasePath(IMAGE_BASE_URL);
        $mpdf->WriteHTML($cetakSEPPasien);
        $mpdf->SetDisplayMode(93);
        $mpdf->useSubstitutions = false;
        $mpdf->simpleTables = true;
        $mpdf->Output($data["sep"]["response"]["noSep"] . ".pdf", "i");
    }
}
