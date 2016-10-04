<?php

namespace ngresttest\controllers;

use luya\admin\ngrest\base\Controller;

/**
 * NgRest API created at 21.03.2016 14:05 on LUYA Version 1.0.0-beta6-dev.
 */
class TableController extends Controller
{
    /**
     * @var string $modelClass The path to the model which is the provider for the rules and fields.
     */
    public $modelClass = '\ngresttest\models\Table';
}
