<?php

namespace luya\tag;

use cebe\markdown\GithubMarkdown;

/**
 * TagParserMarkdown disables the auto URL generate feature in order to fix issue with TagParser.
 * 
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0-rc1
 */
class TagMarkdownParser extends GithubMarkdown
{
    public $enableNewlines = true;
    
    /**
     * Disable the url parsing of markdown.
     * 
     * @param string $markdown
     */
    protected function parseUrl($markdown)
    {
        return;
    }
}
