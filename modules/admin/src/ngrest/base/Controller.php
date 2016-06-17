<?php

namespace admin\ngrest\base;

use Yii;
use Exception;

/**
 * Base Controller for all NgRest Controllers.
 * 
 * @author Basil Suter <basil@nadar.io>
 */
class Controller extends \admin\base\Controller
{
    public $modelClass = null;

    public $disablePermissionCheck = true;

    private $_model = null;

    public function getModelClass()
    {
        return $this->modelClass;
    }

    public function getModelObject()
    {
        if ($this->_model === null) {
            $this->_model = Yii::createObject($this->getModelClass());
        }

        return $this->_model;
    }

    public function getNgRestConfig()
    {
        return $this->getModelObject()->getNgRestConfig();
    }

    public function actionIndex($inline = false)
    {
        $apiEndpoint = $this->getModelObject()->ngRestApiEndpoint();

        $configClass = $this->module->getLinkedNgRestConfig($apiEndpoint);

        if ($configClass) {
            // todo
            // $class = Yii::createObject($configClass, ['apiEndpoint' => '', 'primaryKey' => '..'
            // build config based on the defined config class
            $config = false;
        } else {
            $config = $this->getNgRestConfig();
        }

        if (!$config) {
            throw new Exception("Provided NgRest config for controller '' is invalid.");
        }
        
        
        $config->inline = (bool) $inline;
        
        $ngrest = new \admin\ngrest\NgRest($config);

        return $ngrest->render(new \admin\ngrest\render\RenderCrud());
    }
}
