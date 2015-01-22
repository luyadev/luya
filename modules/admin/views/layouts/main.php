<?php
    use \Yii;
    use \admin\Module as Admin;
    $user = Admin::getAdminUserData();
    $gravatar = "http://www.gravatar.com/avatar/".md5(strtolower(trim($user->email)))."?d=".urlencode('https://placeimg.com/60/60/animals&rand='.rand(1, 50))."&s=40";

    $this->beginPage()
?>

<!DOCTYPE html>

<html ng-app="zaa">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>LUYA CMS</title>

    <?php $this->head() ?>

    <script>
        var authToken = '<?=$user->getAuthToken();?>';
    </script>

</head>

<body>
    <?php $this->beginBody() ?>

    <div class="header" role="menubar">

        <div class="header__item header__item--left">

            <div class="logo">
                <img src="<?=$this->getAssetUrl("admin\AssetAdmin");?>/img/logo.png" role="img" alt="LUYA" />
            </div>

        </div><!-- ./header__left

     --><div class="header__item header__item--center">

            <nav class="modulenav" role="navigation" ng-controller="MenuController">

                <ul class="modulenav__list" role="menu">

                    <li class="modulenav__item" role="menuitem" ng-repeat="item in items" ng-class="getCurrent(item.id)" on-finish="onMenuFinish">

                        <a class="modulenav__link" role="link" data-label="{{item.alias}}" ng-click="click(item.id, $event)">
                            <span class="modulenav__icon fa fa-fw {{item.icon}}"></span>
                        </a> <!-- ./modulenav__link -->

                    </li> <!-- ./modulenav__item -->

                </ul> <!-- ./modulenav__list -->

            </nav> <!-- ./modulenav -->

        </div><!-- ./header__center

     --><div class="header__item header__item--right">

            <div class="user">
                <div class="user__front">
                    <img class="user__image" src="<?= $gravatar; ?>" role="img" width="60px" height="60px" alt="<?= $user->email ?>" />
                    <span class="user__name"><?= $user->email; ?></span>
                </div>
                <div class="user__back">
                    <a class="user__logout" href="<?= \Yii::$app->urlManager->createUrl(['admin/default/logout']); ?>" role="link"><span class="user__logouticon fa fa-sign-out"></span> Abmelden</a>
                </div>
            </div> <!-- ./user -->

        </div> <!-- ./header__right -->

    </div> <!-- ./header -->

    <div class="main">

        <div class="angular-replace" ui-view></div>

    </div> <!-- ./main -->


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
