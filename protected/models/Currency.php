<?php

/**
* This is the model class for table "currency".
*
* The followings are the available columns in table 'currency':
*/
class Currency extends CCurrency {

    protected static $_cache = array();

    public static function getCurrencyByName($name, $sign = null) {
        $name = trim($name);
        $sign = strtolower(trim($sign));
        if (isset(self::$_cache[$name])) {
            return self::$_cache[$name];
        }
        if ($name) {
            $currency = self::model()->find(array(
                'params'    => array(':name' => $name),
                'condition' => 'title like :name'
            ));
        } else {
            $currency = self::model()->find(array(
                'params'    => array(':sign' => $sign),
                'condition' => 'sign like :sign'
            ));
        }
        if (!$currency) {
            $currency = new self();
            $currency->title = $name;
            $currency->sign = $sign;
            $currency->save(false);
        }
        self::$_cache[$name] = $currency;
        return $currency;
    }

}
