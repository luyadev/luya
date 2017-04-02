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
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['text'], 'string'],
            [['is_deleted'], 'integer'],
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
    public static function ngRestApiEndpoint()
    {
        return 'api-admin-group';
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
                'labelFields' => ['firstname', 'lastname', 'email'],
                'labelTemplate' =>  '%s %s (%s)'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function ngRestConfig($config)
    {
        // load active window to config
        $config->aw->load(['class' => GroupAuthActiveWindow::className(), 'alias' => Module::t('model_group_btn_aws_groupauth')]);
        
        // define config
        $this->ngRestConfigDefine($config, 'list', ['name', 'text']);
        $this->ngRestConfigDefine($config, 'create', ['name', 'text', 'users']);
        $this->ngRestConfigDefine($config, 'update', ['name', 'text', 'users']);
        
        // add ability to delete items
        $config->delete = true;
        
        return $config;
    }
}
