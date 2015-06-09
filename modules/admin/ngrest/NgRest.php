<?php

namespace admin\ngrest;

use yii;

/**
 * create from new config.
 *
 * $config = new ngrest\Config();
 * $ngrest = new NgRest($config);
 *
 * find from config
 *
 * $config = new NgRest::findConfig($ngRestConfigHash);
 * $ngrest = new NgRest($config);
 *
 * render from ngrest
 *
 * $ngrest->render(new RenderCrud());
 *
 * @author nadar
 */
class NgRest
{
    private $config = null;

    private $render = null;

    public function __construct(\admin\ngrest\Config $configObject)
    {
        $configObject->onFinish();
        $this->config = $configObject;
    }

    public function render(\admin\ngrest\base\Render $render)
    {
        $this->renderer = $render;
        $this->renderer->setConfig($this->config);

        return $this->renderer->render();
    }

    public static function findConfig($ngRestConfigHash)
    {
        // decode the session, find the hash, if yes return the
        $session = yii::$app->session->get($ngRestConfigHash);
        // valid session usnerialize and return
        if ($session) {
            return unserialize($session);
        }
    }

    public function __destruct()
    {
        yii::$app->session->set($this->config->getNgRestConfigHash(), serialize($this->config));
    }
}
