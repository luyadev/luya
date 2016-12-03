<?php

namespace luya;

/*
 * We have skipped the active support/testing for PHP 5.5 and recommend PHP 5.6.
 */
if (!version_compare(PHP_VERSION, '5.5.0', '>=')) {
    trigger_error('Some functions of LUYA need php version 5.5.0 or higher! You are currently using Version: '.PHP_VERSION, E_USER_ERROR);
}

/**
 * The LUYA boot class to startup the application
 *
 * @author Basil Suter <basil@nadar.io>
 */
class Boot extends \luya\base\Boot
{
}
