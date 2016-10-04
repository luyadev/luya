<?php

namespace luya\cms\frontend\blocks;

use luya\cms\frontend\Module;
use luya\TagParser;
use luya\cms\base\TwigBlock;

/**
 * Table Block.
 * 
 * @author Basil Suter <basil@nadar.io>
 */
class TableBlock extends TwigBlock
{
    public $module = 'cms';
    
    public $cacheEnabled = true;

    public function name()
    {
        return Module::t('block_table_name');
    }

    public function icon()
    {
        return 'border_all';
    }

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
            ],
        ];
    }

    public function getFieldHelp()
    {
        return [
            'table' => Module::t('block_table_help_table')
        ];
    }

    public function getTableData()
    {
        $table = [];
        $i = 0;
        foreach ($this->getVarValue('table', []) as $key => $row) {
            ++$i;

            if ($this->getCfgValue('header', 0) == 1 && $i == 1) {
                continue;
            }

            if ($this->getCfgValue('parseMarkdown', false)) {
                foreach ($row as $k => $v) {
                    $row[$k] = TagParser::convertWithMarkdown($v);
                }
            }
            
            $table[] = $row;
        }
        return $table;
    }

    public function getHeaderRow()
    {
        $data = $this->getVarValue('table', []);

        return (count($data) > 0) ? array_values($data)[0] : [];
    }

    public function extraVars()
    {
        return [
            'table' => $this->getTableData(),
            'headerData' => $this->getHeaderRow(),
        ];
    }

    public function twigFrontend()
    {
        return  '{% if extras.table is not empty %}'.
                '<table class="table{% if cfgs.stripe %} table-striped{% endif %}{% if cfgs.border %} table-bordered{% endif %}">'.
                    '{% if cfgs.header %}'.
                    '<thead>'.
                        '<tr>'.
                            '{% for column in extras.headerData %}'.
                            '<th>{{ column }}</th>{% endfor %}'.
                        '</tr>'.
                    '</thead>'.
                    '{% endif %}'.
                    '<tbody>'.
                        '{% for row in extras.table %}'.
                        '<tr>'.
                            '{% for column in row %}'.
                            '<td {% if cfgs.equaldistance %}class="col-md-{{ (12/(row|length))|round }}"{% endif %}>{{ column }}</td>'.
                            '{% endfor %}'.
                        '</tr>'.
                        '{% endfor %}'.
                    '</tbody>'.
                '</table>'.
                '{% endif %}';
    }

    public function twigAdmin()
    {
        return  '<p>{% if extras.table is empty %}<span class="block__empty-text">' . Module::t('block_table_no_table') . '</span>{% else %}'.
                '<table>'.
                    '{% if cfgs.header %}'.
                    '<thead>'.
                        '<tr>'.
                            '{% for column in extras.headerData %}'.
                            '<th>{{ column }}</th>{% endfor %}'.
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
