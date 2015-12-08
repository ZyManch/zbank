<?php

/**
* This is the model class for table "bank_branch".
*
* The followings are the available columns in table 'bank_branch':
    * @property string $id
    * @property string $bank_id
    * @property string $city_id
    * @property string $address
    * @property string $latitude
    * @property string $longitude
    * @property string $status
*/
class SearchBankBranch extends CBankBranch {

    public function __construct($scenario = 'search') {
        parent::__construct($scenario);
    }

    public function rules()	{
        return array(
            array('id, bank_id, city_id, address, latitude, longitude, status', 'safe', 'on'=>'search'),
        );
    }

    public function search() {

        $criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('bank_id',$this->bank_id,true);
		$criteria->compare('city_id',$this->city_id,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('latitude',$this->latitude,true);
		$criteria->compare('longitude',$this->longitude,true);
		$criteria->compare('status',$this->status,true);

        return new CActiveDataProvider('BankBranch', array(
            'criteria'=>$criteria,
            'pagination'=>array('pageSize'=>40)
        ));
    }

    public function save() {
        throw new Exception('Its search only model');
    }

}
