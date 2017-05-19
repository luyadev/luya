<?php

namespace app\blocks;



/**
 * Block created with Luya Block Creator Version 1.0.0-RC1-dev at 08.09.2016 16:30
 */
class ImageTestBlock extends \luya\cms\base\PhpBlock
{
    /**
     * @var bool Choose whether block is a layout/container/segmnet/section block or not, Container elements will be optically displayed
     * in a different way for a better user experience. Container block will not display isDirty colorizing.
     */
    public $isContainer = false;

    /**
     * @var bool Choose whether a block can be cached trough the caching component. Be carefull with caching container blocks.
     */
    public $cacheEnabled = false;

    /**
     * @var int The cache lifetime for this block in seconds (3600 = 1 hour), only affects when cacheEnabled is true
     */
    public $cacheExpiration = 3600;

    public function name()
    {
        return 'ImageTestBlock';
    }

    public function icon()
    {
        return 'extension'; // choose icon from: https://design.google.com/icons/
    }

    public function config()
    {
        return [
           'vars' => [
               ['var' => 'image', 'label' => 'Image', 'type' => 'zaa-image-upload', 'options' => ['no_filter' => false]],
           ],
        ];
    }

    /**
     * Return an array containg all extra vars. The extra vars can be access within the `$extras` array.
     */
    public function extraVars()
    {
        return [
            'image' => $this->zaaImageUpload($this->getVarValue('image'), false, true),
        ];
    }

    /**
     * Available twig variables:
     * @param {{extras.image}}
     * @param {{vars.image}}
     * @return string
     */
    public function admin()
    {
        return '<p>Block Admin</p>';
    }
}
