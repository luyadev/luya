<?php
    use \Yii;
    $user = new \admin\components\User();
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html ng-app="zaa">
<head>
    <title>admin!2.0</title>
    <?php $this->head() ?>
    <script>
    var authToken = '<?=$user->getIdentity()->authToken;?>';
    </script>
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
                <a href="<?= \Yii::$app->urlManager->createUrl(['admin/default/logout']); ?>" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </div>
</div>

<div class="container">

    <div ng-controller="MenuController" style="margin-top:20px;">
        <div class="navbar navbar-default" role="navgiation">
            <ul ng-repeat="item in items" class="nav navbar-nav">
                <li><a ng-click="click(item.id, $event)" style="cursor:pointer;"><i class="fa {{item.icon}}"></i> {{item.alias}}</a></li>
            </ul>
        </div>
    </div>

    <div ui-view>
    <?php echo $content; ?>
    </div>
</div>
<div class="container">
    <hr />
    <p><span class="small">made with love in Basel, Münchenstein, Switzerland</span> | Zephir Software Design AG</p>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
