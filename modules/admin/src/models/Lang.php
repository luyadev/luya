<?php

namespace admin\models;

use Yii;

/**
 * Language Model for Frontend/Admin.
 * 
 * This Model contains all languages from the database table `admin_lang` but also has helper methods
 * to retrieve the curent active language based on several inputs like composition, config values, etc.
 * 
 * @author Basil Suter <basil@nadar.io>
 */
class Lang extends \admin\ngrest\base\Model
{
    /**
     * 
     * {@inheritDoc}
     * @see \yii\db\BaseActiveRecord::init()
     */
    public function init()
    {
        parent::init();
        $this->on(self::EVENT_AFTER_VALIDATE, [$this, 'validateDefaultLanguage']);
    }
    
    /**
     * 
     * @return string
     */
    public static function tableName()
    {
        return 'admin_lang';
    }
    
    /**
     * After validation event find out if default has to be set or not. Check if if current value
     * has default to 1, disabled the other default attributes.
     */
    public function validateDefaultLanguage()
    {
        if ($this->isNewRecord && $this->is_default == 1) {
            self::updateAll(['is_default' => 0]);
        } elseif (!$this->isNewRecord && $this->is_default == 1) {
            self::updateAll(['is_default' => 0]);
        } else {
            $this->is_default = 0;
        }
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see \yii\base\Model::rules()
     */
    public function rules()
    {
        return [
            [['name', 'short_code'], 'required'],
            [['is_default'], 'integer'],
        ];
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see \yii\base\Model::scenarios()
     */
    public function scenarios()
    {
        return [
            'restcreate' => ['name', 'short_code', 'is_default'],
            'restupdate' => ['name', 'short_code', 'is_default'],
        ];
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see \yii\base\Model::attributeLabels()
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'short_code' => 'Short Code',
            'is_default' => 'Default Language',
        ];
    }
    
    /**
     *
     * {@inheritDoc}
     * @see \admin\ngrest\NgRestModeInterface::ngRestApiEndpoint()
     */
    public function ngRestApiEndpoint()
    {
        return 'api-admin-lang';
    }

    public function ngrestAttributeTypes()
    {
        return [
            'name' => 'text',
            'short_code' => 'text',
            'is_default' => ['toggleStatus', 'initValue' => 0],
        ];
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see \admin\ngrest\NgRestModeInterface::ngRestConfig()
     */
    public function ngRestConfig($config)
    {
        $this->ngRestConfigDefine($config, ['list', 'create', 'update'], ['name', 'short_code', 'is_default']);
        
        return $config;
    }
    
    private static $_langInstanceQuery = null;

    /**
     * @return array
     */
    public static function getQuery()
    {
        if (self::$_langInstanceQuery === null) {
            self::$_langInstanceQuery = self::find()->asArray()->indexBy('short_code')->all();
        }

        return self::$_langInstanceQuery;
    }

    private static $_langInstance = null;
    
    /**
     * 
     * @return array
     */
    public static function getDefault()
    {
        if (self::$_langInstance === null) {
            self::$_langInstance = self::find()->where(['is_default' => 1])->asArray()->one();
        }

        return self::$_langInstance;
    }

    private static $_langInstanceFindActive = null;
    
    /**
     * Get the active langauge array 
     * 
     * @return array
     */
    public static function findActive()
    {
        if (self::$_langInstanceFindActive === null) {
            $langShortCode = Yii::$app->composition->getKey('langShortCode');
    
            if (!$langShortCode) {
                self::$_langInstanceFindActive = self::getDefault();
            } else {
                self::$_langInstanceFindActive = self::find()->where(['short_code' => $langShortCode])->asArray()->one();
            }
        }
        
        return self::$_langInstanceFindActive;
    }
}
