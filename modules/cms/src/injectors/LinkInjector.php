<?php

namespace luya\cms\injectors;

use Yii;
use luya\cms\base\BaseBlockInjector;

/**
 * Link Injector to generate links.
 *
 * Ability to select a link in the administration interface and return the path to the link indipendent from internal or external links.
 *
 * ```php
 * new LinkInjector();
 * ```
 *
 * @author Basil Suter <basil@nadar.io>
 */
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
     * @inheritdoc
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
