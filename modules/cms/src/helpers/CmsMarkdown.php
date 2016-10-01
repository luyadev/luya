<?php

namespace luya\cms\helpers;

use luya\tag\TagMarkdownParser;

trigger_error("luya\cms\CmsMarkdown deprecated use luya\TagMarkdownParser instead.", E_USER_DEPRECATED);

/**
 * CmsMarkdownParser
 * 
 * @author Basil Suter <basil@nadar.io>
 * @deprecated
 */
class CmsMarkdown extends TagMarkdownParser
{
}
