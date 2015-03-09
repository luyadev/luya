<?php
namespace admin\models;

/**
 * This is the model class for table "admin_group".
 *
 * @property integer $group_id
 * @property string $name
 * @property string $text
 */
class StorageFilter extends \admin\ngrest\base\Model
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin_storage_filter';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
        ];
    }

    public function scenarios()
    {
        return [
            'restcreate' => ['name'],
            'restupdate' => ['name'],
        ];
    }

    // ngrest

    public $ngRestEndpoint = 'api-admin-filter';

    public function ngRestConfig($config)
    {
        $config->list->field("name", "Name")->text()->required();
        $config->list->field("id", "ID")->text();

        $config->create->copyFrom('list', ['id']);
        $config->update->copyFrom('list', ['id']);

        return $config;
    }
}
