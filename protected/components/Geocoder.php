<?php
/**
 * Created by PhpStorm.
 * User: ZyManch
 * Date: 19.12.2015
 * Time: 12:42
 */
class Geocoder extends CComponent {

    public $developer_key;

    public function init() {

    }

    public function addressToPos($address) {
        $address = trim(str_replace(',,',',',$address),' ,');
        $params = array(
            'geocode' => $address,
            'format'  => 'json',
            'results' => 1
        );
        if ($this->developer_key) {
            $params['key'] = $this->developer_key;
        }
        $url = 'http://geocode-maps.yandex.ru/1.x/?' . http_build_query($params, '', '&');
        $response = json_decode(file_get_contents($url),1);
        $geoCollection = $response['response']['GeoObjectCollection'];
        if (!$geoCollection['metaDataProperty']['GeocoderResponseMetaData']['found']) {
            return null;
        }
        return explode(' ',$geoCollection['featureMember'][0]['GeoObject']['Point']['pos'],2);
    }

}