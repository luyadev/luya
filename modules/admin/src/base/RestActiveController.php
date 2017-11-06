<?php

namespace luya\admin\base;

use Yii;
use luya\admin\components\Auth;
use luya\admin\models\UserOnline;
use luya\rest\UserBehaviorInterface;
use luya\traits\RestBehaviorsTrait;
use yii\web\ForbiddenHttpException;
use luya\rest\ActiveController;

/**
 * Base class for Rest Active Controllers.
 *
 * Wrapper for yii2 basic rest controller used with a model class. The wrapper is made to
 * change behaviours and overwrite the indexAction.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class RestActiveController extends ActiveController implements UserBehaviorInterface
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
    
        $this->enableCors = Yii::$app->auth->cors;
    }
    
    /**
     * @inheritdoc
     */
    public function userAuthClass()
    {
        return Yii::$app->adminuser;
    }

    /**
     * @inheritdoc
     */
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
                throw new ForbiddenHttpException("Invalid RESPI Api action call.");
                break;
        }

        UserOnline::refreshUser($this->userAuthClass()->getIdentity()->id, $this->id);
        
        if (!Yii::$app->auth->matchApi($this->userAuthClass()->getIdentity()->id, $this->id, $type)) {
            throw new ForbiddenHttpException('you are unable to access this controller due to access restrictions.');
        }
    }
}
