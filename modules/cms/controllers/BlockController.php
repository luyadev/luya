<?php

namespace cms\controllers;

use Yii;
use yii\helpers\Inflector;
use luya\helpers\ObjectHelper;
use cmsadmin\models\Block;
use cmsadmin\models\NavItemPageBlockItem;

class BlockController extends \cms\base\Controller
{
    public function actionIndex($callback, $id)
    {
        $model = NavItemPageBlockItem::findOne($id);
        $block = Block::objectId($model->block_id, $model->id, 'callback');

        $method = 'callback'.Inflector::id2camel($callback);

        return ObjectHelper::callMethodSanitizeArguments($block, $method, Yii::$app->request->get());
    }
}
