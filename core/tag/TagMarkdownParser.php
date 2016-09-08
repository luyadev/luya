<?php

namespace luya\tag;

use cebe\markdown\GithubMarkdown;

/**
 * TagParserMarkdown disables the auto URL generate feature in order to fix issue with TagParser.
 * 
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0-beta8
 */
class TagMarkdownParser extends GithubMarkdown
{
    public $enableNewlines = true;
    
    protected function parseUrl($markdown)
    {
        return;
    }
}
