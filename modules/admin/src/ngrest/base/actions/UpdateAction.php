<?php

namespace luya\admin\ngrest\base\actions;

use Yii;
use luya\admin\models\UserOnline;

/**
 * UpdateAction for REST implementation.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class UpdateAction extends \yii\rest\UpdateAction
{
    public function run($id)
    {
        $response = parent::run($id);
        
        UserOnline::unlock(Yii::$app->adminuser->id);
        
        return $response;
    }
}
