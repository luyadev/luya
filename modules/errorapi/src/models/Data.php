<?php

namespace luya\errorapi\models;

use luya\errorapi\Module;

class Data extends \yii\db\ActiveRecord
{
    public $message;

    public $serverName;
    
    public $errorArray = [];

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

    public function eventBeforeCreate($event)
    {
        if (is_array($this->error_json)) {
            $event->isValid = false;
            return $this->addError('error_json', Module::t('data_json_error'));
        }
        
        $errorJsonArray = json_decode($this->error_json, true);
        
        if (!isset($errorJsonArray['message']) || !isset($errorJsonArray['serverName'])) {
            $event->isValid = false;
            return $this->addError('error_json', Module::t('data_content_error'));
        }
        
        $this->errorArray = $errorJsonArray;
        $this->message = $errorJsonArray['message'];
        $this->serverName = $errorJsonArray['serverName'];
        $this->timestamp_create = time();
        $this->identifier = $this->createMessageIdentifier($this->message);
        $this->error_json = json_encode($errorJsonArray);
    }

    public function createMessageIdentifier($msg)
    {
        return sprintf('%s', hash('crc32b', $msg));
    }
}
