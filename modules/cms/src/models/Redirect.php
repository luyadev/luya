<?php

namespace luya\cms\models;

use Yii;
use luya\admin\ngrest\base\NgRestModel;
use luya\helpers\StringHelper;
use luya\helpers\Url;
use luya\cms\admin\Module;

/**
 * Redirect.
 *
 * File has been created with `crud/create` command on LUYA version 1.0.0.
 *
 * @property integer $id
 * @property integer $timestamp_create
 * @property string $catch_path
 * @property string $redirect_path
 * @property integer $redirect_status_code
 */
class Redirect extends NgRestModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_redirect';
    }

    /**
     * @inheritdoc
     */
    public static function ngRestApiEndpoint()
    {
        return 'api-cms-redirect';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['timestamp'] = [
            'class' => 'luya\behaviors\Timestamp',
            'insert' => ['timestamp_create'],
        ];
        
        return $behaviors;
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Module::t('ID'),
            'timestamp_create' => Module::t('redirect_model_atr_timestamp_create'),
            'catch_path' => Module::t('redirect_model_atr_catch_path'),
            'redirect_path' => Module::t('redirect_model_atr_redirect_path'),
            'redirect_status_code' => Module::t('redirect_model_atr_redirect_status_code'),
        ];
    }

    public function attributeHints()
    {
        return [
            'redirect_status_code' => Module::t('redirect_model_atr_redirect_status_code_hint'),
            'catch_path' => Module::t('redirect_model_atr_catch_path_hint'),
            'redirect_path' => Module::t('redirect_model_atr_redirect_path_hint'),
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['timestamp_create', 'redirect_status_code'], 'integer'],
            [['catch_path', 'redirect_path', 'redirect_status_code'], 'required'],
            [['catch_path', 'redirect_path'], 'string', 'max' => 255],
            [['catch_path'], function ($attribute) {
                if (!StringHelper::startsWith($this->catch_path, '/')) {
                    $this->addError($attribute, Module::t('redirect_model_atr_catch_path_error'));
                }
            }]
        ];
    }

    /**
     * @inheritdoc
     */
    public function genericSearchFields()
    {
        return ['catch_path', 'redirect_path'];
    }

    /**
     * @inheritdoc
     */
    public function ngRestAttributeTypes()
    {
        return [
            'catch_path' => ['text', 'placeholder' => '/path/to/catch'],
            'redirect_path' => ['text', 'placeholder' => '/path/to/redirect'],
            'redirect_status_code' => ['selectArray', 'data' => [
                301 => Module::t('redirect_model_atr_redirect_status_code_opt_301'),
                302 => Module::t('redirect_model_atr_redirect_status_code_opt_302'),
            ], 'initValue' => 302],
        ];
    }

    /**
     * @inheritdoc
     */
    public function ngRestScopes()
    {
        return [
            ['list', ['catch_path', 'redirect_path', 'redirect_status_code']],
            [['create', 'update'], ['catch_path', 'redirect_path', 'redirect_status_code']],
            ['delete', true],
        ];
    }
    
    /**
     * Match Request Path against catch_path.
     *
     * @param string $requestPath
     * @return boolean
     */
    public function matchRequestPath($requestPath)
    {
        // ensure request path is prefix with slash
        $requestPath = '/'.ltrim($requestPath, '/');
        // see if wildcard string matches
        if (StringHelper::startsWithWildcard($requestPath, $this->catch_path)) {
            return true;
        }
        // compare strings
        return ($requestPath == $this->catch_path);
    }
    
    /**
     *
     * @return string
     */
    public function getRedirectUrl()
    {
        return Url::to($this->redirect_path);
    }
}
