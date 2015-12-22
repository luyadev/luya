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
        $this->view->registerJs("var authToken='".Yii::$app->adminuser->identity->authToken ."';", \luya\web\View::POS_HEAD);
        $this->view->registerJs('var i18n=' . Json::encode([
            'js_ngrest_rm_page' => Module::t('js_ngrest_rm_page'),
            'js_ngrest_rm_confirm' => Module::t('js_ngrest_rm_confirm'),
            'js_ngrest_error' => Module::t('js_ngrest_error'),
            'js_ngrest_rm_update' => Module::t('js_ngrest_rm_update'),
            'js_ngrest_rm_success' => Module::t('js_ngrest_rm_success'),
            'js_tag_exists' => Module::t('js_tag_exists'),
            'js_tag_success' => Module::t('js_tag_success'),
            'js_admin_reload' => Module::t('js_admin_reload'),
        ]), \luya\web\View::POS_HEAD);
        return $this->render('index');
    }

    public function actionDashboard()
    {
        return $this->renderPartial('dashboard.php');
    }

    public function actionLogout()
    {
        Yii::$app->adminuser->logout();

        return $this->redirect(Url::base(true).'/admin/login');
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
