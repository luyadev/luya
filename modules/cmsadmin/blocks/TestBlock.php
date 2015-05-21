<?php

namespace cmsadmin\blocks;

class TestBlock extends \cmsadmin\base\Block
{
    public $module = 'cmsadmin';
    
    public function name()
    {
        return '[DEV TEST BLOCk]';
    }

    public function config()
    {
        return [
            'vars' => [
                ['var' => 'text', 'label' => 'Text', 'type' => 'zaa-text'],
                ['var' => 'textarea', 'label' => 'Textarea', 'type' => 'zaa-textarea'],
                ['var' => 'password', 'label' => 'Password', 'type' => 'zaa-password'],
                ['var' => 'select', 'label' => 'Select', 'type' => 'zaa-select', 'options' => [ ['value' => 1, 'label' => 'Value 1'] ] ],
                ['var' => 'testcheckbox', 'label' => 'Checkbox Label', 'type' => 'zaa-checkbox', 'options' => ['items' => [ ['id' => 1, 'label' => 'Label for Value 1'] ]]],
                ['var' => 'datepicker', 'label' => 'Datepicker', 'type' => 'zaa-datepicker'],
                ['var' => 'fileupload', 'label' => 'Fileupload', 'type' => 'zaa-file-upload'],
                ['var' => 'imageupload', 'label' => 'Imageupload', 'type' => 'zaa-image-upload'],
                ['var' => 'imagearrayupload', 'label' => 'ImageArrayUpload', 'type' => 'zaa-image-array-upload'],
                ['var' => 'filearrayupload', 'label' => 'FileArrayUpload', 'type' => 'zaa-file-array-upload'],
                ['var' => 'listarray', 'label' => 'ListArray', 'type' => 'zaa-list-array'],
            ]
        ];
    }

    public function twigFrontend()
    {
        $str = '<div style="border:1px solid red; padding:10px; ">';
        $str.= 'Text:<br /><pre>{{ dump(vars.text) }}</pre>Textarea:<br /><pre>{{ dump(vars.textarea) }}</pre>Passwort:<br /><pre>{{ dump(vars.password) }}</pre>Select:<br /><pre>{{ dump(vars.select) }}</pre>Textcheckbox:<br /><pre>{{ dump(vars.testcheckbox) }}</pre>Datepicker:<br /><pre>{{ dump(vars.datepicker) }}</pre>';
        $str.= 'Fileupload:<pre>{{ dump(vars.fileupload) }}</pre>Imageupload:<br /><pre>{{ dump(vars.imageupload) }}</pre>ImageArrayUpload:<br /><pre>{{ dump(vars.imagearrayupload) }}</pre>FileArrayUpload:<br /><pre>{{ dump(vars.filearrayupload) }}</pre>ListArray:<br /><pre>{{ dump(vars.listarray) }}</pre><hr />';
        $str.= '</div>';
        return $str;
    }

    public function twigAdmin()
    {
        return '<p>[DEV TEST BLOCK]</p>';
    }
}
