<?php

namespace admin\ngrest\plugins;

use Yii;
use admin\ngrest\base\Model;

class CmsPage extends \admin\ngrest\base\Plugin
{
    public function renderList($id, $ngModel)
    {
        return $this->createListTag($ngModel);
        /*
        $doc->appendChild($doc->createElement('span', '{{item.'.$this->name.'}}'));
        return $doc;
        */
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
     * @todo TEST THIS!
     * {@inheritDoc}
     * @see \admin\ngrest\base\Plugin::onAfterListFind()
     */
    public function onAfterListFind($event)
    {
        var_dump($event->sender->getAttribute($this->name));
    }
    
    public function onAfterFind($fieldValue)
    {
        return (!empty($fieldValue)) ? Yii::$app->menu->find()->where(['nav_id' => $fieldValue])->one() : $fieldValue;
    }
}
