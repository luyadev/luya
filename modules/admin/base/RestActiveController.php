<?php
namespace admin\base;

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
        return new \admin\components\User();
    }

    public function actions()
    {
        $actions = parent::actions();

        // change index class
        $actions['index']['class'] = '\luya\rest\IndexAction';

        return $actions;
    }

    public function checkAccess($action, $model = null, $params = [])
    {
        /*
        $moduleName = $this->module->id;
        $apiId = $this->id;
        */
    }
}
