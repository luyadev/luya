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
                [['name'], 'string', 'max' => 255]
        ];
    }

    public function scenarios()
    {
        return [
            'restcreate' => ['name', 'text'],
            'restupdate' => ['name', 'text']
        ];
    }

    // ngrest

    public $ngRestEndpoint = 'api-admin-group';

    public function ngRestConfig($config)
    {
        $config->list->field("name", "Name")->text()->required();
        $config->list->field("text", "Beschreibung")->textarea();
        $config->list->field("id", "ID")->text();

        $config->create->copyFrom('list');
        $config->update->copyFrom('list');

        return $config;
    }
}
