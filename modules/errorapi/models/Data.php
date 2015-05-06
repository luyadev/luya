<?php

namespace errorapi\models;

class Data extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'error_data';
    }

    public function rules()
    {
        return [
            [['error_json'], 'required'],
        ];
    }

    public function init()
    {
        parent::init();

        $this->on(self::EVENT_BEFORE_INSERT, [$this, 'eventBeforeCreate']);
    }

    public function eventBeforeCreate()
    {
        if (is_array($this->error_json)) {
            $this->error_json = json_encode($this->error_json);
        }

        $this->timestamp_create = time();
        $this->identifier = md5(strlen($this->error_json).uniqid());
    }
}
