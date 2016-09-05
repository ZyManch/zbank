<?php

/**
* This is the model class for table "bank".
*
* The followings are the available columns in table 'bank':
*/
class Bank extends CBank {

    protected function instantiate($attributes) {
        if ($attributes['name']) {
                $class = explode('_',$attributes['name']);
                $class = implode('',array_map('ucfirst',$class)).'Bank';
            return new $class(null);
        }
        return new Bank(null);
    }

    protected function _extendedRelations()	{
        return array(
            'bankCurrencies' => array(self::HAS_MANY, 'BankCurrency', 'bank_id', 'index'=>'currency_id'),
        );
    }

    public function updateBankBranch() {
        return false;
    }

    public function updateBankCurrency() {
        if ($this->url) {
            $html = file_get_contents($this->url);

        }
        return false;
    }
}
