<? $this->beginPage(); ?>
<html>
    <head>
        <title>Luya &mdash; <?= $this->title; ?></title>
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
        <?php $this->head() ?>
    </head>
    <body>
    <?php $this->beginBody() ?>
        <div id="header">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <h1><?= Yii::$app->siteTitle; ?></h1>
                    </div>
                    <div class="col-md-6">
                        <div class="git pull-right">
                            <a href="https://github.com/zephir/luya" target="_blank" alt="Luya on GitHub" title="Luya on GitHub"><i class="fa fa-github fa-2x"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
        <!-- You can delete this line in your template! as this is only a luya information. -->
        <div style="background: #9ccc65; margin-top:20px;" class="container" id="yes">
            <div>
                <p style="padding:10px 10px; margin:0px;"><?= \luya\Module::t('luya', 'kickstarter_success'); ?></p>
            </div>
            <div>
                <p style="padding:10px 10px; margin:0px; font-weight:bold;"><?= \luya\Module::t('luya', 'kickstarter_admin_link', ['link' => \luya\helpers\Url::toInternal(['admin/default/index']), true]); ?></p>
            </div>
        </div>
        <div class="container" id="content">
            <div class="row">
                <ol class="breadcrumb">
                    <? foreach(Yii::$app->menu->current->teardown as $item): ?>
                    <li><a href="<?= $item->link; ?>"><?= $item->title; ?></a>
                    <? endforeach; ?>
                </ol>
            </div>
        
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
                <h4>&copy <?= date("Y"); ?> by <i>You</i> &amp; <i>Luya</i></h4>
            </div>
        </div>
    <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>