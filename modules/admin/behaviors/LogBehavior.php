<?php

namespace admin\behaviors;

use yii\db\ActiveRecord;

class LogBehavior extends \yii\base\Behavior
{
    public $route = '';

    public $api = '';
    
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'eventAfterInsert',
            ActiveRecord::EVENT_AFTER_UPDATE => 'eventAfterUpdate',
        ];
    }

    public function init()
    {
        if (empty($this->route) && empty($this->api)) {
            throw new \Exception('LogBehavior route or api property must be set.');
        }
    }

    public function eventAfterInsert($event)
    {
        if (\yii::$app instanceof \yii\web\Application) {
            \yii::$app->db->createCommand()->insert('admin_ngrest_log', [
                'user_id' => (is_null(\admin\Module::getAdminUserData())) ? 0 : \admin\Module::getAdminUserData()->id,
                'timestamp_create' => time(),
                'route' => $this->route,
                'api' => $this->api,
                'is_insert' => 1,
                'is_update' => 0,
                'attributes_json' => json_encode($event->sender->getAttributes()),
            ])->execute();
        }
    }

    public function eventAfterUpdate($event)
    {
        if (\yii::$app instanceof \yii\web\Application) {
            \yii::$app->db->createCommand()->insert('admin_ngrest_log', [
                'user_id' => (is_null(\admin\Module::getAdminUserData())) ? 0 : \admin\Module::getAdminUserData()->id,
                'timestamp_create' => time(),
                'route' => $this->route,
                'api' => $this->api,
                'is_insert' => 0,
                'is_update' => 1,
                'attributes_json' => json_encode($event->sender->getAttributes()),
            ])->execute();
        }
    }
}
