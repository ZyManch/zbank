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
*/
class <?php echo $modelClass; ?> extends C<?php echo $modelClass; ?> {


}
