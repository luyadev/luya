<?php

namespace errorapi\models;

class Data extends \yii\db\ActiveRecord
{
    public $msg = null;
    
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
            $this->msg = $this->error_json['message'];
            $this->error_json = json_encode($this->error_json);
        } else {
            $arr = json_decode($this->error_json, true);
            $this->msg = $arr['message'];
        }

        $this->timestamp_create = time();
        $this->identifier = $this->hash($this->msg, 'luya');
    }
    
    private function hash($msg)
    {
        return sprintf('%s', hash('crc32b', $msg));
    }
}
