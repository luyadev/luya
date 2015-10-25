<?php

namespace admin\controllers;

use Yii;
use admin\ngrest\NgRest;
use yii\web\Response;

class NgrestController extends \admin\base\Controller
{
    public function behaviors()
    {
        return [
            [
            'class' => 'yii\filters\ContentNegotiator',
            'only' => ['callback'],
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
                'languages' => [
                    'en',
                    'de',
                ],
            ],
        ];
    }

    public function actionRender()
    {
        $config = NgRest::findConfig(Yii::$app->request->post('ngrestConfigHash', false));

        $render = new \admin\ngrest\render\RenderActiveWindow();

        $render->setItemId(Yii::$app->request->post('itemId', false));
        $render->setActiveWindowHash(Yii::$app->request->post('activeWindowHash', false));

        $ngrest = new NgRest($config);

        return $ngrest->render($render);
    }

    public function actionCallback()
    {
        $config = NgRest::findConfig($_GET['ngrestConfigHash']);

        $render = new \admin\ngrest\render\RenderActiveWindowCallback();

        $ngrest = new NgRest($config);

        return $ngrest->render($render);
    }
}
