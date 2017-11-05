<?php

namespace luya\admin\ngrest\plugins;

use Yii;
use luya\admin\ngrest\base\Plugin;

/**
 * Create ability to select a CMS page.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class CmsPage extends Plugin
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

    public function onAfterFind($event)
    {
        $fieldValue = $event->sender->getAttribute($this->name);
        $menuItem = (!empty($fieldValue)) ? Yii::$app->menu->find()->where(['nav_id' => $fieldValue])->with(['hidden'])->one() : false;
        $event->sender->setAttribute($this->name, $menuItem);
    }
}
