<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php\n"; ?>
/* @var $this <?php echo $this->getControllerClass(); ?> */
/* @var $model <?php echo $this->getModelClass(); ?> */


?>

<div class="wrapper wrapper-content">
    <div class="col-xs-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Создание <?php echo $this->modelClass; ?></h5>
            </div>
            <div class="ibox-content">
                <?php echo "<?php \$this->renderPartial('_form', array('model'=>\$model)); ?>"; ?>
            </div>
        </div>
    </div>
</div>

