<?php

namespace admin\models;

class Config extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'admin_config';
    }

    public static function has($name)
    {
        return (self::find()->where(['name' => $name])->one()) ? true : false;
    }

    public static function get($name)
    {
        $model = self::find()->where(['name' => $name])->asArray()->one();

        if ($model) {
            return $model['value'];
        }

        return;
    }

    public static function set($name, $value)
    {
        $model = self::find()->where(['name' => $name])->one();

        if ($model) {
            $model->value = $value;

            return $model->update(false);
        }

        $model = new self();
        $model->value = $value;
        $model->name = $name;

        return $model->insert(false);
    }

    public static function remove($name)
    {
        $model = self::find()->where(['name' => $name])->one();
        if ($model) {
            return $model->delete();
        }

        return false;
    }
}
