<?php

/**
* This is the model class for table "bank_currency".
*
* The followings are the available columns in table 'bank_currency':
    * @property string $id
    * @property string $bank_id
    * @property string $currency_id
    * @property string $sale_price
    * @property string $buy_price
    *
    * The followings are the available model relations:
        * @property Bank $bank
        * @property Currency $currency
*/
class CBankCurrency extends ActiveRecord {

    public function tableName()	{
        return 'bank_currency';
    }

    public function rules()	{
        return array(
            array('bank_id, currency_id, sale_price, buy_price', 'required'),
			array('bank_id, currency_id', 'length', 'max'=>10),
			array('sale_price, buy_price', 'length', 'max'=>8)        );
    }

    /**
    * @return array relational rules.
    */
    protected function _baseRelations()	{
        return array(
            'bank' => array(self::BELONGS_TO, 'Bank', 'bank_id'),
            'currency' => array(self::BELONGS_TO, 'Currency', 'currency_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'bank_id' => 'Bank',
            'currency_id' => 'Currency',
            'sale_price' => 'Sale Price',
            'buy_price' => 'Buy Price',
        );
    }


}
