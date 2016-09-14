<?php

namespace luya\cms\frontend\blocks;

use luya\cms\frontend\Module;
use luya\cms\base\TwigBlock;

/**
 * Simple horizontal line block
 * 
 * @author Basil Suter <basil@nadar.io>
 */
class LineBlock extends TwigBlock
{
    public $cacheEnabled = true;
    
    public function name()
    {
        return Module::t('block_line_name');
    }

    public function icon()
    {
        return 'remove';
    }

    public function config()
    {
        return [
           'vars' => [
                ['var' => 'lineSpace', 'label' => Module::t('block_line_linespace_label'), 'type' => 'zaa-select', 'options' => [
                    ['value' => '5px', 'label' => '5px ' . Module::t('block_line_linespace_space')],
                    ['value' => '10px', 'label' => '10px ' . Module::t('block_line_linespace_space')],
                    ['value' => '20px', 'label' => '20px ' . Module::t('block_line_linespace_space')],
                    ['value' => '30px', 'label' => '30px ' . Module::t('block_line_linespace_space')],
                ], 'initvalue' => '5px'],
                ['var' => 'lineStyle', 'label' => Module::t('block_line_linestyle_label'), 'type' => 'zaa-select', 'options' => [
                    ['value' => 'dotted', 'label' => Module::t('block_line_linestyle_dotted')],
                    ['value' => 'dashed', 'label' => Module::t('block_line_linestyle_dashed')],
                    ['value' => 'solid', 'label' => Module::t('block_line_linestyle_solid')],
                ], 'initvalue' => 'solid'],
                ['var' => 'lineWidth', 'label' => Module::t('block_line_linewidth_label'), 'type' => 'zaa-select', 'options' => [
                    ['value' => '1px', 'label' => '1px'],
                    ['value' => '2px', 'label' => '2px'],
                    ['value' => '3px', 'label' => '3px'],
                ], 'initvalue' => '1px'],
                ['var' => 'lineColor', 'label' => Module::t('block_line_linecolor_label'), 'type' => 'zaa-select', 'options' => [
                    ['value' => '#ccc', 'label' => Module::t('block_line_linecolor_grey')],
                    ['value' => '#000', 'label' => Module::t('block_line_linecolor_black')],
                ], 'initvalue' => '#ccc']
            ],
        ];
    }

    /**
     * Available twig variables:
     * @param {{vars.lineSpace}}
     * @param {{vars.lineStyle}}
     * @param {{vars.lineWidth}}
     * @param {{vars.lineColor}}
     */
    public function twigFrontend()
    {
        return '<hr style="border: 0; border-bottom: {{ vars.lineWidth }} {{ vars.lineStyle }} {{ vars.lineColor }}; margin: {{ vars.lineSpace }} 0;"/>';
    }

    /**
     * Available twig variables:
     * @param {{vars.lineSpace}}
     * @param {{vars.lineStyle}}
     * @param {{vars.lineWidth}}
     * @param {{vars.lineColor}}
     */
    public function twigAdmin()
    {
        return '<p><hr/></p>';
    }
}
