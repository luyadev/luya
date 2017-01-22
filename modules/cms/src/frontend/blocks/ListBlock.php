<?php

namespace luya\cms\frontend\blocks;

use luya\cms\frontend\Module;
use luya\cms\frontend\blockgroups\TextGroup;
use luya\cms\base\TwigBlock;
use luya\cms\base\PhpBlock;

/**
 * UL/OL list block.
 *
 * @author Basil Suter <basil@nadar.io>
 */
final class ListBlock extends PhpBlock
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
        return Module::t('block_list_name');
    }

    /**
     * @inheritdoc
     */
    public function icon()
    {
        return 'view_list';
    }
    
    /**
     * @inheritdoc
     */
    public function blockGroup()
    {
        return TextGroup::className();
    }

    /**
     * @inheritdoc
     */
    public function config()
    {
        return [
            'vars' => [
                ['var' => 'elements', 'label' => Module::t('block_list_elements_label'), 'type' => 'zaa-list-array'],
                ['var' => 'listType', 'label' => Module::t('block_list_listtype_label'), 'initvalue' => 'ul', 'type' => 'zaa-select', 'options' => [
                        ['value' => 'ul', 'label' => Module::t('block_list_listtype_ul')],
                        ['value' => 'ol', 'label' => Module::t('block_list_listtype_ol')],
                    ],
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
            'listType' => $this->getVarValue('listType', 'ul'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function admin()
    {
        return '{% if vars.elements is empty%}<span class="block__empty-text">' . Module::t('block_list_no_content') . '</span>{% else %}<{{ extras.listType }}>{% for row in vars.elements if row.value is not empty %}<li>{{ row.value }}</li>{% endfor %}</{{ extras.listType }}>{% endif %}';
    }
}
