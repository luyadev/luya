<?php

namespace payment\models;

use Yii;
use yii\helpers\Json;

/**
 * This is the model class for table "payment_process_trace".
 *
 * @property integer $process_id
 * @property string $event
 * @property string $message
 * @property integer $timestamp
 * @property string $get
 * @property string $post
 * @property string $server
 */
class PaymentProcessTrace extends \yii\db\ActiveRecord
{
    public function init()
    {
        parent::init();
        
        $this->on(self::EVENT_BEFORE_VALIDATE, [$this, 'eventBeforeInsert']);
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'payment_process_trace';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['process_id', 'timestamp', 'event'], 'required'],
            [['process_id', 'timestamp'], 'integer'],
            [['get', 'post', 'server'], 'string'],
            [['event'], 'string', 'max' => 250],
            [['message'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'process_id' => 'Process ID',
            'event' => 'Event',
            'message' => 'Message',
            'timestamp' => 'Timestamp',
            'get' => 'Get',
            'post' => 'Post',
            'server' => 'Server',
        ];
    }
    
    public function eventBeforeInsert()
    {
        $this->get = (isset($_GET)) ? Json::encode($_GET) : '';
        $this->post = (isset($_POST)) ? Json::encode($_POST) : '';
        $this->server = (isset($_SERVER)) ? Json::encode($_SERVER) : '';
        $this->timestamp = time();
    }
}
