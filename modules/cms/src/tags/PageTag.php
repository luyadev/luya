<?php

namespace luya\cms\tags;

use luya\tag\BaseTag;
use luya\cms\models\Nav;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

/**
 * Page content tag.
 * 
 * @author Basil Suter <basil@nadar.io>
 */
class PageTag extends BaseTag
{
    public function example()
    {
        return 'page[1](placeholder)';
    }
    
    public function readme()
    {
        return 'Get the content of a full page or just a placeholder of the page. The first param is the page it (which you get by hovering over the menu tree in the administration area) `page[1]` if you just want to get the content of a placeholder of the cmslayout used the second parameter `page[1](placeholderName)`.';
    }
    
    public function parse($value, $sub)
    {
        $page = Nav::findOne($value);
        
        if ($page) {
            if (empty($sub)) {
                return $page->activeLanguageItem->getContent();
            } else {
                return $page->activeLanguageItem->type->renderPlaceholder($sub);
            }
        }
        
        throw new InvalidArgumentException("The provided pageId or placeholder does not exists.");
    }
}
