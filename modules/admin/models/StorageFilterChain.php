<?php

namespace admin\models;

use yii\helpers\Json;

class StorageFilterChain extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'admin_storage_filter_chain';
    }

    public function init()
    {
        parent::init();
        $this->on(self::EVENT_BEFORE_VALIDATE, [$this, 'eventBeforeValidate']);
        $this->on(self::EVENT_AFTER_FIND, [$this, 'eventAfterFind']);
    }

    public function rules()
    {
        return [
            [['filter_id', 'effect_id'], 'required'],
            [['effect_json_values'], 'safe'],
        ];
    }

    public function eventBeforeValidate()
    {
        if (is_array($this->effect_json_values)) {
            $this->effect_json_values = Json::encode($this->effect_json_values);
        }
    }

    public function eventAfterFind()
    {
        $this->effect_json_values = Json::decode($this->effect_json_values);
    }

    public function getEffect()
    {
        return $this->hasOne(\admin\models\StorageEffect::className(), ['id' => 'effect_id']);
    }
}
