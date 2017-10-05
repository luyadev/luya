<?php

namespace luya\news\admin\apis;

class ArticleController extends \luya\admin\ngrest\base\Api
{
    public $modelClass = 'luya\news\models\Article';

    public $pageSize = 10;
}
