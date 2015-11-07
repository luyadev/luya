<?php

namespace cmsadmin\models;

use Yii;
use luya\helpers\Url;

class NavItemRedirect extends \cmsadmin\base\NavItemType
{
    const TYPE_INTERNAL_PAGE = 1;
    
    const TYPE_EXTERNAL_URL = 2;
    
    const TYPE_LINK_TO_FILE = 3;
    
    public static function tableName()
    {
        return 'cms_nav_item_redirect';
    }
    
    public function rules()
    {
        return [
            [['type', 'value'], 'required'],
        ];
    }
    
    public function resolveValue()
    {
        switch($this->type) {
            case self::TYPE_INTERNAL_PAGE:
                $menuItem = Yii::$app->menu->find()->where(['nav_id' => $this->value])->with('hidden')->one();
                return Url::trailing(Yii::$app->urlManager->baseUrl) . $menuItem->link;
                
            case self::TYPE_EXTERNAL_URL:
                return $this->value;
        }
    }
    
    public function getContent()
    {
        Yii::$app->getResponse()->redirect($this->resolveValue());
        Yii::$app->end();
        return;
    }
}
