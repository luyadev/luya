<?php
use yii\helpers\Url;
?>
<html>
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
                    <div class="col-md-6">
                        <h1>Luya Website</h1>
                        <h2><?= Url::base(true); ?></h2>
                    </div>
                    <div class="col-md-6">
                        <div class="git pull-right">
                            <a href="https://github.com/zephir/luya" target="_blank" alt="Luya on GitHub" title="Luya on GitHub"><i class="fa fa-github fa-4x"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container" id="content">
            <div class="row">
                <div class="col-md-3"  id="nav">
                    <ul>
                    <?php foreach (Yii::$app->menu->find()->where(['parent_nav_id' => 0, 'container' => 'default'])->all() as $item): ?>
                        <li>
                            <a<? if($item->isActive): ?> class="active"<?endif;?> href="<?= $item->link; ?>"><?= $item->title; ?></a>
                            <? if($item->hasChildren()): ?>
                            <ul>
                                <? foreach($item->children as $child): ?>
                                    <li><a<? if($child->isActive): ?> class="active"<?endif;?> href="<?= $child->link; ?>">&raquo; <?= $child->title; ?></a></li>
                                    
                                    <? if($child->hasChildren()): ?>
                                    <ul>
                                        <? foreach($child->children as $grandChild): ?>
                                            <li><a<? if($grandChild->isActive): ?> class="active"<?endif;?> href="<?= $grandChild->link; ?>">&raquo; <?= $grandChild->title; ?></a>
                                        <? endforeach; ?>
                                    </ul>
                                    <? endif; ?>
                                    
                                <? endforeach; ?>
                            </ul>
                            <? endif; ?>
                        </li>
                    <?php endforeach; ?>
                    </ul>
                </ul>
                </div>
                <div class="col-md-9">
                    <?= $content; ?>
                </div>
            </div>
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