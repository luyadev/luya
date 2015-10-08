<?php

namespace styleguide;

class Module extends \luya\base\Module
{
    public $isCoreModule = true;

    public $useAppLayoutPath = false;

    public $controllerUseModuleViewPath = true;

    public $password = false;
}
