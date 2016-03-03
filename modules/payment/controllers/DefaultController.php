<?php

namespace payment\controllers;

use Yii;
use luya\payment\transaction\SaferPayTransaction;
use payment\PaymentProcess;
use luya\helpers\Url;

class DefaultController extends \luya\web\Controller
{
    public function actionIndex()
    {
        if (YII_ENV_DEV && YII_DEBUG) {
            $process = new PaymentProcess([
                'amount' => 200, // in cent
                'orderId' => 'uniqueOrderIdNumber',
                'currency' => 'CHF',
                'successLink' => Url::toRoute(['/payment/default/test-success'], true), // user has paid successfull
                'errorLink' => Url::toRoute(['/payment/default/test-error'], true), // user got a payment error
                'backLink' => Url::toRoute(['/payment/default/test-back'], true), // user has pushed the back button
                'transactionConfig' => [
                    'class' => SaferPayTransaction::className(),
                    'accountId' => '', // https://www.bs-card-service.com/fileadmin/user_upload/com-de/Dokumente/02_CONTENT/03_Kundenservice/Downloads/E-Payment/080901Saferpay_Testlogin_Passwort_de.pdf
                    'spPassword' => '', // https://www.bs-card-service.com/fileadmin/user_upload/com-de/Dokumente/02_CONTENT/03_Kundenservice/Downloads/E-Payment/080901Saferpay_Testlogin_Passwort_de.pdf
                ],
            ]);
            
            Yii::$app->session->set('storeTransactionId', $process->getId());
            
            return $process->dispatch($this);
        }
    }
    
    public function actionTestSuccess()
    {
        if (YII_ENV_DEV && YII_DEBUG) {
            $process = PaymentProcess::findById(Yii::$app->session->get('storeTransactionId', 0));
            
            // create order for customer ...
            // ...

            $process->close(PaymentProcess::STATE_SUCCESS);
            
            return 'success!';
        }
    }
    
    public function actionTestError()
    {
        if (YII_ENV_DEV && YII_DEBUG) {
            $process = PaymentProcess::findById(Yii::$app->session->get('storeTransactionId', 0));
            
            // display error for payment

            $process->close(PaymentProcess::STATE_ERROR);
        }
    }
    
    public function actionTestBack()
    {
        if (YII_ENV_DEV && YII_DEBUG) {
            $process = PaymentProcess::findById(Yii::$app->session->get('storeTransactionId', 0));
            
            // redirect the user back to where he can choose another payment.

            $process->close(PaymentProcess::STATE_BACK);
        }
    }
    
    // real callbacks

    public function actionCreate($token, $key)
    {
        $process = PaymentProcess::findByToken($token, $key);
        $process->transaction->setContext($this);
        $process->model->addEvent(__METHOD__);
        return $process->transaction->create();
    }
    
    public function actionSuccess($token, $key)
    {
        $process = PaymentProcess::findByToken($token, $key);
        $process->transaction->setContext($this);
        $process->model->addEvent(__METHOD__);
        return $process->transaction->success();
    }
    
    public function actionFail($token, $key)
    {
        $process = PaymentProcess::findByToken($token, $key);
        $process->transaction->setContext($this);
        $process->model->addEvent(__METHOD__);
        return $process->transaction->fail();
    }
    
    public function actionBack($token, $key)
    {
        $process = PaymentProcess::findByToken($token, $key);
        $process->transaction->setContext($this);
        $process->model->addEvent(__METHOD__);
        return $process->transaction->back();
    }
    
    public function actionNotify($token, $key)
    {
        $process = PaymentProcess::findByToken($token, $key);
        $process->transaction->setContext($this);
        $process->model->addEvent(__METHOD__);
        return $process->transaction->notify();
    }
}
