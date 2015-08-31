<html>
    <head>
        <title>Luya &mdash; <?= $this->title; ?></title>
        <?php $this->head() ?>
    </head>
    <body>
    <?php $this->beginBody() ?>
        <?php echo $content; ?>
    <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>