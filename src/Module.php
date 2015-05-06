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
    public $urlPrefixComposition = '<langShortCode:[a-z]{2}>'; // rename to compositionPattern (@TODO !)

    /**
     * Enable or disable the $composition->getFull() prefix. If disabled the response of getFull() would be empty, otherwhise it
     * returns the full prefix composition pattern based url.
     *
     * @var bool
     */
    public $hideComposition = false;

    public $sendException = true;

    public $exceptionUrl = 'http://luya.io/errorapi/';

    public static $urlRules = [
        ['class' => 'luya\components\UrlRule'],
    ];

    /**
     * The smtp host where phpmailer use as smtp gateway.
     *
     * @var string mail.example.com
     */
    public $mailerHost = null;

    /**
     * The smtp host authentification username.
     *
     * @var string phpmail@example.com
     */
    public $mailerUsername = null;

    /**
     * The smtp host username password for the authentification.
     *
     * @var string
     */
    public $mailerPassword = null;

    /**
     * Should the phpmailer make an smtp authentification or use the local phpmailer() function.
     *
     * @var bool
     */
    public $mailerIsSMTP = false;
}
