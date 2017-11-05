<?php
use app\assets\ResourcesAsset;
use luya\helpers\Url;
use luya\cms\widgets\LangSwitcher;

ResourcesAsset::register($this);

/* @var $this luya\web\View */
/* @var $content string */

$this->beginPage();
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->composition->language; ?>">
    <head>
        <meta charset="UTF-8" />
        <meta name="robots" content="index, follow" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?= $this->title; ?></title>
        <?php $this->head() ?>
    </head>
    <body>
    <?php $this->beginBody() ?>
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="https://luya.io" target="_blank" >
                    <img alt="luya.io" src="<?= $this->publicHtml; ?>/images/luya_logo_flat_icon.png" height="20px">
                </a>
            </div>
            <div>
                <ul class="nav navbar-nav">
                <?php foreach (Yii::$app->menu->findAll(['depth' => 1, 'container' => 'default']) as $item): /* @var $item \luya\cms\menu\Item */ ?>
                    <li <?php if ($item->isActive): ?>class="active"<?php endif;?>>
                        <a href="<?= $item->link; ?>"><?= $item->title; ?></a>
                    </li>
                <?php endforeach; ?>
                </ul>
                <?= LangSwitcher::widget([
                    'listElementOptions' => ['class' => 'nav navbar-nav navbar-right hidden-xs'],
                    'linkLabel' => function ($lang) {
                        return strtoupper($lang['short_code']);
                    }
                ]); ?>
            </div>
        </div>
    </nav>
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
                    <?php foreach (Yii::$app->menu->current->teardown as $item): /* @var $item \luya\cms\menu\Item */ ?>
                    <li><a href="<?= $item->link; ?>"><?= $item->title; ?></a>
                    <?php endforeach; ?>
                </ol>
            </div>
        
            <?php if (count(Yii::$app->menu->getLevelContainer(2)) > 0): ?>
            <div class="col-md-3">
                    <ul class="nav nav-pills nav-stacked">
                        <?php foreach (Yii::$app->menu->getLevelContainer(2) as $child): /* @var $child \luya\cms\menu\Item */ ?>
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
                <ul>
                    <li>This website is made with <a href="https://luya.io" target="_blank">LUYA</a></li>
                    <li><a href="https://github.com/luyadev/luya" target="_blank"><i class="fa fa-github"></i></a></li>
                    <li><a href="https://twitter.com/luyadev" target="_blank"><i class="fa fa-twitter"></i></a></li>
                    <li><a href="https://www.youtube.com/channel/UCfGs4sHk-D3swX0mhxv98RA" target="_blank"><i class="fa fa-youtube"></i></a></li>
                </ul>
        </div>
    </footer>
    <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
