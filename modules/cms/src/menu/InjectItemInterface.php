<?php

namespace luya\cms\menu;

/**
 * An Injector Item Interface.
 *
 * When you like to inject items into the menu while running the application each object must
 * implement this InjectItemInterface.
 *
 * In order to see an example of how to use the injection of items read the [[app-menu.md]] Guide in the injectors section.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
interface InjectItemInterface
{
    /**
     * Getter method for the language on which the item is injected. The language is the short code
     * based from the composition component.
     *
     * @return string A language short code string (like de, en)
     */
    public function getLang();
    
    /**
     * Getter method for the unqiue id of a language item which can be auto generated or directly from
     * the injection item. Ensure the unique identifier when setting this property.
     *
     * @return integer|string The unique identifier can be either a string or a number, or a concat of both.
     */
    public function getId();
    
    /**
     * This method provides all setter variables for the item.
     *
     * @return array An array where the key is the name of the setter property like `title`, `alias` etc.
     */
    public function toArray();
}
