<?php

namespace luya\cms\injectors;

use Yii;
use luya\cms\base\BaseBlockInjector;

class LinkInjector extends BaseBlockInjector
{
    private function getLinkUrl()
    {
        $content = $this->getContextConfigValue($this->varName);
    
        if (!empty($content) && isset($content['type'])) {
            switch ($content['type']) {
                case 1:
                    return Yii::$app->menu->findOne(['id' => $content['value']])->link;
                case 2:
                    return $content['value'];
            }
        }
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see \luya\cms\base\BaseBlockInjector::setup()
     */
    public function setup()
    {
        $this->setContextConfig([
           'var' => $this->varName,
           'type' => 'zaa-link',
           'label' => $this->varLabel,
       ]);
       
        $this->context->addExtraVar($this->varName, $this->getLinkUrl());
    }
}
