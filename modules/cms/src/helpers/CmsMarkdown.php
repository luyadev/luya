<?php

namespace cms\helpers;

use cebe\markdown\GithubMarkdown;

/**
 * CmsMarkdown disables the auto URL generate feature in order to fix issue with TagParser.
 * 
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0-beta8
 */
class CmsMarkdown extends GithubMarkdown
{
	public $enableNewlines = true;
	
    protected function parseUrl($markdown)
    {
        return;
    }
}
