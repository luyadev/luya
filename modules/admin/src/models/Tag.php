<?php

namespace luya\admin\models;

use luya\admin\ngrest\base\NgRestModel;
use luya\admin\Module;

/**
 * This is the model class for table "admin_tag".
 *
 * @property integer $id
 * @property string $name
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
final class Tag extends NgRestModel
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
    public function attributeLabels()
    {
        return [
            'name' => Module::t('model_tag_name'),
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
    public function ngRestAttributeTypes()
    {
        return [
            'name' => 'text',
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function ngRestConfig($config)
    {
        $this->ngRestConfigDefine($config, ['list', 'create', 'update'], ['name']);

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
        return self::find()->innerJoin(TagRelation::tableName(), 'admin_tag_relation.tag_id=admin_tag.id')->where(['pk_id' => $pkId, 'table_name' => $tableName])->indexBy('name')->all();
    }
    
    /**
     * Get all assigned tags for table name.
     *
     * @param string $tableName
     * @return \yii\db\ActiveRecord
     */
    public static function findRelationsTable($tableName)
    {
        return self::find()->innerJoin(TagRelation::tableName(), 'admin_tag_relation.tag_id=admin_tag.id')->distinct()->where(['table_name' => $tableName])->indexBy('name')->all();
    }
}
