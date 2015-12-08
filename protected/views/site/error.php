<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	'Error',
);
?>
<div class="row">
    <div class="col-xs-12">
        <div class="page-header">
            <h1>Error <?php echo $code; ?></h1>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <?php echo CHtml::encode($message); ?>
        </div>
    </div>
</div>