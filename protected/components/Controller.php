<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $topMenu=array();

	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();

    public function init() {
        parent::init();
        $user = Yii::app()->user;
        $isGuest = $user->getIsGuest();
        $this->topMenu = array(
            array('label'=>'Home', 'url'=>array('dashboard/index')),
            array('label'=>'Account'.(!$isGuest ? ' ('.Yii::app()->user->name.')':''), 'items' => array(
                array('label'=>'Logout', 'url'=>array('user/logout'), 'visible'=>!$isGuest),
                array('label'=>'Login', 'url'=>array('user/login'), 'visible'=>$isGuest),
                array('label'=>'Register', 'url'=>array('user/register'), 'visible'=>$isGuest),
            ))
        );
    }


}