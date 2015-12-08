<?php
/**
 * Created by PhpStorm.
 * User: ZyManch
 * Date: 07.06.14
 * Time: 14:12
 */
class WebUser extends CWebUser {

    const FLASH_SQL = 'sql';
    const FLASH_SUCCESS = 'success';
    const FLASH_ERROR = 'error';

    protected $_user;

    public $guestName='Гость';

    protected $_systemModules;

    /**
     * @return User
     */
    public function getUser() {
        if (!$this->id) {
            return null;
        }
        if ($this->_user) {
            return $this->_user;
        }
        $this->_user = User::model()->resetScope()->findByPk($this->id);
        if (!$this->_user || $this->_user->status != User::STATUS_ACTIVE) {
            $this->logout();
            Yii::app()->request->redirect('user/login');
        }
        return $this->_user;
    }

    /**
     * @return AbstractUserModule[]
     */
    public function getSystemModules() {
        if ($this->isGuest) {
            return $this->_getGuestSystemModules();
        } else {
            return $this->getUser()->getEnabledUserModules();
        }
    }

    public function getMainMenuItems() {
        $result = array();
        foreach ($this->getSystemModules() as $module) {
            foreach ($module->getMainMenuItems() as $key => $menu) {
                if (is_numeric($key)) {
                    $result[] = $menu;
                } else if (!isset($result[$key])) {
                    $result[$key] = $menu;
                } else {
                    $result[$key]['items'] = array_merge(
                        $result[$key]['items'],
                        $menu['items']
                    );
                }
            }
        }
        return $result;
    }

    /**
     * @return AbstractEditor
     */
    public function getEditor() {
        if ($this->isGuest) {
            return Editor::model()->findByPk(EDitor::DEFAULT_EDITOR_ID);
        }
        return $this->getUser()->company->editor;
    }

    protected function _getGuestSystemModules() {
        if (is_null($this->_systemModules)) {
            $this->_systemModules =  SystemModule::model()->with(
                array('guestSystemModules' => array('joinType'=>'INNER JOIN'))
            )->findAll(array('condition'=>'type="user"','order'=>'position DESC'));
        }
        return $this->_systemModules;
    }


    public function setSQLFlash($message) {
        $this->setFlash(self::FLASH_SQL,$message);
    }

    public function getSQLFlash() {
        return $this->getFlash(self::FLASH_SQL);
    }

    public function hasSQLFlash() {
        return $this->hasFlash(self::FLASH_SQL);
    }

    public function setSuccessFlash($category, $message, $params = array()) {
        $this->setFlash(self::FLASH_SUCCESS,Yii::t(
            $category,
            $message,
            $params
        ));
    }

    public function getSuccessFlash() {
        return $this->getFlash(self::FLASH_SUCCESS);
    }

    public function hasSuccessFlash() {
        return $this->hasFlash(self::FLASH_SUCCESS);
    }


    public function setErrorFlash($category, $message, $params = array()) {
        $this->setFlash(self::FLASH_ERROR,Yii::t(
            $category,
            $message,
            $params
        ));
    }

    public function getErrorFlash() {
        return $this->getFlash(self::FLASH_ERROR);
    }

    public function hasErrorFlash() {
        return $this->hasFlash(self::FLASH_ERROR);
    }

}