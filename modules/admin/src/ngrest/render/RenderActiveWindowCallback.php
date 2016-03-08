<?php

namespace admin\ngrest\render;

use Yii;
use luya\helpers\ObjectHelper;
use yii\helpers\Inflector;

/**
 * @todo sanitize post (\yii\helpers\HtmlPurifier::process(...)
 * @author nadar
 */
class RenderActiveWindowCallback extends \admin\ngrest\base\Render implements \admin\ngrest\interfaces\Render
{
    public function render()
    {
        $activeWindowHash = Yii::$app->request->get('activeWindowHash');
        $activeWindowCallback = Yii::$app->request->get('activeWindowCallback');

        $activeWindows = $this->config->getPointer('aw');
        $obj = $activeWindows[$activeWindowHash]['object'];

        $function = 'callback'.Inflector::id2camel($activeWindowCallback);

        return ObjectHelper::callMethodSanitizeArguments($obj, $function, Yii::$app->request->post());
        /*
        $reflection = new \ReflectionMethod($obj, $function);

        $methodArgs = [];

        if ($reflection->getNumberOfRequiredParameters() > 0) {
            foreach ($reflection->getParameters() as $param) {
                if (!array_key_exists($param->name, $args)) {
                    throw new \Exception("the provided argument '".$param->name."' does not exists in the provided arguments list.");
                }
                $methodArgs[] = $args[$param->name];
            }
        }

        $response = call_user_func_array(array($obj, $function), $methodArgs);

        return $response;
        */
    }
}
