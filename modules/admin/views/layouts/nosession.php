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

    <body class="login">
        <?php $this->beginBody() ?>

        <?php echo $content; ?>

        <script type="text/javascript"> var adminAsset = "<?=$this->getAssetUrl("admin\Asset");?>"; </script>
        <?php $this->endBody() ?>

        <script type="text/javascript">
            jQuery( function() { loginBackground({
                imagePath: adminAsset + "/img/backgrounds/bg_",
                imageCount: 6
            }); } );
        </script>
    </body>
</html>
<?php $this->endPage() ?>