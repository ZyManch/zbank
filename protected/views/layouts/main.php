<?php
/**
 * @var $this Controller
 */
$miniNavbar =  (isset($_COOKIE['mini-menu']) && $_COOKIE['mini-menu']);
if ($miniNavbar) {
    Yii::app()->clientScript->registerScript('mini-menu','SmoothlyMenu()');
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru" class="gt-ie8 gt-ie9 not-ie">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <base href="/"/>
    <?php
    // http://infinite-woodland-5276.herokuapp.com/index.html
    $clientScript = Yii::app()->clientScript;
    $clientScript->registerCssFile('/css/bootstrap.min.css');
    $clientScript->registerCssFile('/css/font-awesome.css');
    $clientScript->registerCssFile('/css/styles.css');
    $clientScript->registerCssFile('/css/style.css');


    $clientScript->registerCoreScript('jquery');
    $clientScript->registerScriptFile('/js/bootstrap.min.js');
    ?>
    <!--[if lt IE 9]>
    <script src="/js/ie.min.js"></script>
    <![endif]-->

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body class="skin-3">
    <div id="wrapper">


        <div id="page-wrapper" class="gray-bg">


            <?php if (Yii::app()->user->hasErrorFlash()):?>
                <div class="row">
                    <div class="alert alert-danger">
                        <?php echo Yii::app()->user->getErrorFlash();?>
                    </div>
                </div>
            <?php endif;?>
            <?php if (Yii::app()->user->hasSuccessFlash()):?>
                <div class="row">
                    <div class="alert alert-success">
                        <?php echo Yii::app()->user->getSuccessFlash();?>
                    </div>
                </div>
            <?php endif;?>

            <?php echo $content; ?>
        </div>

    </div>
</body>
</html>
