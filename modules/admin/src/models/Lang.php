<?php

namespace luya\admin\models;

use Yii;
use luya\admin\ngrest\base\NgRestModel;
use luya\admin\Module;
use luya\admin\traits\SoftDeleteTrait;

/**
 * Language Model for Frontend/Admin.
 *
 * This Model contains all languages from the database table `admin_lang` but also has helper methods
 * to retrieve the curent active language based on several inputs like composition, config values, etc.
 *
 * @property integer $id
 * @property string $name
 * @property string $short_code
 * @property integer $is_default
 * @property integer $is_deleted
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
final class Lang extends NgRestModel
{
    use SoftDeleteTrait;
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        
        /**
         * After validation event find out if default has to be set or not. Check if if current value
         * has default to 1, disabled the other default attributes.
         */
        $this->on(self::EVENT_BEFORE_INSERT, function ($event) {
            if ($this->is_default) {
                self::updateAll(['is_default' => false]);
            }
        });
        
        $this->on(self::EVENT_BEFORE_UPDATE, function ($event) {
            if ($this->is_default) {
                $this->markAttributeDirty('is_default');
                self::updateAll(['is_default' => false]);
            }
        });
        
        $this->on(self::EVENT_BEFORE_DELETE, function ($event) {
            if ($this->is_default == 1) {
                $this->addError('is_default', Module::t('model_lang_delete_error_is_default'));
                $event->isValid = false;
            }
        });
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin_lang';
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'short_code'], 'required'],
            [['is_default'], 'boolean'],
            [['name'], 'string', 'max' => 255],
            [['short_code'], 'string', 'max' => 15],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Module::t('model_lang_name'),
            'short_code' => Module::t('model_lang_short_code'),
            'is_default' => Module::t('model_lang_is_default'),
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function ngRestApiEndpoint()
    {
        return 'api-admin-lang';
    }

    /**
     * @inheritdoc
     */
    public function ngRestAttributeTypes()
    {
        return [
            'name' => 'text',
            'short_code' => 'text',
            'is_default' => ['toggleStatus', 'initValue' => 0, 'interactive' => false],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function ngRestConfig($config)
    {
        $this->ngRestConfigDefine($config, ['list', 'create', 'update'], ['name', 'short_code', 'is_default']);
     
        $config->options = ['saveCallback' => 'function(ServiceLanguagesData) { ServiceLanguagesData.load(true).then(function() { $scope.AdminLangService.load(); }); }'];
        
        $config->delete = true;
        
        return $config;
    }
    
    private static $_langInstanceQuery;

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

    private static $_langInstance;
    
    /**
     *
     * @return array
     */
    public static function getDefault()
    {
        if (self::$_langInstance === null) {
            self::$_langInstance = self::find()->where(['is_default' => true, 'is_deleted' => false])->asArray()->one();
        }

        return self::$_langInstance;
    }

    private static $_langInstanceFindActive;
    
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
                self::$_langInstanceFindActive = self::find()->where(['short_code' => $langShortCode, 'is_deleted' => false])->asArray()->one();
            }
        }
        
        return self::$_langInstanceFindActive;
    }
}
