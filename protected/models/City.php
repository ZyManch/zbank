<?php

/**
* This is the model class for table "city".
*
* The followings are the available columns in table 'city':
*/
class City extends CCity {

    protected static $_cache = array();

    public static function getCityByName($name) {
        $name = str_replace(array(
            'г. ',
            'гор. ',
            'с. ',
            'сел. ',
            'пгт. ',
            'пгт.',
        ),array(
            'г.',
            'г.',
            'с.',
            'с.',
            'г.',
            'г.',
        ),$name);
        if (isset(self::$_cache[$name])) {
            return self::$_cache[$name];
        }
        $city = self::model()->find(array(
            'condition'=>'title like :name',
            'params' => array(':name' => $name)
        ));
        if (!$city) {
            $city = new City();
            $city->title = $name;
            $pos = Yii::app()->geocoder->addressToPos($name);
            if ($pos) {
                $city->longitude = $pos[0];
                $city->latitude = $pos[1];
            }
            $city->save(false);
        }
        self::$_cache[$name] = $city;
        return $city;
    }

}
