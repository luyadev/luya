<?php

namespace admin\base;

use Exception;
use admin\models\Property as PropertyModel;

abstract class Property extends \yii\base\Object
{
    public $moduleName = null;
    
    public function init()
    {
        if ($this->moduleName === null) {
            throw new Exception("moduleName property can not be empty when creating property Object.");
        }
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
                'type' => $this->type(),
                'label' => $this->label(),
                'option_json' => json_encode($this->options()),
                'default_value' => $this->defaultValue(),
            ]);
            $model->update(false);
            return $model->id;
        } else {
            $model = new PropertyModel();
            $model->setAttributes([
                'var_name' => $this->varName(),
                'module_name' => $this->moduleName,
                'type' => $this->type(),
                'label' => $this->label(),
                'option_json' => json_encode($this->options()),
                'default_value' => $this->defaultValue(),
            ]);
            $insert = $model->insert(false);
            if ($insert) {
                return $model->id;
            }
        }
    }
}