<?php

namespace app\blocks;

use Yii;
use cms\injectors\ActiveQueryCheckbox;
use newsadmin\models\Article;

/**
 * Block created with Luya Block Creator Version 1.0.0-rc1-dev at 15.08.2016 14:33
 */
class DateTestBlock extends \cmsadmin\base\PhpBlock
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

    public function injectors()
    {
        return [
            'foobar' => new ActiveQueryCheckbox(['query' => Article::find()]),
        ];
    }
    
    public function name()
    {
        return 'DateTestBlock';
    }

    public function icon()
    {
        return 'extension'; // choose icon from: https://design.google.com/icons/
    }

    public function config()
    {
        return [
           'vars' => [
               //['var' => 'date', 'label' => 'date', 'type' => 'zaa-date'],
               ['var' => 'datetime', 'label' => 'datetime', 'type' => 'zaa-datetime'],
           ],
            'cfgs' => [
                ['var' => 'asdfasdf', 'label' => 'Grösse', 'type' => 'zaa-checkbox', 'initvalue' => 1],
            ],
        ];
    }

    /**
     * Return an array containg all extra vars. The extra vars can be access within the `$extras` array.
     */
    public function extraVars()
    {
        return [
        ];
    }

    /**
     * Available twig variables:
     * @param {{vars.date}}
     * @param {{vars.datetime}}
     */
    public function admin()
    {
        return '<p>Block Admin</p>';
    }
}
