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
        return 'mdi-action-view-quilt';
    }

    public function config()
    {
        return [
            'vars' => [
                ['var' => 'table', 'label' => 'Text', 'type' => 'zaa-table'],
            ],
            'cfgs' => [
                ['var' => 'header', 'label' => 'Erste Zeile als Tabellenkopf verwenden(Ja/Nein)', 'type' => 'zaa-text'],
                ['var' => 'stripe', 'label' => 'Jede Zeile abwechselnd hervorheben (Zebramuster)(Ja/Nein)', 'type' => 'zaa-text'],
                ['var' => 'border', 'label' => 'Rand zu jeder Seite der Tabelle hinzufügen(Ja/Nein)', 'type' => 'zaa-text'],
            ]
        ];
    }

    public function getTableData()
    {
        $tdata = $this->getVarValue('table');

        $tableData = [];

        if(!empty($tdata)) {

            // skip first row if already used as header
            if($this->useHeader()) {
                $i1 = 0;
            } else {
                $i1 = 1;
            }

            foreach($tdata as $row) {
                if($i1++ > 0) {
                    $rowData = [];

                    $i = 0;
                    foreach($row as $column) {
                        if($i++ > 0 ) {
                            array_push($rowData, $column);
                        }
                    }
                    array_push($tableData, $rowData);
                }
            }
        }

        return $tableData;
    }

    public function getHeaderRow()
    {
        $tdata = $this->getVarValue('table');

        $headerRow = [];

        if(!empty($tdata)) {
            $i = 0;
            foreach($tdata[0] as $column) {
                // skip first entry
                if($i++ > 0) {
                    array_push($headerRow, $column);
                }
            }
        }

        return $headerRow;
    }

    /**
     * @return bool
     * @todo: delete function if checkbox type is available
     */
    public function  useHeader()
    {
        $useHeader = $this->getCfgValue('header', 'Ja');

        if($useHeader == 'Ja') {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return bool
     * @todo: delete function if checkbox type is available
     */
    public function  useStripe()
    {
        $useStripe = $this->getCfgValue('stripe', 'Nein');

        if($useStripe == 'Ja') {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return bool
     * @todo: delete function if checkbox type is available
     */
    public function  useBorder()
    {
        $useBorder = $this->getCfgValue('border', 'Nein');

        if($useBorder == 'Ja') {
            return true;
        } else {
            return false;
        }
    }

    public function extraVars()
    {
        return [
            'table' => $this->getTableData(),
            'header' => $this->getHeaderRow(),
            'useHeader' => $this->useHeader(),
            'useStripe' => $this->useStripe(),
            'useBorder' => $this->useBorder(),
        ];
    }

    public function twigFrontend()
    {
        return  '{% if extras.table is not empty %}'.
                '<table class="table{% if extras.useStripe%} table-striped{% endif %}{% if extras.useBorder%} table-bordered{% endif %}">'.
                    '{% if extras.useHeader %}'.
                    '<thead>'.
                        '<tr>'.
                            '{% for column in extras.header %}'.
                            '<th>{{ column }}</th>{% endfor %}'.
                        '</tr>'.
                    '</thead>'.
                    '{% endif %}'.
                    '<tbody>'.
                        '{% for row in extras.table %}'.
                        '<tr>'.
                            '{% for column in row %}'.
                            '<td>{{ column }}</td>'.
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
                    '{% if extras.useHeader %}'.
                    '<thead>'.
                        '<tr>'.
                            '{% for column in extras.header %}'.
                            '<th>{{ column }}</th>{% endfor %}'.
                        '</tr>'.
                    '</thead>'.
                    '{% endif %}'.
                    '<tbody>'.
                        '{% for row in extras.table %}'.
                        '<tr>'.
                            '{% for column in row %}'.
                            '<td>{{ column }}</td>'.
                            '{% endfor %}'.
                        '</tr>'.
                        '{% endfor %}'.
                    '</tbody>'.
                '</table>'.
                '{% endif %}';
    }
}
