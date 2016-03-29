<?php

namespace cms\base;

use Yii;
use luya\web\View;
use cms\helpers\Parser;
use cmsadmin\models\NavItem;
use yii\web\NotFoundHttpException;
use yii\web\MethodNotAllowedHttpException;
use yii\web\Response;

abstract class Controller extends \luya\web\Controller
{

    public function init()
    {
        parent::init();
        
        if (Yii::$app->has('adminuser') && !Yii::$app->adminuser->isGuest && $this->module->overlayToolbar === true) {
            $this->on(self::EVENT_BEFORE_ACTION, function($event) {
                $event->sender->getView()->on(View::EVENT_BEGIN_BODY, [$this, 'renderToolbar']);
            });
        }
    }
    
    public function renderToolbar($event)
    {
        $view = $event->sender;
        $folder = Yii::getAlias('@cms');
        
        $props = [];
        
        foreach(Yii::$app->page->getProperties() as $prop) {
            $o = $prop->getObject();
            $props[] = ['label' => $o->label(), 'value' => $o->getValue()];
        }
        
        $menu = Yii::$app->menu;
        
        echo $view->renderPhpFile($folder . '/views/_toolbar.php', [
            'menu' => $menu,
            'composition' => Yii::$app->composition,
            'luyaTagParsing' => $event->sender->context->module->enableTagParsing,
            'properties' => $props,
            'content' => strip_tags(NavItem::findOne($menu->current->id)->getContent()),
        ]);
        // echo is used in order to support cases where asset manager is not available
        echo '<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">';
        echo '<style>' . $view->renderPhpFile($folder . '/assets/toolbar.css') . '</style>';
        echo '<script>' . $view->renderPhpFile($folder . '/assets/toolbar.js') . '</script>';
    }
    
    public function renderItem($navItemId, $appendix = null)
    {
        $model = NavItem::find()->where(['id' => $navItemId])->with('nav')->one();

        if (!$model) {
            throw new NotFoundHttpException('The requested nav item could not found.');
        }

        Yii::$app->urlManager->contextNavItemId = $navItemId;

        Yii::$app->set('page', [
            'class' => 'cms\components\Page',
            'model' => $model,
        ]);

        $currentMenu = Yii::$app->menu->current;
        
        $event = new \cms\events\BeforeRenderEvent();
        $event->menu = $currentMenu;
        foreach ($model->nav->getProperties() as $property) {
            //$object = $model->getNav()->getProperty($property['var_name']);
            
            $object = $property->getObject();
            
            $object->trigger($object::EVENT_BEFORE_RENDER, $event);
            if (!$event->isValid) {
                throw new MethodNotAllowedHttpException('Your are not allowed to see this page.');
                return Yii::$app->end();
            }
        }

        $typeModel = $model->getType();
        $typeModel->setOptions([
            'cmsControllerObject' => $this,
            'navItemId' => $navItemId,
            'restString' => $appendix,
        ]);
        
        $content = $typeModel->getContent();
        
        
        if ($content instanceof Response) {
            return Yii::$app->end(0, $content);
        }
        
        // it seems to be a json response as it is an array
        if (is_array($content)) {
            return $content;
        }

        if ($this->view->title === null) {
            $this->view->title = $model->title;
        }
        
        
        
        $this->view->registerMetaTag(['name' => 'og:title', 'content' => $this->view->title], 'fbTitle');
        $this->view->registerMetaTag(['name' => 'og:type', 'content' => 'website'], 'ogType');
        
        
        if (!empty($model->description)) {
            $this->view->registerMetaTag(['name' => 'description', 'content' => $model->description], 'metaDescription');
            $this->view->registerMetaTag(['name' => 'og:description', 'content' => $model->description], 'fbDescription');
        }
        
        if (!empty($model->keywords)) {
            $this->view->registerMetaTag(['name' => 'keywords', 'content' => implode(", ", $currentMenu->keywords)], 'metyKeywords');
        }
        
        if ($this->module->enableTagParsing) {
            $content = Parser::encode($content);
        }
        return $content;
    }
}
