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

        <title>Login | LUYA CMS</title>

        <?php $this->head() ?>

        <?= Html::csrfMetaTags() ?>
    </head>

    <body class="login" data-image-path="<?= $this->getAssetUrl("admin\Asset") ?>/img/backgrounds/bg_">
        <?php $this->beginBody() ?>

        <?php echo $content; ?>

        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
