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
class CBank extends ActiveRecord {

    public function tableName()	{
        return 'bank';
    }

    public function rules()	{
        return array(
            array('title, position', 'required'),
			array('license', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>256),
			array('position', 'length', 'max'=>10),
			array('status', 'length', 'max'=>7)        );
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
            'id' => 'ID',
            'title' => 'Title',
            'license' => 'License',
            'position' => 'Position',
            'status' => 'Status',
        );
    }


}
