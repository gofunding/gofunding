<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\components;

/**
 * Description of ConvertImageToPDF
 *
 * @author haifa
 */
class ConvertImageToPDF {

    public static function convert($uploadFiles, $outputPath) {        
        $mpdf = new \mPDF;
        foreach ($uploadFiles as $file) {
            $inputPath = $file->tempName;
            $html = '<img src="' . $inputPath . '"/>';
            $mpdf->WriteHTML($html);
        }
        $mpdf->Output($outputPath . ".pdf", 'F');
        $mpdf->debug = true;
    }

}
