<?php $this->beginPage(); ?>
    <!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title><?= Yii::$app->siteTitle; ?> &rsaquo; Login</title>
            <?php $this->head() ?>
        </head>
        <body class="login-screen">
            <?php $this->beginBody() ?>
                <?= $content; ?>
            <?php $this->endBody() ?>
        </body>
    </html>
<?php $this->endPage() ?>

