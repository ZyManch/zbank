<?php

/**
* This is the model class for table "currency".
*
* The followings are the available columns in table 'currency':
    * @property string $id
    * @property string $title
    * @property string $sign
    * @property string $status
    *
    * The followings are the available model relations:
        * @property BankCurrency[] $bankCurrencies
*/
class CCurrency extends ActiveRecord {

    public function tableName()	{
        return 'currency';
    }

    public function rules()	{
        return array(
            array('title', 'required'),
			array('title', 'length', 'max'=>128),
			array('sign', 'length', 'max'=>5),
			array('status', 'length', 'max'=>7)        );
    }

    /**
    * @return array relational rules.
    */
    protected function _baseRelations()	{
        return array(
            'bankCurrencies' => array(self::HAS_MANY, 'BankCurrency', 'currency_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'title' => 'Title',
            'sign' => 'Sign',
            'status' => 'Status',
        );
    }


}
