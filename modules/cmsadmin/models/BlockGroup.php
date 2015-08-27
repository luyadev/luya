<?php

namespace cmsadmin\models;

class BlockGroup extends \admin\ngrest\base\Model
{
    use \admin\traits\SoftDeleteTrait;

    public function ngRestApiEndpoint()
    {
        return 'api-cms-blockgroup';
    }

    public static function tableName()
    {
        return 'cms_block_group';
    }

    public function ngRestConfig($config)
    {
        $config->delete = true;

        $config->list->field('name', 'Name')->text();

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
