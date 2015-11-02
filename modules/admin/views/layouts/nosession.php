<?php
use \yii\helpers\Html;
$this->beginPage();



?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?= Yii::$app->siteTitle; ?> // Login // <?= luya\Module::VERSION; ?></title>
    <style>
        body {
            background: url('<?= $this->getAssetUrl('admin\assets\Login'); ?>/img/login-splash/<?= rand(1, 13) ?>.jpg') no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }
    </style>
    <?php $this->head() ?>

    <?= Html::csrfMetaTags() ?>
</head>
<body>
    <?php $this->beginBody() ?>
    <?php echo $content; ?>
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>