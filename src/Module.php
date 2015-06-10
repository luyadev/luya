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
    public $urlPrefixComposition = '<langShortCode:[a-z]{2}>'; // rename to patternComposition (@TODO !)

    /**
     * Enable or disable the $composition->getFull() prefix. If disabled the response of getFull() would be empty, otherwhise it
     * returns the full prefix composition pattern based url.
     *
     * @var bool
     */
    public $hideComposition = false;
    
    /**
     * Default value if there is no composition provided in the url. The default value must match the $urlPrefixComposition url.
     * 
     * @var array
     */
    public $defaultComposition = ['langShortCode' => 'de'];
    
    /**
     * Default url behavior if luya is included. first rule which will be picked.
     * 
     * @var array
     */
    public static $urlRules = [
        ['class' => 'luya\components\UrlRule'],
    ];
}
