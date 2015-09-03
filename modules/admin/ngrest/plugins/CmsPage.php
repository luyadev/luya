<?php

namespace admin\ngrest\plugins;

use Yii;

class CmsPage extends \admin\ngrest\base\Plugin
{
    public function renderList($doc)
    {
        $doc->appendChild($doc->createElement('span', '{{item.'.$this->name.'}}'));
        // return $doc
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
        if (!empty($fieldValue)) {
            $lang = Yii::$app->composition->getKey('langShortCode');
            $langId = \admin\models\Lang::find()->where(['short_code' => $lang])->one()->id;
            $item = \cmsadmin\models\NavItem::find()->where(['lang_id' => $langId, 'nav_id' => $fieldValue])->one();
            if ($item) {
                $fieldValue = $item->getContent();
            }
        }
        return $fieldValue;
    }
}
