<?php
namespace admin\base;

/**
 * Does allow the implementation of a yii2 rest controller based on the verbs inside the 
 * url rules defintions. The allowed methods must base on the yii2 rest controller norm like.
 * Allowed actions:
 * - actionIndex();
 * - actionView($id);
 * - actionUpdate($id);
 * - actionCreate();
 * - actionDelete($id);
 */
class RestVerbController extends \yii\rest\Controller implements \admin\base\RestInterface
{
    use \admin\base\RestBehaviorTrait;
    
    public function userAuthClass()
    {
        return new \admin\components\User();
    }
}
