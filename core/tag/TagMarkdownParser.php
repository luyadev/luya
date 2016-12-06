<?php

namespace luya\tag;

use cebe\markdown\GithubMarkdown;

/**
 * Tag Parser Markdown.
 * 
 * In order to fix conflicts with the TagParser the auto enabled url parser is disabled. This means the following will not genereate a link tag:
 * 
 * + http://luya.io
 * + www.luya.io
 * 
 * Otherwise those values would be automatiaclly converted to html link tags (<a href="www.luya.io">www.luya.io</a>).
 * 
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0-rc1
 */
class TagMarkdownParser extends GithubMarkdown
{
    /**
     * @var boolean To convert all newlines to <br/>-tags. By default only newlines with two preceding spaces are converted to <br/>-tags.
     */
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
