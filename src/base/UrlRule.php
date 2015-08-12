<?php

namespace luya\base;

/**
 * Can't set the UrlRule as abstract cause its used as base class for all UrlRules, this
 * is a behavior of the UrlManger where is set like this:
 * 
 * ```
 * public $ruleConfig = ['class' => '\luya\base\UrlRule'];
 * ```
 * 
 * @author nadar
 */
class UrlRule extends \yii\web\UrlRule
{
    public $composition = [];
}
