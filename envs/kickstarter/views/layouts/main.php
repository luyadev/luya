<?php

use \yii\helpers\Url;

$composition = Yii::$app->composition;
$links = Yii::$app->links;
?>
<html lang="<?= $composition->getKey('langShortCode'); ?>">
    <head>
        <title>Luya &mdash; <?= $this->title; ?></title>
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
        <base href="<?= Url::base(true); ?>/" />
        <?php $this->head() ?>
    </head>
    <body>
    <?php $this->beginBody() ?>
        <div id="header">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <h1>Luya Website <small>on <?= Url::base(true); ?></small></h1>
                    </div>
                    <div class="col-md-4">
                        <div class="git pull-right">
                            <a href="https://github.com/zephir/luya" target="_blank" alt="Luya on GitHub" title="Luya on GitHub"><i class="fa fa-github fa-4x"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="nav">
            <div class="container">
                <ul>
                    <?php foreach ($links->findByArguments(['cat' => 'default', 'lang' => $composition->getKey('langShortCode'), 'parent_nav_id' => 0]) as $item): ?>
                        <li class="<?= ($links->activeUrl == $item['url']) ? "active" : ""; ?>"><a href="<?= $composition->getFull() . $item['url'];?>"><?= $item['title']; ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <div id="content">
            <?= $content; ?>
        </div>
        <div id="footer">
            <div class="container divider">
                <h4>&copy <?= date("Y"); ?> by Luya</h4>
            </div>
        </div>
    <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>