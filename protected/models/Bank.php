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


    public function updateBankInformation() {
        return false;
    }
}
