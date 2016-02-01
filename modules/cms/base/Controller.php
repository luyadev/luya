<?php

namespace cms\base;

use Yii;
use cms\helpers\Parser;
use cmsadmin\models\NavItem;
use yii\web\NotFoundHttpException;
use yii\web\MethodNotAllowedHttpException;

abstract class Controller extends \luya\web\Controller
{
    /*
     * Use the view files inside the cms module and not within the user project code.
     */
    public $useModuleViewPath = true;

    public function renderItem($navItemId, $appendix = null)
    {
        $model = NavItem::findOne($navItemId);

        if (!$model) {
            throw new NotFoundHttpException('The requested nav item could not found.');
        }

        Yii::$app->urlManager->contextNavItemId = $navItemId;

        Yii::$app->set('page', [
            'class' => 'cms\components\Page',
            'model' => $model,
        ]);

        $event = new \cms\events\BeforeRenderEvent();
        $event->menu = Yii::$app->menu->current;
        foreach ($model->getNav()->getProperties() as $property) {
            $object = $model->getNav()->getProperty($property['var_name']);
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

        if ($this->view->title === null) {
            $this->view->title = $model->title;
        }
        
        $this->view->registerMetaTag(['name' => 'og:title', 'content' => $this->view->title], 'fbTitle');
        
        if (!empty($model->description)) {
            $this->view->registerMetaTag(['name' => 'description', 'content' => $model->description], 'metaDescription');
            $this->view->registerMetaTag(['name' => 'og:description', 'content' => $model->description], 'fbDescription');
        }
        
        if ($this->module->enableTagParsing) {
            $content = Parser::encode($content);
        }

        return $content;
    }
}
