<?php

namespace admin\ngrest\plugins;

use Yii;

/**
 * Create ability to select a CMS page.
 * 
 * @author nadar
 */
class CmsPage extends \admin\ngrest\base\Plugin
{
    public function renderList($id, $ngModel)
    {
        return $this->createListTag($ngModel);
    }

    public function renderCreate($id, $ngModel)
    {
        return $this->createFormTag('zaa-cms-page', $id, $ngModel);
    }

    public function renderUpdate($id, $ngModel)
    {
        return $this->renderCreate($id, $ngModel);
    }

    /**
     * @todo testing
     */
    public function onAfterFind($event)
    {
    	$fieldValue = $event->sender->getAttribute($this->name);
    	$menuItem = (!empty($fieldValue)) ? Yii::$app->menu->find()->where(['nav_id' => $fieldValue])->one() : $fieldValue;
    	$event->sender->setAttribute($this->name, $menuItem);
    }
    /*
    public function onAfterFind($fieldValue)
    {
        return (!empty($fieldValue)) ? Yii::$app->menu->find()->where(['nav_id' => $fieldValue])->one() : $fieldValue;
    }
    */
}
