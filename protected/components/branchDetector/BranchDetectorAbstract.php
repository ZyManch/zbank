<?php
/**
 * Created by PhpStorm.
 * User: ZyManch
 * Date: 19.12.2015
 * Time: 15:10
 */
abstract class BranchDetectorAbstract {


    protected $_columns;


    public function setNameColumn($col) {
        $this->_columns['name'] = $col;
        return $this;
    }


    protected function _getName($row) {
        if (!isset($this->_columns['name'])) {
            return null;
        }
        return $this->_getValue($this->_columns['name'],$row);
    }

    public function setAddressColumn($col) {
        $this->_columns['address'] = $col;
        return $this;
    }

    protected function _getAddress($row) {
        if (!isset($this->_columns['address'])) {
            return null;
        }
        return $this->_getValue($this->_columns['address'],$row);
    }

    public function setWorkColumn($col) {
        $this->_columns['work'] = $col;
        return $this;
    }

    protected function _getWork($row) {
        if (!isset($this->_columns['work'])) {
            return null;
        }
        return $this->_getValue($this->_columns['work'],$row);
    }

    public function setCityColumn($col) {
        $this->_columns['city'] = $col;
        return $this;
    }

    /**
     * @param $row
     * @return City
     */
    protected function _getCity($row) {
        if (!isset($this->_columns['city'])) {
            return null;
        }
        $cityName = $this->_getValue($this->_columns['city'],$row);
        return City::getCityByName($cityName);
    }

    public function setStreetColumn($col) {
        $this->_columns['street'] = $col;
        return $this;
    }

    protected function _getStreet($row) {
        if (!isset($this->_columns['street'])) {
            return null;
        }
        return $this->_getValue($this->_columns['street'],$row);
    }

    public function setHouseColumn($col) {
        $this->_columns['house'] = $col;
        return $this;
    }

    protected function _getHouse($row ) {
        if (!isset($this->_columns['house'])) {
            return null;
        }
        return $this->_getValue($this->_columns['house'],$row);
    }

    public function setPhonesColumn($col) {
        $this->_columns['phones'] = $col;
        return $this;
    }

    protected function _getPhones($row) {
        if (!isset($this->_columns['phones'])) {
            return null;
        }
        return $this->_getValue($this->_columns['phones'],$row);
    }

    abstract function _getValue($name, $row);

}