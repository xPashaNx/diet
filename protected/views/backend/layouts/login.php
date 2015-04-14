<!DOCTYPE html>
<html lang="ru">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin/form.css" />
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>
<body>
    <div id="wrapper">
        <div class="bodyr login">
            <div class="container">
                <?php echo $content; ?>
            </div>
        </div>
        <div class="clear"></div>
        <div class="prokladka"></div>
    </div>
</body>
</html>