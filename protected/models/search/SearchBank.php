<?php

/**
* This is the model class for table "bank".
*
* The followings are the available columns in table 'bank':
    * @property string $id
    * @property string $title
    * @property integer $license
    * @property string $position
    * @property string $status
*/
class SearchBank extends CBank {

    public function __construct($scenario = 'search') {
        parent::__construct($scenario);
    }

    public function rules()	{
        return array(
            array('id, title, license, position, status', 'safe', 'on'=>'search'),
        );
    }

    public function search() {

        $criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('license',$this->license);
		$criteria->compare('position',$this->position,true);
		$criteria->compare('status',$this->status,true);

        return new CActiveDataProvider('Bank', array(
            'criteria'=>$criteria,
            'pagination'=>array('pageSize'=>40)
        ));
    }

    public function save() {
        throw new Exception('Its search only model');
    }

}
