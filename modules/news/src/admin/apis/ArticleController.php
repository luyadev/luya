<?php

namespace luya\news\admin\apis;

class ArticleController extends \luya\admin\ngrest\base\Api
{
    public $pagination = ['pageSize' => 10];

    public $modelClass = 'luya\news\models\Article';
}
