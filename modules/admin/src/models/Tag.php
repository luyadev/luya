<?php

namespace luya\admin\models;

use luya\admin\ngrest\base\NgRestModel;

/**
 * Tags Data.
 * 
 * @author Basil Suter <basil@nadar.io>
 */
class Tag extends NgRestModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin_tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'unique'],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function genericSearchFields()
    {
        return ['name'];
    }

    /**
     * @inheritdoc
     */
    public static function ngRestApiEndpoint()
    {
        return 'api-admin-tag';
    }

    /**
     * @inheritdoc
     */
    public function ngRestConfig($config)
    {
        $config->list->field('name', 'Name')->text();
        $config->create->copyFrom('list');
        $config->update->copyFrom('list');
        $config->delete = true;

        return $config;
    }

    /**
     * Get all primary key assigned tags for a table name.
     * 
     * @param string $tableName
     * @param integer $pkId
     * @return \yii\db\ActiveRecord
     */
    public static function findRelations($tableName, $pkId)
    {
        return self::find()->innerJoin(TagRelation::tableName(), 'admin_tag_relation.tag_id=admin_tag.id')->where(['pk_id' => $pkId, 'table_name' => $tableName])->all();
    }
    
    /**
     * Get all assigned tags for table name.
     * 
     * @param string $tableName
     * @return \yii\db\ActiveRecord
     */
    public static function findRelationsTable($tableName)
    {
        return self::find()->innerJoin(TagRelation::tableName(), 'admin_tag_relation.tag_id=admin_tag.id')->distinct()->where(['table_name' => $tableName])->all();
    }
}
