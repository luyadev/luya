<?php

namespace cms\controllers;

use Yii;
use yii\helpers\Inflector;
use yii\base\Exception;
use luya\helpers\ObjectHelper;
use cmsadmin\models\Block;
use cmsadmin\models\NavItemPageBlockItem;

class BlockController extends \cms\base\Controller
{
    public $enableCsrfValidation = false;
    
    public function actionIndex($callback, $id)
    {
        $model = NavItemPageBlockItem::findOne($id);
        
        if (!$model) {
            throw new Exception("Unabled to find item id.");    
        }
        
        $block = Block::objectId($model->block_id, $model->id, 'callback');

        $method = 'callback'.Inflector::id2camel($callback);

        return ObjectHelper::callMethodSanitizeArguments($block, $method, Yii::$app->request->get());
    }
}
