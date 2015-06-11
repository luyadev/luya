<?php

namespace cmsadmin\blocks;

class FileListBlock extends \cmsadmin\base\Block
{
    public $module = 'cmsadmin';
    
    public function name()
    {
        return 'Dateileiste';
    }

    public function config()
    {
        return [
            'vars' => [
                ['var' => 'files', 'label' => 'Dateien', 'type' => 'zaa-file-array-upload'],
            ]
        ];
    }

    public function twigFrontend()
    {
        return '<ul>{% for file in vars.files %}<li><a href="#">{{ file.caption }}</a></li>{% endfor %}</ul>';
    }

    public function twigAdmin()
    {
        return '<p>Dateiliste</p>';
    }
}
