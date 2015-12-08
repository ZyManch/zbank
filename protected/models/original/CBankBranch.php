<?php

/**
* This is the model class for table "bank_branch".
*
* The followings are the available columns in table 'bank_branch':
    * @property string $id
    * @property string $bank_id
    * @property string $city_id
    * @property string $address
    * @property string $phones
    * @property string $latitude
    * @property string $longitude
    * @property string $working_hours
    * @property string $status
    *
    * The followings are the available model relations:
        * @property Bank $bank
        * @property City $city
*/
class CBankBranch extends ActiveRecord {

    public function tableName()	{
        return 'bank_branch';
    }

    public function rules()	{
        return array(
            array('bank_id, city_id, address, phones, latitude, longitude', 'required'),
			array('bank_id, city_id, latitude, longitude', 'length', 'max'=>10),
			array('status', 'length', 'max'=>7),
			array('working_hours', 'safe')        );
    }

    /**
    * @return array relational rules.
    */
    protected function _baseRelations()	{
        return array(
            'bank' => array(self::BELONGS_TO, 'Bank', 'bank_id'),
            'city' => array(self::BELONGS_TO, 'City', 'city_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'bank_id' => 'Bank',
            'city_id' => 'City',
            'address' => 'Address',
            'phones' => 'Phones',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'working_hours' => 'Working Hours',
            'status' => 'Status',
        );
    }


}
