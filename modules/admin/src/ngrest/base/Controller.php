<?php

namespace luya\admin\ngrest\base;

use Yii;
use Exception;
use yii\base\InvalidConfigException;
use luya\admin\ngrest\NgRest;
use luya\admin\ngrest\render\RenderCrud;
use luya\helpers\FileHelper;
use yii\web\ForbiddenHttpException;

/**
 * Base Controller for all NgRest Controllers.
 *
 * @property luya\admin\ngrest\base\NgRestModel $model The model based from the modelClass instance
 *
 * @author Basil Suter <basil@nadar.io>
 */
class Controller extends \luya\admin\base\Controller
{
    /**
     * @inheritdoc
     */
    public $layout = false;
    
    /**
     * @var string Defines the related model for the NgRest Controller. The full qualified model name is required.
     *
     * ```php
     * public $modelClass = 'admin\models\User';
     * ```
     */
    public $modelClass;

    /**
     * @var boolean Disables the permission
     */
    public $disablePermissionCheck = true;

    /**
     * @var array Define global ngrest controller buttons you can choose in the drop down menu of an ngrest page.
     *
     * ```php
     * 'globalButtons' => [
     *     'icon' => 'extension', 'label' => 'My Button', 'ng-click' => 'callMyFunction()'
     * ];
     * ```
     */
    public $globalButtons = [];
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        
        if ($this->modelClass === null) {
            throw new InvalidConfigException("The property `modelClass` must be defined by the Controller.");
        }
    }
    
    private $_model;

    /**
     * Get Model Object
     * @return \luya\admin\ngrest\base\NgRestModel
     */
    public function getModel()
    {
        if ($this->_model === null) {
            $this->_model = Yii::createObject($this->modelClass);
        }

        return $this->_model;
    }
    
    /**
     *
     * @param string $inline
     * @param string $relation
     * @param string $arrayIndex
     * @param string $modelClass
     * @param string $modelSelection
     * @throws Exception
     * @return string
     */
    public function actionIndex($inline = false, $relation = false, $arrayIndex = false, $modelClass = false, $modelSelection = false)
    {
        $apiEndpoint = $this->model->ngRestApiEndpoint();

        $config = $this->model->getNgRestConfig();

        if (!$config) {
            throw new Exception("Provided NgRest config for controller '' is invalid.");
        }

        $userSortSettings = Yii::$app->adminuser->identity->setting->get('ngrestorder.admin/'.$apiEndpoint, false);
        
        if ($userSortSettings && is_array($userSortSettings) && $config->getDefaultOrder() !== false) {
            $config->defaultOrder = [$userSortSettings['field'] => $userSortSettings['sort']];
        }
        
        $ngrest = new NgRest($config);
        $crud = new RenderCrud();
        $crud->setGlobalButtons($this->globalButtons);
        $crud->setIsInline($inline);
        $crud->setModelSelection($modelSelection);
        if ($relation && $arrayIndex !== false && $modelClass !== false) {
            $crud->setRelationCall(['id' => $relation, 'arrayIndex' => $arrayIndex, 'modelClass' => $modelClass]);
        }
        if ($relation) {
            //$crud->viewFile = 'crud_relation.php';
        }
        return $ngrest->render($crud);
    }
    
    public function actionExportDownload($key)
    {
        $sessionkey = Yii::$app->session->get('tempNgRestFileKey');
        $fileName = Yii::$app->session->get('tempNgRestFileName');
        $mimeType = Yii::$app->session->get('tempNgRestFileMime');
        
        if ($sessionkey !== base64_decode($key)) {
            throw new ForbiddenHttpException('Invalid download key.');
        }
    
        $content = FileHelper::getFileContent('@runtime/'.$sessionkey.'.tmp');
    
        Yii::$app->session->remove('tempNgRestFileKey');
        Yii::$app->session->remove('tempNgRestFileName');
        Yii::$app->session->remove('tempNgRestFileMime');
        @unlink(Yii::getAlias('@runtime/'.$sessionkey.'.tmp'));
    
        return Yii::$app->response->sendContentAsFile($content, $fileName, ['mimeType' => $mimeType]);
    }
}
