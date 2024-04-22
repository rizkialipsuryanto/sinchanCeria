<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class PdfGenerator
{
    public function generate($html, $filename, $paper_size = 'a4', $orientation = 'portrait')
    {
        define('DOMPDF_ENABLE_AUTOLOAD', false);
        require_once("./vendor/dompdf/dompdf/dompdf_config.inc.php");

        $dompdf = new DOMPDF();
        $dompdf->load_html($html);
        $dompdf->set_paper($paper_size, $orientation);
        $dompdf->render();
        $dompdf->stream($filename . '.pdf', array("Attachment" => 0));
    }


    // function get_pdf($html, $paper_size = 'a4', $orientation = 'portrait', $filename = '', $stream = TRUE)
    // {
    //     require_once("dompdf/dompdf_config.inc.php");

    //     $dompdf = new DOMPDF();
    //     $dompdf->load_html($html);

    //     $dompdf->set_paper($paper_size, $orientation);

    //     $dompdf->render();

    //     if (!empty($filename) && $stream) {
    //         $dompdf->stream($filename . ".pdf"); 
    //     } else if ($stream) {
    //         $dompdf->stream($filename . ".pdf", array('Attachment' => 0));
    //     } else {
    //         return $dompdf->output();
    //     }
    // }
}
