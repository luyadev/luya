<?php

namespace luya\exporter;

use luya\base\CoreModuleInterface;

final class Module extends \luya\base\Module implements CoreModuleInterface
{
    public $downloadPassword = false;

    public $downloadFile = '@runtime/exporter/download.zip';
}
