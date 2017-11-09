<?php

namespace luya\styleguide\controllers;

use Yii;
use yii\helpers\Html;

/**
 * Display the Styleguide Elements.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
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
            $writtenParams = [];
            foreach ($args as $k => $v) {
                $writtenParams[] = '$'.$v->name;
                $mock = Yii::$app->element->getMockedArgValue($name, $v->name);
                if ($mock !== false) {
                    $params[] = $mock;
                } else {
                    if ($v->isArray()) {
                        $params[] = ['$'.$v->name];
                    } else {
                        $params[] = '$'.$v->name;
                    }
                }
            }
            
            $containers[] = [
                'name' => $name,
                'tag' => Html::tag('div', Yii::$app->element->getElement($name, $params), $this->module->divOptions),
                'args' => $writtenParams,
            ];
        }
        
        foreach ($this->module->assetFiles as $class) {
            $this->registerAsset($class);
        }

        return $this->render('index', [
            'containers' => $containers,
            'global' => Html::tag('div', $this->renderPartial('_global'), $this->module->divOptions),
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

        return $this->render('login', [
            'e' => $e
        ]);
    }

    private function hasAccess()
    {
        return $this->module->password == Yii::$app->session->get('__styleguide_pass', false);
    }
}
