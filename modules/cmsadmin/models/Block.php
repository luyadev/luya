<?php
namespace cmsadmin\models;

class Block extends \admin\ngrest\base\Model
{
    public $ngRestEndpoint = 'api-cms-block';

    public static function tableName()
    {
        return 'cms_block';
    }

    public function ngRestConfig($config)
    {
        $config->list->field("class", "Class")->text()->required();

        $config->create->field("class", "Class")->text()->required();
        $config->create->field("group_id", "Gruppe")->selectClass('\cmsadmin\models\BlockGroup', 'id', 'name')->required();

        $config->update->copyFrom('create');

        return $config;
    }

    public function rules()
    {
        return [
            [['class', 'group_id'], 'required'],
        ];
    }

    public function scenarios()
    {
        return [
            'restcreate' => ['class', 'group_id'],
            'restupdate' => ['class', 'group_id'],
        ];
    }

    public static function objectId($id)
    {
        $block = self::find()->where(['id' => $id])->one();

        $class = $block->class;
        $object = new $class();

        return $object;
    }
}
