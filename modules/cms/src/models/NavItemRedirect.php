<?php

namespace luya\cms\models;

use Yii;
use Exception;
use luya\cms\base\NavItemType;
use luya\cms\base\NavItemTypeInterface;
use luya\cms\admin\Module;
use luya\web\EmailLink;

/**
 * Represents the type REDIRECT for a NavItem.
 *
 * @property integer $id
 * @property integer $type The type of redirect (1 = page, 2 = URL, 3 = Link to File)
 * @property string $value Depending on the type (1 = cms_nav.id, 2 = http://luya.io)
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class NavItemRedirect extends NavItemType implements NavItemTypeInterface
{
    const TYPE_INTERNAL_PAGE = 1;

    const TYPE_EXTERNAL_URL = 2;

    const TYPE_LINK_TO_FILE = 3;
    
    const TYPE_LINK_TO_EMAIL = 4;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_nav_item_redirect';
    }

    /**
     * @inheritdoc
     */
    public static function getNummericType()
    {
        return NavItem::TYPE_REDIRECT;
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'value'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
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
            // internal page redirect
            case self::TYPE_INTERNAL_PAGE:
                $item = Yii::$app->menu->find()->where(['nav_id' => $this->value])->with('hidden')->one();
                if (!$item) {
                    throw new Exception('Unable to find item '.$this->value . ' in order to resolve an internal page redirect. Maybe the page does not exist anymore or is offline.');
                }

                return $item->link;
                break;
                
            // external page redirect
            case self::TYPE_EXTERNAL_URL:
                return $this->value;
                break;
                
            // link to storage file
            case self::TYPE_LINK_TO_FILE:
                $file = Yii::$app->storage->getFile($this->value);
                if (!$file) {
                    throw new Excetion("Unable to find the file with id " . $this->value);
                }
                
                return $file->href;
                break;
            
            // link to an email address
            case self::TYPE_LINK_TO_EMAIL:
                $mail = new EmailLink(['email' => $this->value]);
                return $mail->getHref();
                break;
        }
    }

    public function getContent()
    {
        Yii::$app->getResponse()->redirect($this->resolveValue());
        Yii::$app->end();
        
        return;
    }
}
