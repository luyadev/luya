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
use yii\helpers\Markdown;

/**
 * Administration Controller provides, dashboard, logout and index.
 *
 * @author Basil Suter <basil@nadar.io>
 */
class DefaultController extends Controller
{
    public $disablePermissionCheck = true;
    
    /**
     * @var string Path to the admin layout
     */
    public $layout = '@admin/views/layouts/main';
    
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
    	$tags = [];
    	foreach (TagParser::getInstantiatedTagObjects() as $name => $object) {
    		$tags[] = [
    			'name' => $name,
    			'example' => $object->example(),
    			'readme' => Markdown::process($object->readme()),
    		];
    	}
    	
        // register auth token
        //$this->view->registerJs("var authToken='".Yii::$app->adminuser->identity->authToken ."';", View::POS_HEAD);
        //$this->view->registerJs("var homeUrl='".Url::home(true)."';", View::POS_HEAD);
        $this->view->registerJs('var i18n=' . Json::encode($this->module->jsTranslations), View::POS_HEAD);
        //$this->view->registerJs('var helptags=' . Json::encode($tags), View::POS_HEAD);
        
        $this->view->registerJs('zaa.run(function($rootScope) { $rootScope.luyacfg = ' . Json::encode([
        	'authToken' => Yii::$app->adminuser->identity->authToken,
        	'homeUrl' => Url::home(true),
        	'i18n' => $this->module->jsTranslations,
        	'helptags' => $tags,
        ]). '; });', View::POS_END);
        
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
        if (!Yii::$app->adminuser->logout(false)) {
        	Yii::$app->session->destroy();
        }
        
        return $this->redirect(['/admin/login/index', 'logout' => true]);
    }
    
    public function getTags()
    {
        return TagParser::getInstantiatedTagObjects();
    }
}
