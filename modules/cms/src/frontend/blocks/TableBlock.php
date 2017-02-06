<?php

namespace luya\cms\frontend\blocks;

use luya\TagParser;
use luya\cms\frontend\Module;
use luya\cms\base\PhpBlock;

/**
 * Table Block.
 *
 * @author Basil Suter <basil@nadar.io>
 */
final class TableBlock extends PhpBlock
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
        return Module::t('block_table_name');
    }

    /**
     * @inheritdoc
     */
    public function icon()
    {
        return 'border_all';
    }

    /**
     * @inheritdoc
     */
    public function config()
    {
        return [
            'vars' => [
                ['var' => 'table', 'label' => "", 'type' => 'zaa-table'],
            ],
            'cfgs' => [
                ['var' => 'header', 'label' => Module::t('block_table_header_label'), 'type' => 'zaa-checkbox'],
                ['var' => 'stripe', 'label' => Module::t('block_table_stripe_label'), 'type' => 'zaa-checkbox'],
                ['var' => 'border', 'label' => Module::t('block_table_border_label'), 'type' => 'zaa-checkbox'],
                ['var' => 'equaldistance', 'label' => Module::t('block_table_equaldistance_label'), 'type' => 'zaa-checkbox'],
                ['var' => 'parseMarkdown', 'label' => Module::t('block_table_enable_markdown'), 'type' => 'zaa-checkbox'],
                ['var' => 'divCssClass', 'label' => Module::t('block_cfg_additonal_css_class'), 'type' => self::TYPE_TEXT],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function getFieldHelp()
    {
        return [
            'table' => Module::t('block_table_help_table')
        ];
    }

    /**
     * Get the table data for the table generator.
     *
     * @return array
     */
    public function getTableData()
    {
        $hasHeader = $this->getCfgValue('header', 0);
        $table = [];
        $i = 0;
        foreach ($this->getVarValue('table', []) as $row) {
            ++$i;
            // whether the header data can be skipped or not
            if ($hasHeader == 1 && $i == 1) {
                continue;
            }
            // if markdown enabled parse field values
            if ($this->getCfgValue('parseMarkdown', false)) {
                foreach ($row as $field => $value) {
                    $row[$field] = TagParser::convertWithMarkdown($value);
                }
            }
            
            $table[] = $row;
        }
        
        return $table;
    }

    /**
     * Return the table header array data.
     *
     * @return array
     */
    public function getHeaderRow()
    {
        $data = $this->getVarValue('table', []);

        return (count($data) > 0) ? array_values($data)[0] : [];
    }

    /**
     * @inheritdoc
     */
    public function extraVars()
    {
        return [
            'table' => $this->getTableData(),
            'headerData' => $this->getHeaderRow(),
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function admin()
    {
        return  '<p>{% if extras.table is empty %}<span class="block__empty-text">' . Module::t('block_table_no_table') . '</span>{% else %}'.
                '<table class="bordered striped" style="border:1px solid #d0d0d0">'.
                    '{% if cfgs.header %}'.
                    '<thead>'.
                        '<tr>'.
                            '{% for column in extras.headerData %}<th>{{ column }}</th>{% endfor %}'.
                        '</tr>'.
                    '</thead>'.
                    '{% endif %}'.
                    '<tbody>'.
                        '{% for row in extras.table %}'.
                        '<tr>'.
                            '{% for column in row %}'.
                            '<td {% if cfgs.equaldistance %}class="col s{{ (12/(row|length))|round }}"{% endif %}>{{ column }}</td>'.
                            '{% endfor %}'.
                        '</tr>'.
                        '{% endfor %}'.
                    '</tbody>'.
                '</table>'.
                '{% endif %}';
    }
}
