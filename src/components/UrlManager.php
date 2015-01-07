<?php
namespace luya\components;

/**
 * if its not necesary to directly access the modules via /{module} we could
 * implement this solution:
 * http://www.yiiframework.com/doc-2.0/guide-runtime-routing.html#adding-rules-dynamically
 *
 * @author nadar
 *
 */
class UrlManager extends \yii\web\UrlManager
{
    public $enablePrettyUrl = true;

    public $showScriptName = false;
}
