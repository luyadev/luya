<?php

namespace errorapi\controllers;

class DefaultController extends \luya\rest\Controller
{
    public function userAuthClass()
    {
        return false;
    }

    /**
     * @param $_POST['error_json']
     *
     * @return string
     */
    public function actionCreate()
    {
        $model = new \errorapi\models\Data();
        $model->error_json = \yii::$app->request->post('error_json', null);
        if ($model->save()) {
            /*
            \yii::$app->mail->compose('Subject', print_r(json_decode($model->error_json, true), true))->address('to@example.com')->send();
            */
            return true;
        } else {
            return $model->getErrors();
        }
    }

    /**
     * @todo see if the error request have changed based on a bug system.
     */
    public function actionResolve()
    {
    }
}
