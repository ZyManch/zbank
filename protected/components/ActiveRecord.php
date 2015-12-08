<?php
/**
 * Created by PhpStorm.
 * User: ZyManch
 * Date: 07.06.14
 * Time: 12:11
 */
class ActiveRecord extends CActiveRecord {

    static $_variants = array();

    const STATUS_ACTIVE = 'Active';
    const STATUS_BLOCKED = 'Blocked';
    const STATUS_DELETED = 'Deleted';
    const STATUS_CLOSED = 'Closed';

    public function behaviors() {
        if ($this->getScenario() == 'search') {
            return array(
                'ERememberFiltersBehavior' => array(
                    'class' => 'vendor.pentium10.yii-remember-filters-gridview.components.ERememberFiltersBehavior',
                    // 'defaults'=>array(),           /* optional line */
                    // 'defaultStickOnClear'=>false   /* optional line */
                ),
                /*
                'EAdvancedArBehavior' => array(
                    'class' => 'EAdvancedArBehavior',
                ),*/
            );
        }
        return array();
    }

    protected function _hasStatus() {
        return in_array('status', $this->tableSchema->columnNames);
    }


    public function defaultScope() {
        $t = $this->getTableAlias(false, false);
        $conditions = array();
        if ($this->_hasStatus()) {
            $conditions[] = $t.'.status  = "'.self::STATUS_ACTIVE.'"';
        }
        if (!$conditions) {
            return array();
        }
        return array(
            'condition' => implode(' AND ',$conditions),
        );
    }

    public function getErrorsAsText() {
        $result = array();
        foreach($this->getErrors() as $key => $errors) {
            $result[] = $key.': '.implode(',',$errors);
        }
        return implode('. ', $result);
    }


    public static function model($className=null) {
        if (is_null($className)) {
            $className = get_called_class();
        }
        return parent::model($className);
    }

    public function delete() {
        if (!$this->_hasStatus()) {
            return parent::delete();
        }
        $this->status = self::STATUS_DELETED;
        return $this->save(false);
    }

    public function relations() {
        return array_merge(
            $this->_baseRelations(),
            $this->_extendedRelations()
        );
    }

    protected function _baseRelations() {
        return array();
    }

    protected function _extendedRelations() {
        return array();
    }

    public static function loadConstants() {
        try {
            $cacheKey = 'constants_' . get_called_class();
            if (!isset(Yii::app()->cache[$cacheKey])) {
                $pageTypes = self::model()->findAll();
                $constants = array();
                foreach ($pageTypes as $pageType) {
                    $constants[$pageType->constant] = $pageType->id;
                }
                Yii::app()->cache[$cacheKey] = $constants;
            } else {
                $constants = Yii::app()->cache[$cacheKey];
            }
            foreach ($constants as $key => $value) {
                define($key, $value);
            }
        } catch (Exception $e) {
            return false;
        }
        return true;
    }

    public static function getVariants($filters = array()) {
        $className = get_called_class();
        $cacheKey = $className.md5(json_encode($filters));
        if (isset(self::$_variants[$cacheKey])) {
            return self::$_variants[$cacheKey];
        }
        $criteria = $className::_getVariantsCriteria($filters);

        $items = $className::model()->findAll($criteria);
        if (!$items) {
            return array();
        }
        $keys = array_keys($items[0]->getAttributes());
        $keyName = $keys[0];
        $valName = $keys[1];
        $result = array();
        /** @var ActiveRecord $item */
        foreach ($items as $item) {
            $skip = false;
            foreach ($filters as $name => $val) {
                if (is_array($val)) {
                    if (!in_array($item->$name,$val)) {
                        $skip = true;
                        break;
                    }
                } else {
                    if ($item->$name != $val) {
                        $skip = true;
                        break;
                    }
                }
            }
            if (!$skip) {
                $result[$item->$keyName] = $item->$valName;
            }
        }
        return self::$_variants[$className] = $result;
    }

    protected static function _getVariantsCriteria($filters = array()) {
        $criteria = new CDbCriteria();
        $criteria->select = 'id, title';
        if ($filters) {
            $criteria->select.=','.implode(',',array_keys($filters));
        }
        $criteria->order = 'title';
        return $criteria;
    }
}