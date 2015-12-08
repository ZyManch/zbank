<?php

/**
* This is the model class for table "bank".
*
* The followings are the available columns in table 'bank':
    * @property string $id
    * @property string $name
    * @property string $title
    * @property string $url
    * @property integer $license
    * @property string $position
    * @property string $status
    *
    * The followings are the available model relations:
        * @property BankBranch[] $bankBranches
        * @property BankCurrency[] $bankCurrencies
*/
class CBank extends ActiveRecord {

    public function tableName()	{
        return 'bank';
    }

    public function rules()	{
        return array(
            array('title, position', 'required'),
			array('license', 'numerical', 'integerOnly'=>true),
			array('name, url', 'length', 'max'=>128),
			array('title', 'length', 'max'=>256),
			array('position', 'length', 'max'=>10),
			array('status', 'length', 'max'=>7)        );
    }

    /**
    * @return array relational rules.
    */
    protected function _baseRelations()	{
        return array(
            'bankBranches' => array(self::HAS_MANY, 'BankBranch', 'bank_id'),
            'bankCurrencies' => array(self::HAS_MANY, 'BankCurrency', 'bank_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => 'Name',
            'title' => 'Title',
            'url' => 'Url',
            'license' => 'License',
            'position' => 'Position',
            'status' => 'Status',
        );
    }


}
