<?php

namespace cms\controllers;

use Yii;

class DefaultController extends \luya\base\Controller
{
    public $useModuleViewPath = true;
    
    public function actionIndex()
    {
        $langShortCode = Yii::$app->get('collection')->lang->shortCode;

        $links = new \cms\collection\Links();
        $links->activeLink = $_GET['path'];
        //$links->setLangId(yii::$app->collection->lang->shortCode);
        $links->start();

        Yii::$app->get('collection')->links = $links;

        $page = new \cms\collection\Page();

        Yii::$app->get('collection')->page = $page;
        return $this->render("index", [
            'page' => $page
        ]);
    }
}
