<?php

namespace app\modules\contactmanager\frontend\controllers;

use luya\web\Controller;
use luya\helpers\Url;
use yii\base\Model;
use yii\captcha\CaptchaAction;

class F extends Model
{
    public $verifyCode;
}
class DefaultController extends Controller
{
    public function actionIndex()
    {
        $model = new F();
        return $this->render('index', ['model' => $model]);
        return '<iframe src="'.Url::to('contactmanager/default/captcha').'"></iframe>';
    }
    
    public function actions()
    {
        return [
            'captcha' => CaptchaAction::class
        ];
    }
}
