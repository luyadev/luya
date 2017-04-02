<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= Yii::$app->siteTitle; ?> &rsaquo; Login</title>
    <style>
        body {
            background: url('<?= $this->getAssetUrl('luya\admin\assets\Login'); ?>/img/luyaioworld.jpg') no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }
    </style>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
    <div style="display:block; padding-top:50px; text-align:center;">
        <img src="<?= $this->getAssetUrl('luya\admin\assets\Login'); ?>/img/luyalogo.png" />
    </div>
    <?php echo $content; ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>