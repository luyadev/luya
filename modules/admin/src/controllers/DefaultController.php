<?php

namespace luya\admin\controllers;

use Yii;
use luya\admin\Module;
use luya\helpers\Url;
use yii\helpers\Json;
use luya\admin\base\Controller;
use luya\TagParser;
use luya\web\View;
use luya\helpers\ArrayHelper;

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
        $this->view->registerJs("var authToken='".Yii::$app->adminuser->identity->authToken ."';", View::POS_HEAD);
        $this->view->registerJs("var homeUrl='".Url::home(true)."';", View::POS_HEAD);
        $this->view->registerJs('var i18n=' . Json::encode($this->module->jsTranslations), View::POS_HEAD);
        return $this->render('index');
    }

    public function actionDashboard()
    {
    	$items = [];
    	foreach (Yii::$app->adminModules as $module) {
    		foreach ($module->dashboardObjects as $config) {
    			$items[] = Yii::createObject(ArrayHelper::merge(['class' => '\luya\admin\dashboards\DefaultObject'], $config));
    		}
    	}
        return $this->renderPartial('dashboard', [
        	'items' => $items,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->adminuser->logout();
        return $this->redirect(['/admin/login/index', 'logout' => true]);
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
