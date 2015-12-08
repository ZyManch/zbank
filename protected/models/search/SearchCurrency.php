<?php

/**
* This is the model class for table "currency".
*
* The followings are the available columns in table 'currency':
    * @property string $id
    * @property string $title
    * @property string $sign
    * @property string $status
*/
class SearchCurrency extends CCurrency {

    public function __construct($scenario = 'search') {
        parent::__construct($scenario);
    }

    public function rules()	{
        return array(
            array('id, title, sign, status', 'safe', 'on'=>'search'),
        );
    }

    public function search() {

        $criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('sign',$this->sign,true);
		$criteria->compare('status',$this->status,true);

        return new CActiveDataProvider('Currency', array(
            'criteria'=>$criteria,
            'pagination'=>array('pageSize'=>40)
        ));
    }

    public function save() {
        throw new Exception('Its search only model');
    }

}
