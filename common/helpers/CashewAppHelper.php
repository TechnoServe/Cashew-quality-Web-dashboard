<?php


namespace common\helpers;


use kartik\mpdf\Pdf;

class CashewAppHelper
{
    public static function createFolderIfNotExist($path)
    {
        if ( ! file_exists($path)) {
            mkdir($path, 0777, true);
        }
    }


    public static function groupAssArrayBy($array, $key) {
        $return = array();
        foreach($array as $val) {
            $return[$val[$key]][] = $val;
        }
        return $return;
    }


   public static function searchForValueInArray($key, $array) {
        foreach ($array as $measurement) {
            if ($measurement["key"] == $key) {
                return $measurement;
            }
        }
        return null;
    }


    /**
     * Used to render pdf and send as downloadable in browser
     * @param $content
     * @param string $format
     * @param string $orientation
     * @param null $css
     * @param null $marginOptions
     * @param null $filename
     *
     * @return mixed
     */
    public static function renderPDF($content, $format = Pdf::FORMAT_A4, $orientation = Pdf::ORIENT_LANDSCAPE, $css = null, $marginOptions = null, $filename = null) {
        error_reporting(0);
        $options = [
            'mode' => Pdf::MODE_UTF8,
            'filename' => $filename,
            'format' => $format,
            'orientation' => $orientation,
            'destination' => Pdf::DEST_DOWNLOAD,
            'content' => $content,
            'cssFile' => '@backend/web/css/pdf.css',
            'cssInline' => $css,
            'methods' => [
                'SetFooter' => ['{PAGENO}'],
            ],
            'options' => [
                'autoLangToFont' => true,
                'autoScriptToLang' => true,
            ],
        ];

        if (is_array($marginOptions)) {
            $options = array_merge($options, $marginOptions);
        }

        $pdf = new Pdf($options);

        return $pdf->render();
    }
}