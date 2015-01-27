<?php
namespace admin\ngrest\render;

use admin\ngrest\RenderAbstract;
use admin\ngrest\RenderInterface;

/**
 * @todo complet rewrite of this class - what is the best practive to acces data in the view? define all functiosn sindie here? re-create methods from config object?
 *  $this->config() $this....
 *
 * @author nadar
 */
class RenderStrapCallback extends RenderAbstract implements RenderInterface
{
    public function render()
    {
        $straps = $this->config->getKey('strap');
        $obj = $straps[$_GET['strapHash']]['object'];

        $function = "callback".ucfirst($_GET['strapCallback']);

        $args = $_POST; // SANITIZE THIS INPUT ? yii?

        $reflection = new \ReflectionMethod($obj, $function);

        $methodArgs = [];
        foreach ($reflection->getParameters() as $param) {
            if (!array_key_exists($param->name, $args)) {
                throw new \Exception("the provided argument does not exists in the method args list");
            }

            $methodArgs[] = $args[$param->name];
        }

        $response = call_user_func_array(array($obj, $function), $methodArgs);

        return $response;
    }
}
