<?php

namespace admin\base;

use admin\models\Property as PropertyModel;

/**
 * Abstract Page Property Class.
 * 
 * @todo remove defaultValue change to initvalue like in blocks!
 *
 * @author nadar
 */
abstract class Property extends \yii\base\Component
{
    const EVENT_BEFORE_RENDER = 'EVENT_BEFORE_RENDER';

    const EVENT_BEFORE_FIND = 'EVENT_BEFORE_FIND';

    public $moduleName = null;

    public $value = null;

    public function find()
    {
        $this->trigger(self::EVENT_BEFORE_FIND);
    }

    abstract public function varName();

    abstract public function label();

    abstract public function type();

    public function options()
    {
        return [];
    }

    public function defaultValue()
    {
        return false;
    }

    public function install()
    {
        $model = PropertyModel::find()->where(['var_name' => $this->varName()])->one();
        if ($model) {
            $model->setAttributes([
                'module_name' => $this->moduleName,
                //'type' => $this->type(),
                //'label' => $this->label(),
                //'option_json' => json_encode($this->options()),
                //'default_value' => $this->defaultValue(),
                'class_name' => static::className(),
            ]);
            $model->update(false);

            return $model->id;
        } else {
            $model = new PropertyModel();
            $model->setAttributes([
                'var_name' => $this->varName(),
                'module_name' => $this->moduleName,
                //'type' => $this->type(),
                //'label' => $this->label(),
                //'option_json' => json_encode($this->options()),
                //'default_value' => $this->defaultValue(),
                'class_name' => static::className(),
            ]);
            $insert = $model->insert(false);
            if ($insert) {
                return $model->id;
            }
        }
    }
}
