<?php

namespace app\blocks;

class TestBlock extends \cmsadmin\base\Block
{
    public function name()
    {
        return 'Dev/Env Test Block';
    }

    public function icon()
    {
        return 'developer_mode';
    }

    public function config()
    {
        return [
            'vars' => [
                ['var' => 'text', 'label' => 'Text', 'type' => 'zaa-text', 'placeholder' => 'Ich bin ein Platzhalter'],
                ['var' => 'textarea', 'label' => 'Textarea', 'type' => 'zaa-textarea', 'placeholder' => 'Ich bin ein im Text'],
                ['var' => 'number', 'label' => 'Number', 'type' => 'zaa-number', 'placeholder' => '1986'],
                ['var' => 'password', 'label' => 'Password', 'type' => 'zaa-password'],
                ['var' => 'select', 'label' => 'Select', 'type' => 'zaa-select', 'options' => [['value' => 1, 'label' => 'Value 1']]],
                ['var' => 'table', 'label' => 'Table', 'type' => 'zaa-table'],
                ['var' => 'checkbox', 'label' => 'Basic Checkbox', 'type' => 'zaa-checkbox'],
                ['var' => 'checkboxarray', 'label' => 'Checkbox Array', 'type' => 'zaa-checkbox-array', 'options' => ['items' => [['value' => 1, 'label' => 'Label for Value 1'], ['value' => '2', 'label' => 'Label for Value 2'], ['value' => 3, 'label' => 'Label for Value 3']]]],
                ['var' => 'date', 'label' => 'Date Picker', 'type' => 'zaa-date'],
                ['var' => 'datetime', 'label' => 'Date Time Picker', 'type' => 'zaa-datetime'],
                ['var' => 'fileupload', 'label' => 'Fileupload', 'type' => 'zaa-file-upload'],
                ['var' => 'imageupload', 'label' => 'Imageupload', 'type' => 'zaa-image-upload'],
                ['var' => 'imagearrayupload', 'label' => 'ImageArrayUpload', 'type' => 'zaa-image-array-upload'],
                ['var' => 'filearrayupload', 'label' => 'FileArrayUpload', 'type' => 'zaa-file-array-upload'],
                ['var' => 'listarray', 'label' => 'ListArray', 'type' => 'zaa-list-array'],
            ],
            'placeholders' => [
                ['var' => 'links', 'label' => 'links'],
                ['var' => 'rechts', 'label' => 'Rechts'],
            ],
        ];
    }

    public function twigFrontend()
    {
        $str = '<table style="width:100%;" class="table-bordered">';
        $str .= '<thead><tr><th>Variabel</th><th>Dump</th></tr></thead>';
        foreach ($this->getVars() as $row) {
            $str .= '<tr><td style="padding:5px;">'.$row['label'].' ('.$row['var'].')</td><td style="padding:5px;"><pre>{{ dump(vars.'.$row['var'].') }}</pre></td></tr>';
        }
        $str .= '</table>';

        return $str;
    }

    public function twigAdmin()
    {
        return '<p>[DEV TEST BLOCK]</p>';
    }
}
