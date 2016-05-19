<?php

namespace app\blocks;

use Yii;

/**
 * Block created with Luya Block Creator Version 1.0.0-beta7-dev at 19.05.2016 13:28
 */
class SortRelationArrayBlock extends \cmsadmin\base\Block
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
        return 'SortRelationArrayBlock';
    }

    public function icon()
    {
        return 'extension'; // choose icon from: http://materializecss.com/icons.html
    }

    public function config()
    {
        return [
           'vars' => [
               ['var' => 'sortrel', 'label' => 'sortrel', 'type' => 'zaa-sort-relation-array', 'options' => ['sourceData' => [
                   ['value' => 1, 'label' => 'Option #1'],
                   ['value' => 2, 'label' => 'Option #2'],
                   ['value' => 3, 'label' => 'Option #3'],
                   ['value' => 4, 'label' => 'Option #4'],
               ]]],
           ],
        ];
    }

    /**
     * Return an array containg all extra vars. Those variables you can access in the Twig Templates via {{extras.*}}.
     */
    public function extraVars()
    {
        return [
        ];
    }

    /**
     * Available twig variables:
     * @param {{vars.sortrel}}
     */
    public function twigFrontend()
    {
        return '<p>My Frontend Twig of this Block</p>';
    }

    /**
     * Available twig variables:
     * @param {{vars.sortrel}}
     */
    public function twigAdmin()
    {
        return '<p>My Admin Twig of this Block</p>';
    }
}
