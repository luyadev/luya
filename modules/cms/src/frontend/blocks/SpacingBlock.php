<?php

namespace luya\cms\frontend\blocks;

use luya\cms\frontend\Module;
use luya\cms\base\PhpBlock;
use luya\cms\helpers\BlockHelper;

/**
 * Margin Top/Bottom block with Paragraph.
 *
 * @author Basil Suter <basil@nadar.io>
 */
final class SpacingBlock extends PhpBlock
{
    /**
     * @inheritdoc
     */
    public $module = 'cms';
    
    /**
     * @inheritdoc
     */
    public $cacheEnabled = true;
    
    protected function getSpacings()
    {
        return [
            1 => Module::t('block_spacing_small_space'),
            2 => Module::t('block_spacing_medium_space'),
            3 => Module::t('block_spacing_large_space'),
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function name()
    {
        return Module::t('block_spacing_name');
    }
    
    /**
     * @inheritdoc
     */
    public function getIsDirtyDialogEnabled()
    {
        return false;
    }

    /**
     * @inheritdoc
     */
    public function icon()
    {
        return 'format_line_spacing';
    }

    /**
     * @inheritdoc
     */
    public function config()
    {
        return [
            'vars' => [
                [
                    'var' => 'spacing',
                    'label' => Module::t('block_spacing_spacing_label'),
                    'initvalue' => 1,
                    'type' => self::TYPE_SELECT,
                    'options' => BlockHelper::selectArrayOption($this->getSpacings()),
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
            'spacingLabel' => $this->getSpacings()[$this->getVarValue('spacing', 1)],
        ];
    }

    /**
     * @inheritdoc
     */
    public function admin()
    {
        return '<span class="block__empty-text">{{ extras.spacingLabel }}</span>';
    }
}
