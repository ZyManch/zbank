<?php
/**
 * Created by PhpStorm.
 * User: ZyManch
 * Date: 08.12.2015
 * Time: 17:50
 */
class GazpromBank extends Bank {


    public function updateBankBranch() {
        $file = rtrim($this->url,'/').'/additional_office/do_17122015_all.xls';
        $detector = new BranchDetectorXls($this, $file);
        $detector->
            setStartFrom(5)->
            setNameColumn(1)->
            setAddressColumn(2)->
            setWorkColumn(3)->
            run();
    }


}