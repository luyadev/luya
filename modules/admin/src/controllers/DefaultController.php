<?php

namespace luya\admin\controllers;

use Yii;
use luya\admin\Module;
use luya\helpers\Url;
use yii\helpers\Json;
use luya\admin\base\Controller;
use luya\TagParser;

/**
 * Administration Controller provides, dashboard, logout and index.
 *
 * @author Basil Suter <basil@nadar.io>
 */
class DefaultController extends Controller
{
    public $disablePermissionCheck = true;
    
    /**
     * Yii initializer. Find assets to register, and add them into the view if they are not ignore by $skipModuleAssets.
     */
    public function init()
    {
        // call parent
        parent::init();
    
        // get controller based assets
        foreach ($this->module->assets as $class) {
            $this->registerAsset($class);
        }
    }

    public function actionIndex()
    {
        // register auth token
        $this->view->registerJs("var authToken='".Yii::$app->adminuser->identity->authToken ."';", \luya\web\View::POS_HEAD);
        $this->view->registerJs("var homeUrl='".Url::home(true)."';", \luya\web\View::POS_HEAD);
        // register admin js translations from module
        $this->view->registerJs('var i18n=' . Json::encode($this->module->jsTranslations), \luya\web\View::POS_HEAD);
        // Init ElementQueries after page load
        // $this->view->registerJs('setTimeout( function() {ElementQueries.listen(); ElementQueries.init();}, 1500);', \luya\web\View::POS_LOAD);
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
        $text = ($displayValue) ? $value : Module::t('debug_state_on');
        if ($value) {
            return '<span style="color:green;">'.$text.'</span>';
        }

        return '<span style="color:red;">'.Module::t('debug_state_off').'</span>';
    }
    
    public function getTags()
    {
        return TagParser::getInstantiatedTagObjects();
    }
}
