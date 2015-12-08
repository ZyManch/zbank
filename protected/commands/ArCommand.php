<?php
/**
 * Created by PhpStorm.
 * User: ZyManch
 * Date: 28.06.14
 * Time: 21:27
 */
class ArCommand extends CConsoleCommand {

    public $aliases = array(

    );

    public function run($args) {
        print "Init AR builder...\n";
        Yii::import('system.gii.*',true);
        Yii::import('system.gii.controllers.*',true);
        Yii::import('system.gii.generators.model.*',true);
        Yii::import('application.gii.tmodel.*',true);
        $tables = $this->_getTables();
        $model = new TmodelCode();
        $templatePath = Yii::getPathOfAlias('application.gii.tmodel.templates.default');
        /** @var CodeGenerator $controller */
        $module = new stdClass();
        $module->newDirMode = 0777;
        $module->newFileMode = 0777;
        $controller = Yii::createComponent(array(
            'class'=>'CodeGenerator',
            'templates'=>array('default' => $templatePath),
        ),'gii',$module);

        Yii::app()->setComponent('controller',$controller);
        print "Deleting old files...\n";
        $originalPath = Yii::getPathOfAlias('application.models.original');
        array_map('unlink', glob($originalPath."/*.php"));
        rmdir($originalPath);
        print "Generating new models...\n";
        foreach ($tables as $table) {
            $className = $this->_underscoreToCamelCase($table);
            if (isset($this->aliases[$className])) {
                $className = $this->aliases[$className];
            }
            $model->baseClass = 'ActiveRecord';
            $model->template = 'default';
            $model->tableName = $table;
            $model->modelClass = $className;
            $model->prepare();
            foreach ($model->files as $file) {
                $model->answers[md5($file->path)] = true;
            }
            $model->save();
        }
        exec('git add models');
        print "Done\n";
    }


    protected function _getTables() {
        $tables = Yii::app()->db->schema->getTables();
        $result = array();
        foreach($tables as $table) {
            $result[] = $table->name;
        }
        return $result;
    }

    protected function _underscoreToCamelCase($string) {
        $string = ucfirst($string);
        $func = function ($c) {
            return strtoupper($c[1]);
        };
        return preg_replace_callback('/_([a-z])/', $func, $string);
    }

}