<?php
/**
 * This is the template for generating the model class of a specified table.
 * - $this: the ModelCode object
 * - $tableName: the table name for this class (prefix is already removed if necessary)
 * - $modelClass: the model class name
 * - $columns: list of table columns (name=>CDbColumnSchema)
 * - $labels: list of attribute labels (name=>label)
 * - $rules: list of validation rules
 * - $relations: list of relations (name=>relation declaration)
 */
?>
<?php echo "<?php\n"; ?>

/**
* This is the model class for table "<?php echo $tableName; ?>".
*
* The followings are the available columns in table '<?php echo $tableName; ?>':
<?php foreach($columns as $column): ?>
    * @property <?php echo $column->type.' $'.$column->name."\n"; ?>
<?php endforeach; ?>
<?php if(!empty($relations)): ?>
    *
    * The followings are the available model relations:
    <?php foreach($relations as $name=>$relation): ?>
        * @property <?php
        if (preg_match("~^array\(self::([^,]+), '([^']+)', '([^']+)'\)$~", $relation, $matches))
        {
            $relationType = $matches[1];
            $relationModel = $matches[2];

            switch($relationType){
                case 'HAS_ONE':
                    echo $relationModel.' $'.$name."\n";
                    break;
                case 'BELONGS_TO':
                    echo $relationModel.' $'.$name."\n";
                    break;
                case 'HAS_MANY':
                    echo $relationModel.'[] $'.$name."\n";
                    break;
                case 'MANY_MANY':
                    echo $relationModel.'[] $'.$name."\n";
                    break;
                default:
                    echo 'mixed $'.$name."\n";
            }
        }
        ?>
    <?php endforeach; ?>
<?php endif; ?>
*/
class Search<?php echo $modelClass; ?> extends C<?php echo $modelClass; ?> {

    public function __construct($scenario = 'search') {
        parent::__construct($scenario);
    }

    public function rules()	{
        return array(
            array('<?php echo implode(', ', array_keys($columns)); ?>', 'safe', 'on'=>'search'),
        );
    }

    public function search() {

        $criteria=new CDbCriteria;

<?php
        foreach($columns as $name=>$column)
        {
            if($column->type==='string')
            {
                echo "\t\t\$criteria->compare('$name',\$this->$name,true);\n";
            }
            else
            {
                echo "\t\t\$criteria->compare('$name',\$this->$name);\n";
            }
        }
        ?>

        return new CActiveDataProvider('<?php echo $modelClass; ?>', array(
            'criteria'=>$criteria,
            'pagination'=>array('pageSize'=>40)
        ));
    }

    public function save() {
        throw new Exception('Its search only model');
    }

}
