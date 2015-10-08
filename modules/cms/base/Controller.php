<?php

namespace cms\base;

use Yii;
use cms\helpers\Parser;
use cmsadmin\models\NavItem;

abstract class Controller extends \luya\base\Controller
{
    /*
     * Use the view files inside the cms module and not within the user project code.
     */
    public $useModuleViewPath = true;

    public function renderItem($navItemId, $appendix = null)
    {
        $model = NavItem::findOne($navItemId);

        $event = new \cms\events\CmsEvent();
        
        foreach($model->getNav()->getProperties() as $property) {
            $object = $model->getNav()->getPropertyObject($property['var_name']);
            $object->trigger($object::EVENT_BEFORE_RENDER, $event);
            if (!$event->isValid) {
                Yii::$app->end();
            }
        }
        
        $typeModel = $model->getType();
        $typeModel->setOptions([
            'navItemId' => $navItemId,
            'restString' => $appendix,
        ]);

        $content = $typeModel->getContent();

        if ($this->view->title === null) {
            $this->view->title = $model->title;
        }

        if ($this->module->enableTagParsing) {
            $content = Parser::encode($content);
        }
        
        return $content;
    }
}
