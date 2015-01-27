<?php
namespace admin\controllers;

use luya\ngrest\NgRest;
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
        $config = NgRest::findConfig($_POST['ngrestConfigHash']);

        $render = new \admin\ngrest\render\RenderStrap();

        $render->setItemId($_POST['itemId']);
        $render->setStrapHash($_POST['strapHash']);

        $ngrest = new NgRest($config);

        return $ngrest->render($render);
    }

    public function actionCallback()
    {
        $config = NgRest::findConfig($_GET['ngrestConfigHash']);

        $render = new \admin\ngrest\render\RenderStrapCallback();

        $ngrest = new NgRest($config);

        return $ngrest->render($render);
    }
}
