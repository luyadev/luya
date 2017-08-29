<?php

namespace luya\news\admin\controllers;

class ArticleController extends \luya\admin\ngrest\base\Controller
{
    public $modelClass = '\luya\news\models\Article';

    public $globalButtons = [
    		['label' => 'ffooo', 'ng-click' => 'alert(0)']
    ];
}
