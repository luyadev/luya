<?php

namespace luya\cms\helpers;

use luya\TagParser as BaseTagParser;

trigger_error("luya\cms\TagParser deprecated use luya\TagParser instead.", E_USER_DEPRECATED);

/**
 * CMS Tag Parser
 * 
 * @author Basil Suter <basil@nadar.io>
 * @deprecated
 */
class TagParser extends BaseTagParser
{
}
