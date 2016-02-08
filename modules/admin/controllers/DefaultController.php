<?php

namespace admin\controllers;

use Yii;
use admin\Module;
use luya\helpers\Url;
use yii\helpers\Json;

class DefaultController extends \admin\base\Controller
{
    public $disablePermissionCheck = true;

    public function actionIndex()
    {
        // register auth token
        $this->view->registerJs("var authToken='".Yii::$app->adminuser->identity->authToken ."';", \luya\web\View::POS_HEAD);
        $this->view->registerJs("var homeUrl='".Url::home(true)."';", \luya\web\View::POS_HEAD);
        // register admin js translations from module
        $this->view->registerJs('var i18n=' . Json::encode($this->module->jsTranslations), \luya\web\View::POS_HEAD);
        // Init ElementQueries after page load
        $this->view->registerJs('setTimeout( function() {ElementQueries.listen(); ElementQueries.init();}, 1500);', \luya\web\View::POS_LOAD);
        // return and render index view file
        return $this->render('index');
    }

    public function actionDashboard()
    {
        return $this->renderPartial('dashboard.php');
    }

    public function actionLogout()
    {
        Yii::$app->adminuser->logout();
        return $this->redirect(['/admin/login/index']);
    }

    public function colorizeValue($value, $displayValue = false)
    {
        $text = ($displayValue) ? $value : 'AN';
        if ($value) {
            return '<span style="color:green;">'.$text.'</span>';
        }

        return '<span style="color:red;">Aus</span>';
    }
}
