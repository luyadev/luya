<?php

namespace luya\styleguide\controllers;

use Yii;

/**
 * @see http://stackoverflow.com/questions/19198804/deducing-php-closure-parameters
 *
 * $closure    = &$func;
 * $reflection = new ReflectionFunction($closure);
 * $arguments  = $reflection->getParameters();
 */
class DefaultController extends \luya\web\Controller
{
    public $layout = 'main.php';

    public function actionIndex()
    {
        if (!$this->hasAccess()) {
            return $this->redirect(['login']);
        }
        $containers = [];

        foreach (Yii::$app->element->getElements() as $name => $closure) {
            $reflection = new \ReflectionFunction($closure);
            $args = $reflection->getParameters();
            $params = [];
            foreach ($args as $k => $v) {
                $params[] = '$'.$v->name;
            }

            $containers[] = [
                'name' => $name,
                'args' => $params,
                'html' => Yii::$app->element->run($name, $params),
            ];
        }

        return $this->render('index', [
            'containers' => $containers,
        ]);
    }

    public function actionLogin()
    {
        $password = Yii::$app->request->post('pass', false);
        $e = false;
        if ($password === $this->module->password) {
            Yii::$app->session->set('__styleguide_pass', $password);
            if ($this->hasAccess()) {
                $this->redirect(['index']);
            }
        } elseif ($password !== false) {
            $e = true;
        }

        return $this->render('login', ['e' => $e]);
    }

    private function hasAccess()
    {
        return $this->module->password == Yii::$app->session->get('__styleguide_pass', false);
    }
}
