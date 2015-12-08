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

<div class="row wrapper border-bottom white-bg page-heading">
    <h2>Администрирование <?php echo $this->pluralize($this->class2name($this->modelClass)); ?></h2>
    <div class="ibox-tools">

    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-xs-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><?php echo $this->pluralize($this->class2name($this->modelClass)); ?></h5>
                </div>
                <div class="ibox-content">
                    <p>
                    You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
                    or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
                    </p>


                    <?php echo "<?php"; ?> $this->widget('zii.widgets.grid.CGridView', array(
                        'id'=>'<?php echo $this->class2id($this->modelClass); ?>-grid',
                        'dataProvider'=>$model->search(),
                        'filter'=>$model,
                        'template'=>'{items} {summary} {pager}',
                        'itemsCssClass' => 'table table-hover',
                        'htmlOptions' => array('class'=>'project-list'),
                        'columns'=>array(
                    <?php
                    $count=0;
                    foreach($this->tableSchema->columns as $column)
                    {
                        if(++$count==7)
                            echo "\t\t\t\t/*\n";
                        echo "\t\t\t\t'".$column->name."',\n";
                    }
                    if($count>=7)
                        echo "\t\t\t\t*/\n";
                    ?>
                            array(
                                'class'=>'CButtonColumn',
                            ),
                        ),
                    )); ?>
                </div>
            </div>
        </div>
    </div>
</div>