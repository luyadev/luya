<?php
namespace errorapi\controllers;

class DefaultController extends \luya\rest\Controller
{
    public function userAuthClass()
    {
        return false;
    }
    
    /**
     * @todo change from get param to post param?
     * 
     * @param string $jsonData
     * @return string
     */
    public function actionCreate($jsonData)
    {
        $model = new \errorapi\models\Data();
        $model->error_json = $jsonData;
        if ($model->save()) {
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