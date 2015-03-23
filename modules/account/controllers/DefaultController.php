<?php
namespace account\controllers;

class DefaultController extends \account\base\Controller
{
    public function getRules()
    {
        return [
            [
                'allow' => true,
                'actions' => ['index'],
                'roles' => ['?', '@'],
            ], [
                'allow' => true,
                'actions' => ['lostpoass'],
                'roles' => ['?'],
            ],
        ];
    }

    /**
     * @param $_GET['redirect'] should be urlencoded
     * @param $_POST['LoginForm'] data to login
     */
    public function actionIndex()
    {
        if (!$this->module->getUserIdentity()->isGuest) {
            return $this->redirect(\luya\helpers\Url::to('account/settings/index'));
        }

        $model = new \account\models\LoginForm();
        // see if values are sent via post
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            if (($userObject = $model->login()) !== false) {
                if ($this->module->getUserIdentity()->login($userObject)) {
                    $redirect = \yii::$app->request->get('redirect', false);
                    if (!$redirect) {
                        $redirect = \luya\helpers\Url::to('account/settings/index');
                    }

                    return $this->redirect($redirect);
                }
            }
        }

        return $this->render("index", ['model' => $model]);
    }

    public function actionLostpass()
    {
        return 'lost password form';
    }
}
