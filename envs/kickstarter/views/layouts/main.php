<?php
use app\assets\ResourcesAsset;
use luya\helpers\Url;

ResourcesAsset::register($this);

/* @var $this luya\web\View */
/* @var $content string */

$this->beginPage();
?>
<html lang="<?= Yii::$app->composition->language; ?>">
    <head>
        <meta charset="UTF-8" />
        <meta name="robots" content="index, follow" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>LUYA &mdash; <?php echo $this->title; ?></title>
        <?php $this->head() ?>
    </head>
    <body>
    <?php $this->beginBody() ?>
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="https://luya.io" target="_blank" >
                    <img alt="Brand" src="<?= $this->publicHtml; ?>/images/luya_logo_flat_icon.png" height="20px">
                </a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                <?php foreach (Yii::$app->menu->find()->where(['parent_nav_id' => 0, 'container' => 'default'])->all() as $item): ?>
                    <li <?php if($item->isActive): ?>class="active"<?php endif;?>>
                        <a href="<?= $item->link; ?>"><?= $item->title; ?></a>
                    </li>
                <?php endforeach; ?>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="https://github.com/luyadev/luya" target="_blank"><i class="fa fa-github"></i></a></li>
                    <li><a href="https://twitter.com/luyadev" target="_blank"><i class="fa fa-twitter"></i></a></li>
                    <li><a href="https://www.youtube.com/channel/UCfGs4sHk-D3swX0mhxv98RA" target="_blank"><i class="fa fa-youtube"></i></a></li>
                </ul>
            </div>
        </div>
    </nav>
        
    <div style="margin-top:70px;"></div>
        
        
        
    <div class="container" id="content">
    
        <!-- /* DELETE ME -->    
        <div class="row" style="margin-bottom: 20px;">
            <div class="col-md-12">
                <div style="background-color:#9ccc65;" class="jumbotron">
                        <?= Yii::t('app', 'kickstarter_success'); ?>
                        <?= Yii::t('app', 'kickstarter_admin_link', ['link' => Url::toInternal(['admin/default/index']), true]); ?>
                </div>
            </div>
        </div>
        <!-- DELETE ME */ -->
        
        <div class="row">
            <div class="col-md-12">
                <ol class="breadcrumb">
                    <?php foreach (Yii::$app->menu->current->teardown as $item): ?>
                    <li><a href="<?= $item->link; ?>"><?= $item->title; ?></a>
                    <?php endforeach; ?>
                </ol>
            </div>
        
            <?php if (count(Yii::$app->menu->getLevelContainer(2)) > 0): ?>
            <div class="col-md-3">
                    <ul class="nav nav-pills nav-stacked">
                        <?php foreach (Yii::$app->menu->getLevelContainer(2) as $child): ?>
                        <li <?php if ($child->isActive): ?>class="active" <?php endif; ?>><a href="<?= $child->link; ?>"><?= $child->title; ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="col-md-9">
                    <?= $content; ?>
                </div>
            <?php else: ?>
                <div class="col-md-12">
                    <?= $content; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <footer class="footer">
        <div class="container">
            <p class="text-muted">This website is made with <a href="https://luya.io" target="_blank">LUYA</a>.</p>
        </div>
    </footer>
    <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
