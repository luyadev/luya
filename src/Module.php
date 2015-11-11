<?php

namespace luya;

class Module extends \luya\base\Module
{
    /**
     * The current luya version.
     *
     * @link https://github.com/zephir/luya/blob/master/CHANGELOG.md
     *
     * @var string
     */
    const VERSION = '1.0.0-beta2-dev';

    /**
     * Default url behavior if luya is included. first rule which will be picked.
     *
     * @var array
     */
    public $urlRules = [
        ['class' => 'luya\components\UrlRule'],
    ];
}
