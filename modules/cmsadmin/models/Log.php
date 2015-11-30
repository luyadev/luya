<?php

namespace cmsadmin\models;

use Yii;

class Log extends \yii\db\ActiveRecord
{
    public function init()
    {
        parent::init();
        $this->on(self::EVENT_BEFORE_INSERT, [$this, 'onBeforeInsert']);
    }

    public function onBeforeInsert()
    {
        $this->timestamp = time();
        $this->user_id = (Yii::$app instanceof \luya\web\Application) ? Yii::$app->adminuser->getId() : 0;
        $this->data_json = json_encode($this->data_json);
    }

    public static function tableName()
    {
        return 'cms_log';
    }

    public function rules()
    {
        return [
            [['is_insertion', 'is_deletion', 'is_update', 'message', 'data_json'], 'safe'],
        ];
    }

    /**
     * add new log entry.
     * 
     * @param int    $type    The type of add
     *                        + 1 = insertion
     *                        + 2 = update
     *                        + 3 = deletion
     * @param string $message
     */
    public static function add($type, $message, array $additionalData = [])
    {
        $attrs = [
            'is_insertion' => ($type == 1) ? 1 : 0,
            'is_update' => ($type == 2) ? 1 : 0,
            'is_deletion' => ($type == 3) ? 1 : 0,
            'message' => $message,
            'data_json' => $additionalData,
        ];

        $model = new self();
        $model->setAttributes($attrs);

        return $model->insert(false);
    }
}
