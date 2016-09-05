<?php
/**
 * Created by PhpStorm.
 * User: ZyManch
 * Date: 08.12.2015
 * Time: 17:50
 */
class Vtb24Bank extends Bank {


    public function updateBankBranch() {
        $url = rtrim($this->url,'/').'/_vti_bin/Vtb24.Cartography/OfficeBusyService.svc/GetOffices';

    }

    public function updateBankCurrency() {
        $url = rtrim($this->url,'/').'/_vti_bin/Vtb24.Internet/CurrencyRateWebService.svc/GetCurrencyRatesJson?filter=8';
        $detector = new CurrencyDetectorJson($this, $url);
        $detector->
            setGetItems(function($response) {
                return $response['GetCurrencyRatesJsonResult'];
            })->
            setValidator(function($value) {
                return strpos($value['CurrencyAbbr'],'/') === false;
            })->
            setNameColumn('Title')->
            setCountColumn('Quantity')->
            setSignColumn('CurrencyAbbr')->
            setBuyColumn('Buy')->
            setSellColumn('Sell')->
            run();
    }


}