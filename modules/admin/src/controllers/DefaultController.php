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
use luya\admin\models\UserLogin;

/**
 * Administration Controller provides, dashboard, logout and index.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
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
        
        // register i18n
        $this->view->registerJs('var i18n=' . Json::encode($this->module->jsTranslations), View::POS_HEAD);
        
        $authToken = UserLogin::find()->select(['auth_token'])->where(['user_id' => Yii::$app->adminuser->id, 'ip' => Yii::$app->request->userIP, 'is_destroyed' => false])->scalar();
        
        $this->view->registerJs('zaa.run(function($rootScope) { $rootScope.luyacfg = ' . Json::encode([
            'authToken' => $authToken,
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
                $items[] = Yii::createObject($config);
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
