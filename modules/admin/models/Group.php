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
    use \admin\traits\SoftDeleteTrait;
    
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
        $config->aw->register(new \admin\aws\GroupAuth(), 'Berechtigungen');

        $config->delete = true;
        
        $config->list->field('name', 'Name')->text();
        $config->list->field('text', 'Beschreibung')->textarea();

        $config->create->copyFrom('list', ['id']);
        $config->create->extraField('users', 'Benutzer')->checkboxRelation(\admin\models\User::className(), 'admin_user_group', 'group_id', 'user_id', ['firstname', 'lastname', 'email'], '%s %s (%s)');

        $config->update->copyFrom('create');

        return $config;
    }
}
