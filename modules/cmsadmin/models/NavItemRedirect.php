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
                $link = Yii::$app->links->findOne(['nav_id' => $this->value]);
                return $link['full_url'];
                break;
        }
    }
    
    public function getContent()
    {
        Yii::$app->getResponse()->redirect(Url::trailing(Yii::$app->urlManager->baseUrl) . $this->resolveValue());
        Yii::$app->end();
        return;
    }
}
