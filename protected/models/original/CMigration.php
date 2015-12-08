<?php

/**
* This is the model class for table "migration".
*
* The followings are the available columns in table 'migration':
    * @property string $version
    * @property integer $apply_time
    * @property string $module
*/
class CMigration extends ActiveRecord {

    public function tableName()	{
        return 'migration';
    }

    public function rules()	{
        return array(
            array('version', 'required'),
			array('apply_time', 'numerical', 'integerOnly'=>true),
			array('version', 'length', 'max'=>255),
			array('module', 'length', 'max'=>32)        );
    }

    /**
    * @return array relational rules.
    */
    protected function _baseRelations()	{
        return array(
        );
    }

    public function attributeLabels() {
        return array(
            'version' => 'Version',
            'apply_time' => 'Apply Time',
            'module' => 'Module',
        );
    }


}
