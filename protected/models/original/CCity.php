<?php

/**
* This is the model class for table "city".
*
* The followings are the available columns in table 'city':
    * @property string $id
    * @property string $title
    * @property string $latitude
    * @property string $longitude
    *
    * The followings are the available model relations:
        * @property BankBranch[] $bankBranches
*/
class CCity extends ActiveRecord {

    public function tableName()	{
        return 'city';
    }

    public function rules()	{
        return array(
            array('title, latitude, longitude', 'required'),
			array('title', 'length', 'max'=>128),
			array('latitude, longitude', 'length', 'max'=>10)        );
    }

    /**
    * @return array relational rules.
    */
    protected function _baseRelations()	{
        return array(
            'bankBranches' => array(self::HAS_MANY, 'BankBranch', 'city_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'title' => 'Title',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
        );
    }


}
