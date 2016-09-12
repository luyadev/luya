<?php

namespace luya\admin\ngrest\base;

use Yii;
use Exception;
use yii\base\InvalidConfigException;
use luya\admin\ngrest\NgRest;
use luya\admin\ngrest\render\RenderCrud;

/**
 * Base Controller for all NgRest Controllers.
 *
 * @property admin\ngrest\base\Model $model The model based from the modelClass instance
 *
 * @author Basil Suter <basil@nadar.io>
 */
class Controller extends \luya\admin\base\Controller
{
    /**
     * @var string Defines the related model for the NgRest Controller. The full qualiefied model name
     * is required.
     *
     * ```php
     * public $modelClass = 'admin\models\User';
     * ```
     */
    public $modelClass = null;

    /**
     * @var boolean Disables the permission
     */
    public $disablePermissionCheck = true;

    /**
     * {@inheritDoc}
     * @see \luya\web\Controller::init()
     */
    public function init()
    {
        parent::init();
        
        if ($this->modelClass === null) {
            throw new InvalidConfigException("The property `modelClass` must be defined by the Controller.");
        }
    }
    
    private $_model = null;

    public function getModel()
    {
        if ($this->_model === null) {
            $this->_model = Yii::createObject($this->modelClass);
        }

        return $this->_model;
    }

    public function actionIndex($inline = false)
    {
        $apiEndpoint = $this->model->ngRestApiEndpoint();

        $configClass = $this->module->getLinkedNgRestConfig($apiEndpoint);

        if ($configClass) {
            // todo
            // $class = Yii::createObject($configClass, ['apiEndpoint' => '', 'primaryKey' => '..'
            // build config based on the defined config class
            $config = false;
        } else {
            $config = $this->model->getNgRestConfig();
        }

        if (!$config) {
            throw new Exception("Provided NgRest config for controller '' is invalid.");
        }
        
        
        $config->inline = (bool) $inline;
        $config->filters = $this->model->ngRestFilters();
        $config->defaultOrder = $this->model->ngRestListOrder();
        $config->attributeGroups = $this->model->ngRestAttributeGroups();
        $config->groupByField = $this->model->ngRestGroupByField();
        
        $ngrest = new NgRest($config);

        return $ngrest->render(new RenderCrud());
    }
}
