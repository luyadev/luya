<?php
namespace luya;

class Module extends \luya\base\Module
{
    /**
     * Url matching prefix, which is used for all the modules (e.g. an e-store requireds a language
     * as the cms needs this informations too. After proccessing this informations, they will be removed
     * from the url for further proccessing.
     *
     * @var string
     */
    public $urlPrefixComposition = '<langId:[a-z]{2}>';

    public $sendException = true;
    
    public $exceptionUrl = 'http://luya.io/errorapi/';
    
    public static $urlRules = [
        ['class' => 'luya\components\UrlRule'],
    ];
}
