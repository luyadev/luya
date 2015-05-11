<?php
use \admin\Module as Admin;

$user = Admin::getAdminUserData();
$this->beginPage()
?>
<!DOCTYPE html>
<html ng-app="zaa" ng-controller="HtmlController">
<head>
    <meta charset="utf-8">
    <?php $this->head() ?>
    <script>
        var authToken = '<?=$user->getAuthToken();?>';
    </script>
</head>
<body>
<?php $this->beginBody() ?>
<body layout="column">
    <md-toolbar layout="row">
        <button ng-click="toggleSidenav('left')" hide-gt-sm class="md-icon-button menuBtn"><span class="md-visually-hidden">Menu</span></button>
        <h1 class="md-toolbar-tools" layout-align-gt-sm="center">Hello World</h1>
    </md-toolbar>
    <div layout="row" flex>
        <md-sidenav layout="column" class="md-sidenav-left md-whiteframe-z2" md-component-id="left" md-is-locked-open="$mdMedia('gt-sm')">
          asdfasdfds
        </md-sidenav>
        <div layout="column" flex id="content">
            <md-content layout="column" flex class="md-padding" ui-view>
                asdfasdf
            </md-content>
        </div>
    </div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>