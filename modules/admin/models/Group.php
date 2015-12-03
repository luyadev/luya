<?php

namespace admin\models;

use admin\Module;

/**
 * This is the model class for table "admin_group".
 *
 * @property int $group_id
 * @property string $name
 * @property string $text
 */
class Group extends \admin\ngrest\base\Model
{
    use \admin\traits\SoftDeleteTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'admin_group';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
                [['name'], 'required'],
                [['text'], 'string'],
                [['name'], 'string', 'max' => 255],
        ];
    }

    public function scenarios()
    {
        return [
            'restcreate' => ['name', 'text', 'users'],
            'restupdate' => ['name', 'text', 'users'],
        ];
    }

    public $extraFields = ['users'];
    
    // ngrest

    public $users = [];

    public function ngRestApiEndpoint()
    {
        return 'api-admin-group';
    }

    public function ngRestConfig($config)
    {
        $config->aw->register(new \admin\aws\GroupAuth(), Module::t('model_group_btn_aws_groupauth'));

        $config->delete = true;

        $config->list->field('name', Module::t('model_group_name'))->text();
        $config->list->field('text', Module::t('model_group_description'))->textarea();

        $config->create->copyFrom('list', ['id']);
        $config->create->extraField('users', Module::t('model_group_user_buttons'))->checkboxRelation(\admin\models\User::className(), 'admin_user_group', 'group_id', 'user_id', ['firstname', 'lastname', 'email'], '%s %s (%s)');

        $config->update->copyFrom('create');

        return $config;
    }
}
