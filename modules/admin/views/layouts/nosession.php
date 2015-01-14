<?php
    use \yii\helpers\Html;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
<head>
    <title>admin!2.0</title>
    <?php $this->head() ?>
    <?= Html::csrfMetaTags() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="container" style="margin-top:20px;">
    <div class="row">
        <div class="col-md-6">
            <img src="<?=$this->getAssetUrl("admin\Asset");?>/img/zephir-logo.png" />
        </div>
        <div class="col-md-6" style="line-height:60px;">
            <div class="pull-right">
                Register? No way!
            </div>
        </div>
    </div>
</div>

<div class="container">
    <hr />
    <?php echo $content; ?>
    <hr />
    <p>&copy; Zephir Software Design AG</p>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
