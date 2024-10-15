<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// panggil autoload dompdf nya
require_once 'dompdf-master/autoload.inc.php';
use Dompdf\Dompdf;
use Dompdf\Options;
class Pdfgenerator {
    public function generate($html, $filename='', $paper = '', $orientation = '', $path = '', $stream=TRUE)
    {   
        $options = new Options();
        $options->set('isRemoteEnabled', TRUE);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper($paper, $orientation);
        $dompdf->render();
        if ($stream) {
            $dompdf->stream($filename.".pdf", array("Attachment" => 0));
            exit();
        } else {
            if($path == ''){
                return $dompdf->output();
            }else{
                $output = $dompdf->output();
                file_put_contents($path.".pdf", $output);
            }
        }
    }
}