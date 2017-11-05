<?php

namespace luya\cms\tags;

use luya\tag\BaseTag;
use luya\cms\models\Nav;
use luya\cms\models\NavItem;

/**
 * Get the Content of CMS Page.
 *
 * Allows you to get the content of a page with the cmslayout or get the content of a placeholder inside the cmslayout of a page.
 *
 * This allows you to Return the content of another page wherever your are. You can also use the PageTag in its Php from without the TagParser.
 *
 * Example native call:
 *
 * ```php
 * echo (new \luya\cms\Tags\PageTag())->parse(1); // where 1 is the Nav ID
 * ```
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class PageTag extends BaseTag
{
    /**
     * @inheritdoc
     */
    public function example()
    {
        return 'page[1](placeholder)';
    }
    
    /**
     * @inheritdoc
     */
    public function readme()
    {
        return 'Get the content of a full page or just a placeholder of the page. The first param is the page it (which you get by hovering over the menu tree in the administration area) `page[1]` if you just want to get the content of a placeholder of the cmslayout used the second parameter `page[1](placeholderName)`.';
    }
    
    /**
     * Get the content of Nav for the current active language with cmslayout or placeholder.
     *
     * @param string $value The value of the Nav ID e.g 1 (hover the cms menu to see the ID).
     * @param string|null $sub If null this parameter will be ignored otherwise its the name of the placeholder inside this cmslayout.
     * @return string The content rendered with the cmslayout, or if $sub is provided and not null with its placeholder name.
     * @see \luya\tag\TagInterface::parse()
     */
    public function parse($value, $sub)
    {
        $page = Nav::findOne($value);
        
        // verify if the page is of type content

        if ($page) {
            if ($page->activeLanguageItem->nav_item_type !== NavItem::TYPE_PAGE) {
                return null;
            }
            
            if (empty($sub)) {
                return $page->activeLanguageItem->getContent();
            } else {
                return $page->activeLanguageItem->type->renderPlaceholder($sub);
            }
        }
        
        return null;
    }
}
