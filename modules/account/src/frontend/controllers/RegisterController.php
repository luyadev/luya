<?php

namespace luya\account\frontend\controllers;

use Yii;
use Exception;
use luya\helpers\Url;
use luya\account\frontend\base\Controller;

class RegisterController extends Controller
{
    public function getRules()
    {
        return [
            [
                'allow' => true,
                'actions' => ['index', 'activate'],
                'roles' => ['?'],
            ],
        ];
    }

    /**
     * @todo implementation
     * @param unknown $hash
     */
    public function actionActivate($hash)
    {
        // activation process
    }
    
    public function actionIndex()
    {
        $model = Yii::createObject(['class' => $this->module->registerFormClass]);
        
        if (!$model instanceof \account\RegisterInterface) {
            throw new Exception("Register form class must be instance of register interface.");
        }
        
        $state = false;
        
        if (Yii::$app->request->post()) {
            $model->load(Yii::$app->request->post());
            if (($user = $model->register()) !== false) {
                $state = null;
                
                if ($this->module->registerConfirmEmail) {
                    // send mail
                    $hashKey = Yii::$app->security->generateRandomString();
                    $user->verification_hash = $hashKey;
                    $user->update(false);
                    $mail = $this->renderPartial('mail/_validationlink.php', [
                        'hashKey' => $hashKey,
                        'user' => $user,
                        'link' => Url::to(['/account/register/activate', 'hash' => $hashKey], true),
                    ]);
                    $state = 1;
                }
                if ($this->module->validateRegistration) {
                    $mail = $this->renderPartial('mail/_waituntilvalidation.php', ['user' => $user]);
                    // send mail to admin and user
                    $user->update(false);
                    $state = 2;
                }
                
                if ($state === null) {
                    $mail = $this->renderPartial('mail/_login.php', ['user' => $user]);
                    // the user is registered directly.
                    $user->is_mail_verified = 1;
                    $user->is_active = 1;
                    $user->update(false);
                    $state = 3;
                }
                
                Yii::$app->mail->compose('Registration', $mail)->address($user->email)->send();
            }
        }
        
        return $this->renderLayout('index', [
            'model' => $model,
            'state' => $state,
        ]);
    }
}
