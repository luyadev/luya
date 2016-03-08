<?php

namespace cms\controllers;

use Yii;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use cmsadmin\models\NavItem;

class PreviewController extends \cms\base\Controller
{
    public function actionIndex($itemId)
    {
        if (Yii::$app->adminuser->isGuest) {
            throw new ForbiddenHttpException('Unable to see the preview page, session expired or not logged in.');
        }

        $langShortCode = NavItem::findOne($itemId)->lang->short_code;

        Yii::$app->composition['langShortCode'] = $langShortCode;

        $item = Yii::$app->menu->find()->where(['id' => $itemId])->with('hidden')->lang($langShortCode)->one();

        if (!$item) {
            throw new NotFoundHttpException("Unable to find item id $itemId");
        }

        return $this->render('index', [
            'pageContent' => $this->renderItem($itemId),
        ]);
    }
}
