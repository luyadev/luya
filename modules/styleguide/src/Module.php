<?php

namespace styleguide;

use luya\base\CoreModuleInterface;

class Module extends \luya\base\Module implements CoreModuleInterface
{
    public $useAppLayoutPath = false;

    public $password = false;
}
