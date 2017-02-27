<?php

namespace luya\cms\injectors;

use luya\cms\base\BaseBlockInjector;
use luya\admin\base\TypesInterface;
use luya\cms\helpers\BlockHelper;
use luya\admin\models\Tag;
use luya\helpers\ArrayHelper;

class TagInjector extends BaseBlockInjector
{
    private function getCheckboxArray()
    {
        return Tag::find()->select(['name'])->indexBy('id')->column();
    }
    
    private function getExtraData()
    {
        $ids = ArrayHelper::getColumn($this->getContextConfigValue($this->varName, []), 'value');
        
        $data = Tag::find()->where(['in','id', $ids])->all();
        
        return $data;
    }
    
    public function setup()
    {
        $this->setContextConfig([
            'var' => $this->varName,
            'type' => TypesInterface::TYPE_CHECKBOX_ARRAY,
            'label' => $this->varLabel,
            'options' => BlockHelper::checkboxArrayOption($this->getCheckboxArray()),
        ]);
        
        $this->context->addExtraVar($this->varName, $this->getExtraData());
    }
}