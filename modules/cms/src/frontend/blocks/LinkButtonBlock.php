<?php

namespace luya\cms\frontend\blocks;

use luya\cms\frontend\Module;
use luya\cms\base\PhpBlock;
use luya\cms\injectors\LinkInjector;

/**
 * Simple button element with a link function
 *
 * @author Basil Suter <basil@nadar.io>
 */
final class LinkButtonBlock extends PhpBlock
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
    public function name()
    {
        return Module::t('block_link_button_name');
    }

    /**
     * @inheritdoc
     */
    public function icon()
    {
        return 'link';
    }
    
    /**
     * @inheritdoc
     */
    public function injectors()
    {
        return [
            'linkData' => new LinkInjector([
                'varLabel' => Module::t('block_link_button_btnhref_label'),
            ]),
        ];
    }

    /**
     * @inheritdoc
     */
    public function config()
    {
        return [
            'vars' => [
                ['var' => 'label', 'label' => Module::t('block_link_button_btnlabel_label'), 'type' => 'zaa-text'],
            ],
            'cfgs' => [
                [
                    'var' => 'targetBlank',
                    'label' => Module::t('block_link_button_targetblank_label'),
                    'type' => 'zaa-checkbox'
                ],
                [
                    'var' => 'simpleLink',
                    'label' => Module::t('block_link_button_simpleLink_label'),
                    'type' => 'zaa-checkbox'
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function extraVars()
    {
        return [
            'cssClass' => $this->getCfgValue('simpleLink') ? null : 'btn btn-default',
        ];
    }

    /**
     * @inheritdoc
     */
    public function admin()
    {
        return '<p>{% if vars.label is empty or vars.linkData is empty %}' . Module::t('block_link_button_name') . ': ' . Module::t('block_link_button_empty') . '{% else %}' .
        '{% if vars.label is not empty %}<a class="btn disabled">{{ vars.label }}</a>{% endif %}{% endif %}</p>';
    }
}
