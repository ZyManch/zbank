<?php
/**
 * Created by PhpStorm.
 * User: ZyManch
 * Date: 19.12.2015
 * Time: 15:10
 */
class CurrencyDetectorJson extends CurrencyDetectorAbstract {


    protected $_getItemsFunc;

    protected $_validator;

    protected $_items = array();

    public function _initJson() {
        $json = json_decode($this->_response,1);
        if ($this->_getItemsFunc) {
            $func = $this->_getItemsFunc;
            $json = $func($json);
        }
        $validator = $this->_validator;
        foreach ($json as $item) {
            if (!$validator || $validator($item)) {
                $this->_items[] = $item;
            }
        }
    }

    public function run() {
        $this->_initJson();
        $bankCurrencies = $this->_bank->bankCurrencies;
        $alreadySavedCurrencies = array();
        foreach (array_keys($this->_items) as $row) {
            $name = $this->getName($row);
            if ($name) {
                //$name = iconv($this->_encoding, 'utf-8', $name);
                $sign = $this->getSign($row);
                $count = $this->getCount($row);
                $buy = $this->getBuy($row);
                $sell = $this->getSell($row);
                if (preg_match('/[0-9]+/',$buy) && !preg_match('/[0-9]+/',$name)) {
                    $currency = Currency::getCurrencyByName($name, $sign);
                    $currencyId = $currency->id;

                    if (in_array($currencyId, $alreadySavedCurrencies)) {
                        continue;
                    }
                    $alreadySavedCurrencies[] = $currencyId;
                    if (isset($bankCurrencies[$currencyId])) {
                        $bankCurrency = $bankCurrencies[$currencyId];
                        unset($bankCurrencies[$currencyId]);
                    } else {
                        $bankCurrency = new BankCurrency();
                        $bankCurrency->bank_id = $this->_bank->id;
                        $bankCurrency->currency_id = $currencyId;
                    }
                    $bankCurrency->sale_price = $sell / $count;
                    $bankCurrency->buy_price = $buy / $count;
                    $bankCurrency->save(false);
                }
            }
        }
        foreach ($bankCurrencies as $bankCurrency) {
            $bankCurrency->delete();
        }
    }

    public function setGetItems($func) {
        $this->_getItemsFunc = $func;
        return $this;
    }


    public function setValidator($func) {
        $this->_validator = $func;
        return $this;
    }

    protected function _getValue($col, $row) {
        return $this->_items[$row][$col];
    }
}