<?php

namespace luya\cms\admin\controllers;

use luya\admin\base\Controller;

/**
 * Provie Page Templates for create update and drafts.
 * 
 * @author Basil Suter <basil@nadar.io>
 */
class PageController extends Controller
{
    public function actionCreate()
    {
        return $this->render('create');
    }

    public function actionUpdate()
    {
        return $this->render('update');
    }
    
    public function actionDrafts()
    {
        return $this->render('drafts');
    }
}
