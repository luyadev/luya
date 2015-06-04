<?php

namespace admin\models;

/**
 * This is the model class for table "admin_group".
 *
 * @property integer $group_id
 * @property string $name
 * @property string $text
 */
class Group extends \admin\ngrest\base\Model
{
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

    /*
    public function getUsers()
    {
        return $this->hasMany(\admin\models\User::className(), ['id' => 'user_id'])->viaTable("admin_user_group", ['group_id' => 'id']);
    }

    public function setUsers($value)
    {
        $this->setRelation($value, "admin_user_group", "group_id", "user_id");
    }
    */

    // ngrest

    public $users = [];

    public function ngRestApiEndpoint()
    {
        return 'api-admin-group';
    }

    public function ngRestConfig($config)
    {
        $config->activeWindow->register(new \admin\aws\GroupAuth(), 'Berechtigungen');

        $config->list->field('name', 'Name')->text()->required();
        $config->list->field('text', 'Beschreibung')->textarea();
        $config->list->field('id', 'ID')->text();
        $config->list->extraField('users', 'Benutzer')->checkboxRelation(\admin\models\User::className(), 'admin_user_group', 'user_id', 'group_id');

        $config->create->copyFrom('list', ['id']);
        $config->update->copyFrom('list', ['id']);

        return $config;
    }
}
