<?php
namespace cmsadmin\models;

class BlockGroup extends \admin\ngrest\base\Model
{
    public $ngRestEndpoint = 'api-cms-blockgroup';

    public static function tableName()
    {
        return 'cms_block_group';
    }

    public function ngRestConfig($config)
    {
        $config->list->field('name', 'Name')->text()->required();

        $config->create->copyFrom('list', ['id']);
        $config->update->copyFrom('list', ['id']);

        return $config;
    }

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
}
