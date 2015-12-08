<?php

/**
* This is the model class for table "migration".
*
* The followings are the available columns in table 'migration':
    * @property string $version
    * @property integer $apply_time
    * @property string $module
*/
class SearchMigration extends CMigration {

    public function __construct($scenario = 'search') {
        parent::__construct($scenario);
    }

    public function rules()	{
        return array(
            array('version, apply_time, module', 'safe', 'on'=>'search'),
        );
    }

    public function search() {

        $criteria=new CDbCriteria;

		$criteria->compare('version',$this->version,true);
		$criteria->compare('apply_time',$this->apply_time);
		$criteria->compare('module',$this->module,true);

        return new CActiveDataProvider('Migration', array(
            'criteria'=>$criteria,
            'pagination'=>array('pageSize'=>40)
        ));
    }

    public function save() {
        throw new Exception('Its search only model');
    }

}
