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
class C<?php echo $modelClass; ?> extends <?php echo $this->baseClass; ?> {

    public function tableName()	{
        return '<?php echo $tableName; ?>';
    }

    public function rules()	{
        return array(
            <?php echo implode(",\n\t\t\t",$rules);?>
        );
    }

    /**
    * @return array relational rules.
    */
    protected function _baseRelations()	{
        return array(
<?php foreach($relations as $name=>$relation): ?>
            <?php echo "'$name' => $relation,\n"; ?>
<?php endforeach; ?>
        );
    }

    public function attributeLabels() {
        return array(
<?php foreach($labels as $name=>$label): ?>
            <?php echo "'$name' => '$label',\n"; ?>
<?php endforeach; ?>
        );
    }

<?php if($connectionId!='db'):?>

        public function getDbConnection() {
            return Yii::app()-><?php echo $connectionId ?>;
        }

<?php endif?>

}
