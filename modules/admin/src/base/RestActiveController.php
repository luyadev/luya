<?php

namespace admin\base;

use Yii;
use Exception;
use admin\components\Auth;
use admin\ngrest\base\Model;
use admin\models\UserOnline;

/**
 * Wrapper for yii2 basic rest controller used with a model class. The wrapper is made to
 * change behaviours and overwrite the indexAction.
 *
 * usage like described in the yii2 guide.
 * 
 * @property \admin\ngrest\NgRestModeInterface $model Get the model object based on the $modelClass property.
 * 
 * @author Basil Suter <basil@nadar.io>
 */
class RestActiveController extends \yii\rest\ActiveController implements \luya\rest\BehaviorInterface
{
    use \luya\rest\BehaviorTrait;

    public $createScenario = Model::SCENARIO_RESTCREATE;

    public $updateScenario = Model::SCENARIO_RESTUPDATE;

    private $_model = null;
    
    public function getModel()
    {
        if ($this->_model === null) {
            $this->_model = Yii::createObject($this->modelClass);
        }
        
        return $this->_model;
    }
    
    public function userAuthClass()
    {
        return Yii::$app->adminuser;
    }

    public function actions()
    {
        $actions = parent::actions();

        // change index class
        $actions['index']['class'] = '\admin\rest\IndexAction';
        $actions['delete']['class'] = '\admin\rest\DeleteAction';

        return $actions;
    }

    public function checkAccess($action, $model = null, $params = [])
    {
        switch ($action) {
            case 'index':
            case 'view':
                $type = false;
                break;
            case 'create':
                $type = Auth::CAN_CREATE;
                break;
            case 'update':
                $type = Auth::CAN_UPDATE;
                break;
            case 'delete':
                $type = Auth::CAN_DELETE;
                break;
            default:
                throw new Exception("Unable to access the REST api, invalid $action");
                break;
        }

        UserOnline::refreshUser($this->userAuthClass()->getIdentity()->id, $this->id);
        
        if (!Yii::$app->auth->matchApi($this->userAuthClass()->getIdentity()->id, $this->id, $type)) {
            throw new \yii\web\ForbiddenHttpException('you are unable to access this controller due to access restrictions.');
        }
    }
}
