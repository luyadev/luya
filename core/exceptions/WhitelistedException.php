<?php

namespace luya\exceptions;

use luya\Exception;

/**
 * An exception which is Whitelisted and therefore expected.
 * 
 * > Whitelisted Exception won't be transmitted to the LUYA error api.
 * 
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.21
 */
class WhitelistedException extends Exception
{
}