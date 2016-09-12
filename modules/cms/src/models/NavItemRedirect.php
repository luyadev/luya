<?php

namespace luya\cms\models;

use Yii;
use Exception;
use luya\cms\base\NavItemType;
use luya\cms\base\NavItemTypeInterface;
use luya\cms\admin\Module;

/**
 * Represents the type REDIRECT for a NavItem.
 *
 * @author Basil Suter <basil@nadar.io>
 */
class NavItemRedirect extends NavItemType implements NavItemTypeInterface
{
    const TYPE_INTERNAL_PAGE = 1;

    const TYPE_EXTERNAL_URL = 2;

    const TYPE_LINK_TO_FILE = 3;

    public static function tableName()
    {
        return 'cms_nav_item_redirect';
    }

    /**
     * {@InheritDoc}
     * @see \luya\cms\base\NavItemType::getNumericType()
     */
    public static function getNummericType()
    {
        return NavItem::TYPE_REDIRECT;
    }
    
    public function rules()
    {
        return [
            [['type', 'value'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'value' => Module::t('model_navitemredirect_value_label'),
            'type' => Module::t('model_navitemredirect_type_label'),
        ];
    }

    public function resolveValue()
    {
        switch ($this->type) {
            case self::TYPE_INTERNAL_PAGE:
                $item = Yii::$app->menu->find()->where(['nav_id' => $this->value])->with('hidden')->one();
                if (!$item) {
                    throw new Exception('Unable to find item '.$this->value);
                }

                return $item->link;
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
