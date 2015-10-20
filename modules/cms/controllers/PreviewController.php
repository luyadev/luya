<?php

namespace cms\controllers;

use Yii;

class PreviewController extends \cms\base\Controller
{
    public function actionIndex($itemId)
    {
        if (Yii::$app->adminuser->isGuest) {
            throw new \yii\web\ForbiddenHttpException('Unable to view the preview page, session expired or not logged in.');
        }

        $link = Yii::$app->links->findOneByArguments(['id' => $itemId]);

        Yii::$app->links->activeUrl = $link['url'];

        Yii::$app->composition->setkey('langShortCode', $link['lang']);

        return $this->render('index', [
            'pageContent' => $this->renderItem($itemId),
        ]);
    }
}
