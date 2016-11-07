<?php

namespace luya\web;

/**
 * Base urlRule class used as ruleConfig in UrlManager Componenet.
 *
 * Can't set the UrlRule as abstract cause its used as base class for all UrlRules, this
 * is a behavior of the UrlManger where is set like this:.
 *
 * ```php
 * public $ruleConfig = ['class' => '\luya\web\UrlRule'];
 * ```
 *
 * @author Basil Suter <basil@nadar.io>
 */
class UrlRule extends \yii\web\UrlRule
{
    const POSITION_BEFORE_LUYA = 0;
    
    const POSITION_LUYA = 1;
    
    const POSITION_AFTER_LUYA = 2;
    
    /**
     * @var array Composition rules are multi lingual rule definitions match against different
     * languages from composition component. This variable will be assigned from the modules urlRule
     * variable and while foreaching the urlRules the composition values for each rule will be stored
     * in this variable to retrieve the informations later on.
     */
    public $composition = [];
    
    /**
     * @var int Position before the luya urlRule which loads the default or after.
     */
    public $position = self::POSITION_AFTER_LUYA;
}
