<?php

namespace luya\cms\admin\controllers;

class PageController extends \admin\base\Controller
{
    public function actionCreate()
    {
        return $this->renderPartial('create');
    }

    public function actionUpdate()
    {
        return $this->renderPartial('update');
    }
    
    public function actionDrafts()
    {
        return $this->renderPartial('drafts');
    }
}
