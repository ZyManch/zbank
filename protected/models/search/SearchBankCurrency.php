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
*/
class SearchBankCurrency extends CBankCurrency {

    public function __construct($scenario = 'search') {
        parent::__construct($scenario);
    }

    public function rules()	{
        return array(
            array('id, bank_id, currency_id, sale_price, buy_price', 'safe', 'on'=>'search'),
        );
    }

    public function search() {

        $criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('bank_id',$this->bank_id,true);
		$criteria->compare('currency_id',$this->currency_id,true);
		$criteria->compare('sale_price',$this->sale_price,true);
		$criteria->compare('buy_price',$this->buy_price,true);

        return new CActiveDataProvider('BankCurrency', array(
            'criteria'=>$criteria,
            'pagination'=>array('pageSize'=>40)
        ));
    }

    public function save() {
        throw new Exception('Its search only model');
    }

}
