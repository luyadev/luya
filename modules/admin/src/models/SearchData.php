<?php

namespace luya\admin\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "admin_search_data".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $timestamp_create
 * @property string $query
 * @property integer $num_rows
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
final class SearchData extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->on(self::EVENT_BEFORE_VALIDATE, [$this, 'onBeforeValidate']);
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin_search_data';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'timestamp_create', 'query'], 'required'],
            [['user_id', 'timestamp_create', 'num_rows'], 'integer'],
            [['query'], 'string', 'max' => 255],
        ];
    }

    public function onBeforeValidate()
    {
        $this->timestamp_create = time();
        $this->user_id = Yii::$app->adminuser->getId();
    }
}
