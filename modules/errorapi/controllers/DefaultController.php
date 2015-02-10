<?php
namespace errorapi\controllers;

class DefaultController extends \luya\base\Controller
{
    /**
     * @todo change from get param to post param?
     * @param unknown $errorJson
     * @return string
     */
    public function actionCreate($errorJson)
    {
        $model = new \errorapi\models\Data();
        $model->error_json = $errorJson;
        if ($model->save()) {
            return 'SAVE!';
        } else {
            var_dump($model->getErrors());
        }
    }
    
    public function actionResolve()
    {
        return 'verify the identifier and see if sth changes in case of resolving this issue.';
    }
}