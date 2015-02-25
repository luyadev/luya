<?php
namespace luya;

class Module extends \luya\base\Module
{
    /**
     * Url matching prefix, which is used for all the modules (e.g. an e-store requireds a language
     * as the cms needs this informations too). After proccessing this informations, they will be removed
     * from the url for further proccessing.
     * 
     * The fullqualified composer key will be stored in $request->get('urlPrefixCompositionKey').
     *
     * Examples of how to use urlPrefixComposition
     * ```
     * $urlPrefixComposition = '<langShortCode:[a-z]{2}>/<countryShortCode:[a-z]{2}>'; // de/ch; fr/ch
     * $urlPrefixComposition = '<countryShortCode:[a-z]{2}>-<langShortCode:[a-z]{2}>'; // ch-de; ch-fr
     * ```
     * 
     * @var string
     */
    public $urlPrefixComposition = '<langShortCode:[a-z]{2}>';

    public $sendException = false;
    
    public $exceptionUrl = 'http://luya.io/errorapi/';
    
    public static $urlRules = [
        ['class' => 'luya\components\UrlRule'],
    ];
}
