<?php
/**
 * Created by PhpStorm.
 * User: ZyManch
 * Date: 19.12.2015
 * Time: 15:10
 */
abstract class CurrencyDetectorAbstract {


    const ENCODING_CP1251 = 'windows-1251';
    const ENCODING_UTF_8 = 'utf-8';

    protected $_bank;

    protected $_response;


    protected $_encoding = self::ENCODING_CP1251;

    protected $_columns = array();

    protected $_parser = array();

    public function __construct(Bank $bank, $url) {
        $this->_bank = $bank;
        $this->_response = file_get_contents($url);
        $this->_init();
    }

    protected function _init() {

    }


    public function setNameColumn($col) {
        $this->_columns['name'] = $col;
        return $this;
    }

    public function setNameParser($parser) {
        $this->_parser['name'] = $parser;
        return $this;
    }

    public function getName($row) {
        if (!isset($this->_columns['name'])) {
            return null;
        }
        $value =  $this->_getValue($this->_columns['name'],$row );
        if (isset($this->_parser['name'])) {
            $parser = $this->_parser['name'];
            $value = $parser($value);
        }
        return $value;
    }

    public function setSignColumn($col) {
        $this->_columns['sign'] = $col;
        return $this;
    }

    public function setSignParser($parser) {
        $this->_parser['sign'] = $parser;
        return $this;
    }

    public function getSign($row) {
        if (!isset($this->_columns['sign'])) {
            return null;
        }
        $value = $this->_getValue($this->_columns['sign'],$row );
        if (isset($this->_parser['sign'])) {
            $parser = $this->_parser['sign'];
            $value = $parser($value);
        }
        return $value;
    }

    public function setCountColumn($col) {
        $this->_columns['count'] = $col;
        return $this;
    }

    public function setCountParser($parser) {
        $this->_parser['count'] = $parser;
        return $this;
    }

    public function getCount($row) {
        if (!isset($this->_columns['count'])) {
            return 1;
        }
        $value = $this->_getValue($this->_columns['count'], $row);
        if (isset($this->_parser['count'])) {
            $parser = $this->_parser['count'];
            $value = $parser($value);
        }
        return $value ? $value : 1;
    }

    public function setBuyColumn($col) {
        $this->_columns['buy'] = $col;
        return $this;
    }

    public function setBuyParser($parser) {
        $this->_parser['buy'] = $parser;
        return $this;
    }

    public function getBuy($row) {
        if (!isset($this->_columns['buy'])) {
            return null;
        }
        $value = $this->_getValue($this->_columns['buy'],$row );
        if (isset($this->_parser['buy'])) {
            $parser = $this->_parser['buy'];
            $value = $parser($value);
        }
        return str_replace(',',',',$value);
    }

    public function setSellColumn($col) {
        $this->_columns['sell'] = $col;
        return $this;
    }

    public function setSellParser($parser) {
        $this->_parser['sell'] = $parser;
        return $this;
    }

    public function getSell($row) {
        if (!isset($this->_columns['sell'])) {
            return null;
        }
        $value = $this->_getValue($this->_columns['sell'],$row );
        if (isset($this->_parser['sell'])) {
            $parser = $this->_parser['sell'];
            $value = $parser($value);
        }
        return str_replace(',',',',$value);
    }

    abstract protected function _getValue($row, $col);

}