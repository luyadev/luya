<?php

namespace luya\cms\frontend\blocks;

use luya\cms\frontend\Module;
use luya\cms\frontend\blockgroups\DevelopmentGroup;
use luya\cms\base\PhpBlock;

/**
 * HTML Block
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
final class HtmlBlock extends PhpBlock
{
    /**
     * @inheritdoc
     */
    public $module = 'cms';

    /**
     * @inheritdoc
     */
    public $cacheEnabled = true;
    
    /**
     * @inheritdoc
     */
    public function blockGroup()
    {
        return DevelopmentGroup::className();
    }
    
    /**
     * @inheritdoc
     */
    public function name()
    {
        return Module::t('block_html_name');
    }
    
    /**
     * @inheritdoc
     */
    public function icon()
    {
        return 'code';
    }

    /**
     * @inheritdoc
     */
    public function config()
    {
        return [
            'vars' => [
                ['var' => 'html', 'label' => Module::t('block_html_html_label'), 'type' => self::TYPE_TEXTAREA],
            ],
            'cfgs' => [
                ['var' => 'raw', 'label' => Module::t('block_html_cfg_raw_label'), 'type' => self::TYPE_CHECKBOX]
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function admin()
    {
        $message =  Module::t('block_html_no_content');
        return <<<EOT
    	{% if vars.html is empty %}
    		<span class="block__empty-text">{$message}</span>{% else %}
    		{% if cfgs.raw == 1 %}
    			{{ vars.html | raw }}
    		{% else %}
                <code>{{ vars.html | escape }}</code>
    		{% endif %}
    	{% endif %}
EOT;
    }
}
