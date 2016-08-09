<?php

namespace app\blocks;

use Yii;

/**
 * Block created with Luya Block Creator Version 1.0.0-beta8-dev at 09.08.2016 11:22
 */
class TestZaaFunctionsBlock extends \cmsadmin\base\PhpBlock
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
        return 'TestZaaFunctionsBlock';
    }

    public function icon()
    {
        return 'extension'; // choose icon from: https://design.google.com/icons/
    }

    public function config()
    {
        return [
           'vars' => [
               ['var' => 'zaaImageUpload', 'label' => 'zaaIMageUpload', 'type' => 'zaa-image-upload', 'options' => ['no_filter' => false]],
               ['var' => 'zaaImageArrayUpload', 'label' => 'zaaImageArrayUpload', 'type' => 'zaa-image-array-upload', 'options' => ['no_filter' => false]],
               ['var' => 'zaaFileUpload', 'label' => 'zaaFileUpload', 'type' => 'zaa-file-upload'],
               ['var' => 'zaaFIleArrayUpload', 'label' => 'zaaFileArrayUpload', 'type' => 'zaa-file-array-upload'],
           ],
        ];
    }

    /**
     * Return an array containg all extra vars. The extra vars can be access within the `$extras` array.
     */
    public function extraVars()
    {
        return [
            'zaaImageUpload' => $this->zaaImageUpload($this->getVarValue('zaaImageUpload'), false, true),
            'zaaImageArrayUpload' => $this->zaaImageArrayUpload($this->getVarValue('zaaImageArrayUpload'), false, true),
            'zaaFileUpload' => $this->zaaFileUpload($this->getVarValue('zaaFileUpload'), true),
            'zaaFIleArrayUpload' => $this->zaaFileArrayUpload($this->getVarValue('zaaFIleArrayUpload'), true),
        ];
    }

    /**
     * Available twig variables:
     * @param {{extras.zaaImageUpload}}
     * @param {{vars.zaaImageUpload}}
     * @param {{extras.zaaImageArrayUpload}}
     * @param {{vars.zaaImageArrayUpload}}
     * @param {{extras.zaaFileUpload}}
     * @param {{vars.zaaFileUpload}}
     * @param {{extras.zaaFIleArrayUpload}}
     * @param {{vars.zaaFIleArrayUpload}}
     */
    public function admin()
    {
        return '<p>Block Admin</p>';
    }
}
