<?php

namespace styleguide\controllers;

use Yii;

/**
 * @see http://stackoverflow.com/questions/19198804/deducing-php-closure-parameters
 * 
 * $closure    = &$func;
 * $reflection = new ReflectionFunction($closure);
 * $arguments  = $reflection->getParameters();
 */
class DefaultController extends \luya\base\Controller
{
    public $layout = 'main.php';
    
    public function actionIndex()
    {
        $this->view->title = 'Styleguide';
        
        $elements = Yii::$app->element->getNames();
        
        return $this->render('index', [
            'elementNames' => $elements
        ]);
    }
}