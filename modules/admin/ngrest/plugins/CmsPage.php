<?php

namespace admin\ngrest\plugins;

use Yii;

class CmsPage extends \admin\ngrest\base\Plugin
{
    public function renderList($doc)
    {
        $doc->appendChild($doc->createElement('span', '{{item.'.$this->name.'}}'));
        return $doc;
    }

    public function renderCreate($doc)
    {
        $doc->appendChild($this->createBaseElement($doc, 'zaa-cms-page'));
        return $doc;
    }

    public function renderUpdate($doc)
    {
        return $this->renderCreate($doc);
    }

    public function onAfterFind($fieldValue)
    {
        return (!empty($fieldValue)) ? Yii::$app->menu->find()->where(['nav_id' => $fieldValue])->one() : $fieldValue;
    }
}
