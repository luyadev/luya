<?php

namespace luya\crawler\models;

/**
 * This is the model class for table "crawler_click".
 *
 * @property integer $id
 * @property integer $searchdata_id
 * @property integer $position
 * @property integer $index_id
 * @property integer $timestamp
 */
class Click extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'crawler_click';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['searchdata_id', 'position', 'index_id', 'timestamp'], 'required'],
            [['searchdata_id', 'position', 'index_id', 'timestamp'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'searchdata_id' => 'Searchdata ID',
            'position' => 'Position',
            'index_id' => 'Index ID',
            'timestamp' => 'Timestamp',
        ];
    }
}
