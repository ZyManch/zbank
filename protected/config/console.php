<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
    'language' => 'en',
    'import'=>array(
        'application.commands.*',
    ),
    'components'=>array(

    ),
    'commandMap' => array(
        'migrate' => array(
            'class' => 'vendor.yiiext.migrate-command.EMigrateCommand',
            'migrationTable' => 'migration',
            'applicationModuleName' => 'core',
            'migrationPath' => 'application.migrations',
        )
    )
);