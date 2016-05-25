<?php

namespace luya;

/*
 * PHP Version 5.5 is not active tested anymore, but still works but its not supported.  
 */
if (!version_compare(PHP_VERSION, '5.5.0', '>=')) {
    trigger_error('Some functions of LUYA need php version 5.5.0 or higher! You are currently using Version: '.PHP_VERSION, E_USER_ERROR);
}

/**
 * The LUYA boot class to startup the application
 * 
 * @author nadar
 */
class Boot extends \luya\base\Boot
{
}
