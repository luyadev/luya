<?php

namespace app\modules\contactmanager\frontend;

/**
 * Contactmanager Admin Module.
 *
 * File has been created with `module/create` command on LUYA version 1.0.0-dev.
 */
class Module extends \luya\base\Module
{
    public $urlRules = [
        'contactmanager/default/captcha' => 'contactmanager/default/captcha',
    ];
}
