<?php

namespace luya\cms\injectors;

use luya\cms\base\BaseBlockInjector;
use luya\cms\helpers\BlockHelper;

/**
 * Link Injector to generate links.
 *
 * Ability to select a link in the administration interface and return the path to the link indipendent from internal or external links.
 *
 * ```php
 * new LinkInjector();
 * ```
 *
 * In order to configure the LinkInjector, use the {{\luya\cms\base\InternalBaseBlock::injectors}} method:
 *
 * ```php
 * public function injectors()
 * {
 *     return [
 *	       'theLink' => new \luya\cms\injectors\LinkInjector()
 *	   ];
 * }
 * ```
 *
 * The value of the `$this->extraValue('theLink')` is a {{luya\web\LinkInterface}} therefor you can access the `getHref` and `getTarget` methods in order to generate the link:
 *
 * ```php
 * <a href="<?= $this->extraValue('link')?>" target="<?= $this->extraValue('link')->getTarget(); ?>">Go There</a>
 * ```
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
final class LinkInjector extends BaseBlockInjector
{
    private function getLinkUrl()
    {
        $content = $this->getContextConfigValue($this->varName);
    
        return BlockHelper::linkObject($content);
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
