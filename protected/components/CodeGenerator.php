<?php
/**
 * CCodeGenerator class file.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright 2008-2013 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

/**
 * CCodeGenerator is the base class for code generator classes.
 *
 * CCodeGenerator is a controller that predefines several actions for code generation purpose.
 * Derived classes mainly need to configure the {@link codeModel} property
 * override the {@link getSuccessMessage} method. The former specifies which
 * code model (extending {@link CCodeModel}) that this generator should use,
 * while the latter should return a success message to be displayed when
 * code files are successfully generated.
 *
 * @property string $pageTitle The page title.
 * @property string $viewPath The view path of the generator.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @package system.gii
 * @since 1.1.2
 */
class CodeGenerator extends CCodeGenerator implements IApplicationComponent {

    function getIsInitialized() {
        return true;
    }


}