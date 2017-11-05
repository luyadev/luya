<?php

namespace luya\admin\models;

use luya\admin\Module;
use luya\admin\traits\SoftDeleteTrait;
use luya\admin\ngrest\base\NgRestModel;
use luya\admin\aws\GroupAuthActiveWindow;

/**
 * This is the model class for table "admin_group".
 *
 * @property integer $id
 * @property string $name
 * @property string $text
 * @property integer $is_deleted
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
final class Group extends NgRestModel
{
    use SoftDeleteTrait;

    public $users = [];
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin_group';
    }
    
    /**
     * @inheritdoc
     */
    public static function ngRestApiEndpoint()
    {
        return 'api-admin-group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['text'], 'string'],
            [['is_deleted'], 'boolean'],
            [['name'], 'string', 'max' => 255],
            [['users'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function extraFields()
    {
        return ['users'];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Module::t('model_group_name'),
            'text' => Module::t('model_group_description'),
            'users' => Module::t('model_group_user_buttons'),
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function ngRestAttributeTypes()
    {
        return [
            'name' => 'text',
            'text' => 'textarea',
        ];
    }

    /**
     * @inheritdoc
     */
    public function ngRestExtraAttributeTypes()
    {
        return [
            'users' => [
                'checkboxRelation',
                'model' => User::className(),
                'refJoinTable' => 'admin_user_group',
                'refModelPkId' => 'group_id',
                'refJoinPkId' => 'user_id',
                'labelField' => ['firstname', 'lastname', 'email'],
                'labelTemplate' =>  '%s %s (%s)'
            ],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function ngRestActiveWindows()
    {
        return [
            ['class' => GroupAuthActiveWindow::class],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function ngRestScopes()
    {
        return [
            [['list'], ['name', 'text']],
            [['create', 'update'], ['name', 'text', 'users']],
            [['delete'], true],
        ];
    }
}
