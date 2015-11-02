<?php

namespace cms;

/**
 * Cms Module.
 * 
 * @author nadar
 */
class Module extends \luya\base\Module
{
    /**
     * @var array We have no urlRules in cms Module. the UrlRoute file will only be used when
     *            no module is provided. So the CMS url rewrites does only apply on default behavior.
     */
    public $urlRules = [];

    /**
     * @var bool If enabled the cms content will be compressed (removing of whitespaces and tabs).
     */
    public $enableCompression = true;

    /**
     * @var bool If enableTagParsing is enabled tags like `link(1)` or `link(1)[Foo Bar]` will be parsed
     *           and transformed into links based on the cms.
     */
    public $enableTagParsing = true;

    /**
     * @var bool CMS is a luya core module.
     */
    public $isCoreModule = true;

    public function registerComponents()
    {
        return [
            'links' => [
                'class' => 'cms\components\Links',
            ],
            'menu' => [
                'class' => 'cms\components\Menu',
            ],
        ];
    }
}
