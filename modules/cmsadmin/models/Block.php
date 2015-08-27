<?php

namespace cmsadmin\models;

class Block extends \admin\ngrest\base\Model
{
    public function ngRestApiEndpoint()
    {
        return 'api-cms-block';
    }

    public static function tableName()
    {
        return 'cms_block';
    }

    public function ngRestConfig($config)
    {
        $config->list->field('class', 'Class')->text();
        $config->list->field('group_id', 'Gruppe')->text();

        $config->create->field('class', 'Class')->text();
        $config->create->field('group_id', 'Gruppe')->selectClass('\cmsadmin\models\BlockGroup', 'id', 'name');

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
            'commandinsert' => ['class', 'system_block', 'group_id'],
            'restcreate' => ['class', 'group_id', 'system_block'],
            'restupdate' => ['class', 'group_id', 'system_block'],
        ];
    }

    public static function objectId($id, $context)
    {
        $block = self::find()->where(['id' => $id])->one();
        if (!$block) {
            return false;
        }

        $class = $block->class;
        if (!class_exists($class)) {
            return false;
        }
        $object = new $class();
        $object->setEnvOption('blockId', $id);
        $object->setEnvOption('context', $context);

        return $object;
    }
}
