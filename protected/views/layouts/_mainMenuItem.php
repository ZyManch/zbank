<?php
/**
 * Created by PhpStorm.
 * User: Helen
 * Date: 08.03.2015
 * Time: 20:29
 * @var $this Controller
 * @var $isTopMenu bool
 * @var $menu array
 */
$url =  CHtml::normalizeUrl($menu['url']);
?>
<?php if (isset($menu['template'])):?>
    <?php $this->renderPartial($menu['template'],isset($menu['attributes']) ? $menu['attributes'] : array());?>
<?php elseif (isset($menu['items']) && $menu['items']):?>
    <li>
        <a href="<?php echo CHtml::encode($url);?>">
            <?php if ($isTopMenu):?>
                <i class="fa fa-<?php if(isset($menu['icon'])):?><?php echo $menu['icon'];?><?php else:?>question<?php endif;?>"></i>
                <span class="nav-label"><?php echo CHtml::encode($menu['label']);?></span>
                <span class="fa arrow"></span>
            <?php else:?>
                <?php echo CHtml::encode($menu['label']);?>
            <?php endif;?>
        </a>
        <ul class="nav nav-second-level">
            <?php foreach ($menu['items'] as $item):?>
                <?php $this->renderPartial('//layouts/_mainMenuItem',array('menu'=>$item,'isTopMenu'=>false));?>
            <?php endforeach;?>
        </ul>
    </li>
<?php else:?>
    <li>
        <a href="<?php echo CHtml::encode($url);?>">
            <?php if ($isTopMenu):?>
                <i class="fa fa-<?php if(isset($menu['icon'])):?><?php echo $menu['icon'];?><?php else:?>question<?php endif;?>"></i>
                <span class="nav-label"><?php echo CHtml::encode($menu['label']);?></span>
            <?php else:?>
                <?php echo CHtml::encode($menu['label']);?>
            <?php endif;?>
        </a>
    </li>
<?php endif;?>