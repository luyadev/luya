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
 * @property luya\admin\ngrest\base\Model $model The model based from the modelClass instance
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
     * @inheritdoc
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
    
    public function actionIndex($inline = false, $relation = false, $arrayIndex = false, $modelClass = false)
    {
        $apiEndpoint = $this->model->ngRestApiEndpoint();

        $config = $this->model->getNgRestConfig();

        if (!$config) {
            throw new Exception("Provided NgRest config for controller '' is invalid.");
        }
        
        if ($relation && $arrayIndex !== false && $modelClass !== false) {
            $config->relationCall = ['id' => $relation, 'arrayIndex' => $arrayIndex, 'modelClass' => $modelClass];
        }

        $userSortSettings = Yii::$app->adminuser->identity->setting->get('ngrestorder.admin/'.$apiEndpoint, false);
        
        if ($userSortSettings && is_array($userSortSettings)) {
            $config->defaultOrder = [$userSortSettings['field'] => $userSortSettings['sort']];
        }
        
        $config->inline = (int) $inline;
        
        $ngrest = new NgRest($config);
        $crud = new RenderCrud();
        if ($relation) {
            $crud->viewFile = '@admin/views/ngrest/render/crud_relation.php';
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
