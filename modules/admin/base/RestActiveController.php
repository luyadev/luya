<?php

namespace admin\base;

use Yii;
use Exception;
use admin\components\Auth;

/**
 * Wrapper for yii2 basic rest controller used with a model class. The wrapper is made to
 * change behaviours and overwrite the indexAction.
 *
 * usage like described in the yii2 guide.
 */
class RestActiveController extends \yii\rest\ActiveController implements \luya\rest\BehaviorInterface
{
    use \luya\rest\BehaviorTrait;

    public $createScenario = 'restcreate';

    public $updateScenario = 'restupdate';

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

        if (!Yii::$app->auth->matchApi($this->userAuthClass()->getIdentity()->id, $this->id, $type)) {
            throw new \yii\web\ForbiddenHttpException('you are unable to access this controller due to access restrictions.');
        }
    }
}
