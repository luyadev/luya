<?php

namespace admin\apis;

use admin\models\Property;
use admin\models\Lang;

class CommonController extends \admin\base\RestController
{
    public function actionDataLanguages()
    {
        return Lang::find()->asArray()->all();
    }
    
    public function actionDataProperties()
    {
        $data = [];
        foreach (Property::find()->all() as $item) {
            $object = Property::getObject($item->class_name);
            $data[] = [
                'id' => $item->id,
                'var_name' => $object->varName(),
                'option_json' => $object->options(),
                'label' => $object->label(),
                'type' => $object->type(),
                'default_value' => $object->defaultValue(),
            ];
        }
        
        return $data;
    }
}