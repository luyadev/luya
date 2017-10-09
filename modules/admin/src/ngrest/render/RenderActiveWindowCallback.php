<?php

namespace luya\admin\ngrest\render;

use Yii;
use yii\helpers\Inflector;
use luya\Exception;
use luya\helpers\ObjectHelper;
use luya\admin\ngrest\base\Render;

/**
 * Render an Active Window Callback call.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class RenderActiveWindowCallback extends Render implements RenderInterface
{
    public function render()
    {
        $activeWindowHash = Yii::$app->request->get('activeWindowHash');
        $activeWindowCallback = Yii::$app->request->get('activeWindowCallback');

        $activeWindows = $this->config->getPointer('aw');
        
        if (!isset($activeWindows[$activeWindowHash])) {
            throw new Exception("Unable to find ActiveWindow " . $activeWindowHash);
        }
        
        $obj = Yii::createObject($activeWindows[$activeWindowHash]['objectConfig']);
        $obj->setItemId(Yii::$app->session->get($activeWindowHash));
        $obj->setConfigHash($this->config->getHash());
        $obj->setActiveWindowHash($activeWindowHash);

        $function = 'callback'.Inflector::id2camel($activeWindowCallback);

        return ObjectHelper::callMethodSanitizeArguments($obj, $function, Yii::$app->request->post());
    }
}
