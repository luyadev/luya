<?php

namespace ngresttest\controllers;

/**
 * Order Controller.
 *
 * File has been created with `crud/create` command on LUYA version 1.0.0-dev.
 */
class OrderController extends \luya\admin\ngrest\base\Controller
{
    /**
     * @var string The path to the model which is the provider for the rules and fields.
     */
    public $modelClass = 'ngresttest\models\Order';
}
