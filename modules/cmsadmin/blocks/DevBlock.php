<?php

namespace cmsadmin\blocks;

class DevBlock extends \cmsadmin\base\Block
{
    public $module = 'cmsadmin';

    public function name()
    {
        return 'Frontend Übersicht';
    }

    public function icon()
    {
        return 'developer_mode';
    }

    public function config()
    {
        return ['',
        ];
    }

    public function twigFrontend()
    {
        return $this->render();
    }

    public function twigAdmin()
    {
        return '';
    }
}
