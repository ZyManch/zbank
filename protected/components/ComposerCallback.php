<?php

/**
 * Class file
 *
 * @author Tobias Munk &lt;schmunk@usrbin.de&gt;
 * @link http://www.phundament.com/
 * @copyright Copyright &amp;copy; 2012 diemeisterei GmbH
 * @license http://www.phundament.com/license
 */

namespace components;
use Composer\Script\Event;

/**
 * ComposerCallback provides composer hooks
 *
 * This setup class triggers `./yiic migrate` at post-install and post-update.
 * For a package the class triggers `./yiic &lt;vendor/&lt;packageName&gt;-&lt;action&gt;` at post-package-install and
 * post-package-update.
 * See composer manual (http://getcomposer.org/doc/articles/scripts.md)
 *
 * Usage example
 *
 * config.php
 *     'params' =&gt; array(
        'composer.callbacks' =&gt; array(
            'post-update' =&gt; array('yiic', 'migrate'),
            'post-install' =&gt; array('yiic', 'migrate'),
            'yiisoft/yii-install' =&gt; array('yiic', 'webapp', realpath(dirname(__FILE__))),
        ),
    )
);

 * composer.json
 *   "scripts": {
 *      "pre-install-cmd": "config\\ComposerCallback::preInstall",
        "post-install-cmd": "config\\ComposerCallback::postInstall",
        "pre-update-cmd": "config\\ComposerCallback::preUpdate",
        "post-update-cmd": "config\\ComposerCallback::postUpdate",
        "post-package-install": [
        "config\\ComposerCallback::postPackageInstall"
        ],
        "post-package-update": [
        "config\\ComposerCallback::postPackageUpdate"
        ]
    }

 *
 *
 * @author Tobias Munk &lt;schmunk@usrbin.de&gt;
 * @package phundament.app
 * @since 0.7.1
 */

defined('YII_PATH') or define('YII_PATH', dirname(__FILE__).'/../../vendor/yiisoft/yii/framework');

class ComposerCallback
{
    /**
     * Displays welcome message
     * @static
     * @param \Composer\Script\Event $event
     */
    public static function preInstall(Event $event)
    {
        $composer = $event->getComposer();
        // do stuff
        echo "Phundament 3 Installer\n\n";
        echo " * download packages specified in composer.json
 * trigger composer callbacks\n\n";

        self::runHook('pre-install');
    }

    /**
     * Executes ./yiic migrate
     * @static
     * @param \Composer\Script\Event $event
     */
    public static function postInstall(Event $event)
    {
        self::runHook('post-install');
        echo "\n\nInstallation completed.\n\nThank you for choosing Phundament 3!\n\n";
    }

    /**
     * Displays welcome message
     *
     * @static
     * @param \Composer\Script\Event $event
     */
    public static function preUpdate(Event $event)
    {
        echo "Welcome to Phundament Installation 3 via composer\n\nUpdating your application to the lastest available packages...\n";
        self::runHook('pre-update');
    }

    /**
     * Executes ./yiic migrate
     *
     * @static
     * @param \Composer\Script\Event $event
     */
    public static function postUpdate(Event $event)
    {
        self::runHook('post-update');
        echo "\n\nUpdate completed.\n\n";
    }

    /**
     * Executes ./yiic &lt;vendor/&lt;packageName&gt;-&lt;action&gt;
     *
     * @static
     * @param \Composer\Script\Event $event
     */
    public static function postPackageInstall(PackageEvent  $event)
    {
        $installedPackage = $event->getOperation()->getPackage();
        $hookName = $installedPackage->getPrettyName().'-install';
        self::runHook($hookName);
    }

    /**
     * Executes ./yiic &lt;vendor/&lt;packageName&gt;-&lt;action&gt;
     *
     * @static
     * @param \Composer\Script\Event $event
     */
    public static function postPackageUpdate(PackageEvent  $event)
    {
        $installedPackage = $event->getOperation()->getTargetPackage();
        $commandName = $installedPackage->getPrettyName().'-update';
        self::runHook($commandName);
    }

    /**
     * Asks user to confirm by typing y or n.
     *
     * Credits to Yii CConsoleCommand
     *
     * @param string $message to echo out before waiting for user input
     * @return bool if user confirmed
     */
    public static function confirm($message)
    {
        echo $message . ' [yes|no] ';
        return !strncasecmp(trim(fgets(STDIN)), 'y', 1);
    }

    /**
     * Runs Yii command, if available (defined in config/console.php)
     */
    private static function runHook($name){
        $app = self::getYiiApplication();
        if ($app === null) return;

        if (isset($app->params['composer.callbacks'][$name])) {
            $args = $app->params['composer.callbacks'][$name];
            $app->commandRunner->addCommands(\Yii::getPathOfAlias('system.cli.commands'));
            $app->commandRunner->run($args);
        }
    }

    /**
     * Creates console application, if Yii is available
     */
    private static function getYiiApplication()
    {
        if (!is_file(YII_PATH.'/yii.php'))
        {
            return null;
        }

        require_once(YII_PATH.'/yii.php');

        spl_autoload_register(array('YiiBase', 'autoload'));

        if (\Yii::app() === null) {
            $config = require_once dirname(__FILE__).'/../config/console.php';
            $staticConfig = require_once dirname(__FILE__).'/../config/static_config.php';
            require_once dirname(__FILE__).'/../merge.php';
            $mergedConfig = array_merge_config($staticConfig, $config);
            if ($mergedConfig) {
                $app = \Yii::createConsoleApplication($mergedConfig);
            } else {
                throw new \Exception("File from CONSOLE_CONFIG not found");
            }
        } else {
            $app = \Yii::app();
        }
        return $app;
    }

}