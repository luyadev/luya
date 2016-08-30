<?php

namespace luya\admin\models;

use Yii;

class SearchData extends \yii\db\ActiveRecord
{
    public function init()
    {
        parent::init();
        $this->on(self::EVENT_BEFORE_VALIDATE, [$this, 'onBeforeValidate']);
    }
    public static function tableName()
    {
        return 'admin_search_data';
    }

    public function rules()
    {
        return [
            [['query', 'num_rows', 'user_id'], 'required'],
        ];
    }

    public function onBeforeValidate()
    {
        $this->timestamp_create = time();
        $this->user_id = Yii::$app->adminuser->getId();
    }
}
