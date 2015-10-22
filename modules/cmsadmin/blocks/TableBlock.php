<?php

namespace cmsadmin\blocks;

class TableBlock extends \cmsadmin\base\Block
{
    public $module = 'cmsadmin';

    public function name()
    {
        return 'Tabelle';
    }

    public function icon()
    {
        return 'border_all';
    }

    public function config()
    {
        return [
            'vars' => [
                ['var' => 'table', 'label' => 'Text', 'type' => 'zaa-table'],
            ],
            'cfgs' => [
                ['var' => 'header', 'label' => 'Erste Zeile als Tabellenkopf verwenden', 'type' => 'zaa-checkbox'],
                ['var' => 'stripe', 'label' => 'Jede Zeile abwechselnd hervorheben (Zebramuster)', 'type' => 'zaa-checkbox'],
                ['var' => 'border', 'label' => 'Rand zu jeder Seite der Tabelle hinzufügen', 'type' => 'zaa-checkbox'],
                ['var' => 'equaldistance', 'label' => 'Spaltenabstände gleich gross', 'type' => 'zaa-checkbox'],
            ],
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
        return  '<p>{% if extras.table is empty %}<span class="block__empty-text">Es wurde noch keine Tabelle angelegt.</span>{% else %}'.
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
