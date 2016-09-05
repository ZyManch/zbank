<?php
/**
 * Created by PhpStorm.
 * User: ZyManch
 * Date: 19.12.2015
 * Time: 15:10
 */
class CurrencyDetectorHtml extends CurrencyDetectorAbstract {


    protected $_rowSeparator;

    protected $_colSeparator;


    protected $_rows = array();


    public function setRowSeparator($separator) {
        $this->_rowSeparator = $separator;
        return $this;
    }

    public function setColSeparator($separator) {
        $this->_colSeparator = $separator;
        return $this;
    }


    public function run() {
        $currencies = array_filter(explode($this->_rowSeparator,$this->_response));
        foreach ($currencies as $row => $currency) {
            $this->_rows[$row] = explode($this->_colSeparator,$currency);
        }
        $bankCurrencies = $this->_bank->bankCurrencies;
        foreach (array_keys($this->_rows) as $row) {
            $name = $this->getName($row);
            if ($name) {
                $name = iconv($this->_encoding, 'utf-8', $name);
                $sign = $this->getSign($row);
                $count = $this->getCount($row);
                $buy = $this->getBuy($row);
                $sell = $this->getSell($row);
                if (preg_match('/[0-9]+/',$buy) && !preg_match('/[0-9]+/',$name)) {
                    $currency = Currency::getCurrencyByName($name, $sign);
                    $currencyId = $currency->id;
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

    protected function _getValue($row, $col) {
        return trim(strip_tags($this->_rows[$row][$col]));
    }


}