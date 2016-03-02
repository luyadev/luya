<?php

namespace payment\controllers;

class DefaultController extends \luya\web\Controller
{
    private $_transaction = null;
    
    public function getTransaction()
    {
        if ($this->_transaction === null) {
            $this->_transaction = new SaferPayTransaction(new \luya\payment\provider\SaferPayProvider(), $this->module->providerConfig);
        }
            
        return $this->_transaction;
    }
    
    public function actionCreate()
    {
        return $this->transaction->create();
    }
    
    public function actionSuccess()
    {
        return $this->transaction->success();   
    }
    
    public function actionNotify()
    {
        return $this->transaction->notify();
    }
    
    public function actionFail()
    {
        return $this->transaction->fail();
    }
    
    public function actionBack()
    {
        return $this->transaction->back();
    }
}