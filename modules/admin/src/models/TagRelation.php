<?php

namespace luya\admin\models;

class TagRelation extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'admin_tag_relation';
    }

    public function rules()
    {
        return [
            [['tag_id', 'table_name', 'pk_id'], 'safe'],
        ];
    }

    public static function getDataForRelation($tableName, $pkId)
    {
        return self::find()->where(['table_name' => $tableName, 'pk_id' => $pkId])->asArray()->all();
    }

    public static function getDistinctDataForTable($tableName)
    {
        return self::find()->select('tag_id')->where(['table_name' => $tableName])->distinct()->asArray()->all();
    }
}
