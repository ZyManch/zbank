<?php
/**
 * Created by PhpStorm.
 * User: Helen
 * Date: 08.03.2015
 * Time: 1:06
 * @var $this Controller
 */
?>

<div class="row border-bottom">
    <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">


        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
            <?php foreach (Yii::app()->user->getSystemModules() as $systemModule):?>
                <?php foreach ($systemModule->getMainMenuLeftItems() as $menu):?>
                    <?php if (isset($menu['template'])):?>
                        <?php $this->renderPartial($menu['template'],isset($menu['attributes']) ? $menu['attributes'] : array());?>
                    <?php else:?>
                        <?php echo $menu;?>
                    <?php endif;?>
                <?php endforeach;?>
            <?php endforeach;?>
        </div>
        <ul class="nav navbar-top-links navbar-right">
            <?php foreach (Yii::app()->user->getSystemModules() as $systemModule):?>
                <?php foreach ($systemModule->getMainMenuRightItems() as $menu):?>
                    <?php if (isset($menu['template'])):?>
                        <?php $this->renderPartial($menu['template'],isset($menu['attributes']) ? $menu['attributes'] : array());?>
                    <?php else:?>
                        <?php echo $menu;?>
                    <?php endif;?>
                <?php endforeach;?>
            <?php endforeach;?>

        </ul>

    </nav>
</div>
