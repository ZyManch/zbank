<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php\n"; ?>
/* @var $this <?php echo $this->getControllerClass(); ?> */
/* @var $model <?php echo $this->getModelClass(); ?> */

<?php
$nameColumn=$this->guessNameColumn($this->tableSchema->columns);
$label=$this->pluralize($this->class2name($this->modelClass));
?>


?>
<div class="wrapper wrapper-content">
    <div class="col-xs-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>View <?php echo $this->modelClass." #<?php echo \$model->{$this->tableSchema->primaryKey}; ?>"; ?></h5>
            </div>
            <div class="ibox-content">
                <?php echo "<?php"; ?> $this->widget('zii.widgets.CDetailView', array(
                'data'=>$model,
                'attributes'=>array(
                <?php
                foreach($this->tableSchema->columns as $column)
                    echo "\t\t'".$column->name."',\n";
                ?>
                ),
                )); ?>
            </div>
        </div>
    </div>
</div>

