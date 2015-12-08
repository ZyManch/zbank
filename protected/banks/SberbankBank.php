<?php
/**
 * Created by PhpStorm.
 * User: ZyManch
 * Date: 08.12.2015
 * Time: 17:50
 */
class SberbankBank extends Bank {


    public function updateBankInformation() {
        $file = rtrim($this->url,'/').'/common/img/uploaded/files/branches.xls';
        $objPHPExcel = PHPExcel_IOFactory::load($file);
        $sheet = $objPHPExcel->
            getActiveSheet();
        $branches = array();
        $branches[] = array(
            $sheet->getCellByColumnAndRow(2,5),
            $sheet->getCellByColumnAndRow(9,5),
            $sheet->getCellByColumnAndRow(10,5),
            $sheet->getCellByColumnAndRow(11,5),
            $sheet->getCellByColumnAndRow(12,5),
            $sheet->getCellByColumnAndRow(13,5),
            $sheet->getCellByColumnAndRow(14,5),
        );
        var_dump($branches);
    }


}