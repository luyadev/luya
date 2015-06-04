<?php

namespace admin\ngrest\render;

use Yii;
use admin\ngrest\RenderAbstract;
use admin\ngrest\RenderInterface;

/**
 * @todo complet rewrite of this class - what is the best practive to acces data in the view? define all functions inside here? re-create methods from config object? $this->config() $this....
 * @todo change get params to yii2 request->get(..., null);
 * @todo sanitize post (\yii\helpers\HtmlPurifier::process(...)
 *
 * @author nadar
 */
class RenderActiveWindowCallback extends RenderAbstract implements RenderInterface
{
    public function render()
    {
        $activeWindows = $this->config->getKey('activeWindow');
        $obj = $activeWindows[$_GET['activeWindowHash']]['object'];

        $function = 'callback'.ucfirst($_GET['activeWindowCallback']);

        $args = Yii::$app->request->post();

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
    }
}
