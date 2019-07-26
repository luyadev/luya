<?php
use yii\helpers\Html;

\yii\bootstrap\BootstrapAsset::register($this);

/* @var $this luya\web\View */
/* @var $content string */
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody(); ?>

	<?php echo \luya\cms\widgets\LangSwitcher::widget([
	    'listElementOptions' => ['class' => 'langnav__list'],
	    'elementOptions' => ['class' => 'langnav__item'],
	    'linkOptions' => ['class' => 'langnav__link'],
	    'linkLabel' => function($lang) {
	        return strtoupper($lang['short_code']);
	    }
	]) ?>

    BLANK 2 THEME
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
