<?php

namespace payment\models;

use Yii;
use luya\Exception;
use yii\helpers\Json;

/**
 * This is the model class for table "payment_process".
 *
 * @property integer $id
 * @property string $salt
 * @property string $hash
 * @property string $auth_token
 * @property integer $amount
 * @property string $currency
 * @property string $order_id
 * @property string $provider_name
 * @property string $success_link
 * @property string $error_link
 * @property string $back_link
 * @property string $random_key
 * @property string $transaction_config
 * @property int $close_state
 * @property int $is_closed
 */
class PaymentProcess extends \yii\db\ActiveRecord
{
    public $auth_token = null;
    
    public function init()
    {
        parent::init();
        
        $this->on(self::EVENT_AFTER_FIND, [$this, 'decodeTransactionConfig']);
        $this->on(self::EVENT_BEFORE_INSERT, [$this, 'encodeTransactionConfig']);
        $this->on(self::EVENT_BEFORE_UPDATE, [$this, 'encodeTransactionConfig']);
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'payment_process';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['salt', 'hash', 'amount', 'currency', 'order_id', 'provider_name', 'success_link', 'error_link', 'back_link', 'random_key', 'auth_token', 'transaction_config'], 'required'],
            [['amount', 'close_state', 'is_closed'], 'integer'],
            [['salt', 'hash'], 'string', 'max' => 120],
            [['random_key'], 'string', 'max' => 32],
            [['currency'], 'string', 'max' => 10],
            [['order_id', 'provider_name'], 'string', 'max' => 50],
            [['success_link', 'error_link', 'back_link'], 'string', 'max' => 255],
            [['hash', 'random_key'], 'unique']
        ];
    }
    
    public function decodeTransactionConfig()
    {
        $this->transaction_config = Json::decode($this->transaction_config);
    }
    
    public function encodeTransactionConfig()
    {
        $this->transaction_config = Json::encode($this->transaction_config);
    }

    public function createTokens($inputKey)
    {
        $security = Yii::$app->security;
        
        $random = $security->generateRandomString(32);
        
        $this->salt = $security->generateRandomString(32);

        $this->auth_token = $security->generatePasswordHash($random . $inputKey);
        
        $this->hash = $security->generatePasswordHash($this->salt . $this->auth_token);
        
        $this->random_key = md5($security->generaterandomKey());
    }
    
    public function validateAuthToken()
    {
        return Yii::$app->security->validatePassword($this->salt.$this->auth_token, $this->hash);
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'salt' => 'Salt',
            'hash' => 'Hash',
            'auth_token' => 'Auth Token',
            'amount' => 'Amount',
            'currency' => 'Currency',
            'order_id' => 'Order ID',
            'provider_name' => 'Provider Name',
            'success_link' => 'Success Link',
            'error_link' => 'Error Link',
            'back_link' => 'Back Link',
        ];
    }
    
    public function addEvent($eventType, $message = null)
    {
        $model = new PaymentProcessTrace();
        $model->process_id = $this->id;
        $model->event = $eventType;
        $model->message = $message;
        return $model->save();
    }
}
