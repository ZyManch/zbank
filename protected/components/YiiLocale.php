<?php
/**
 * Created by PhpStorm.
 * User: ZyManch
 * Date: 16.03.2015
 * Time: 19:44
 */
class YiiLocale extends CLocale {

    protected $_dateFormatter;

    public function getDateFormatter() {
        if($this->_dateFormatter===null)
            $this->_dateFormatter=new DateFormatter($this);
        return $this->_dateFormatter;
    }

    public static function getInstance($id) {
        static $locales=array();
        if(isset($locales[$id]))
            return $locales[$id];
        else
            return $locales[$id]=new YiiLocale($id);
    }
}