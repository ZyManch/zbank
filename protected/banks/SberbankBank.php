<?php
/**
 * Created by PhpStorm.
 * User: ZyManch
 * Date: 08.12.2015
 * Time: 17:50
 */
class SberbankBank extends Bank {


    public function updateBankBranch() {
        $file = rtrim($this->url,'/').'/common/img/uploaded/files/branches.xls';
        $detector = new BranchDetectorXls($this, $file);
        $detector->
            setStartFrom(5)->
            setNameColumn(2)->
            setCityColumn(10)->
            setStreetColumn(11)->
            setHouseColumn(12)->
            setPhonesColumn(13)->
            setWorkColumn(15)->
            run();

    }

    public function updateBankCurrency() {
        $params = array(
            'cbrf' => 1,
            'inf_block' => 111,
            'quotes_for' => '',
            'version' => 0,
            'site' => 1,
            'date' => date('d.m.Y'),
            'payment' => 'cash',
            'person' => 'natural'
        );
        $url = 'http://data.sberbank.ru/common/js/quote_table.php?'.http_build_query(
            $params
        );
        $detector = new CurrencyDetectorHtml($this, $url);
        $detector->
            setRowSeparator('<tr>')->
            setColSeparator('</td>')->
            setNameColumn(0)->
            setSignColumn(1)->
            setCountColumn(2)->
            setBuyColumn(3)->
            setSellColumn(4)->
            run();
    }



}