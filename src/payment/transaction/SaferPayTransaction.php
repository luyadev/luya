<?php

namespace luya\payment\transaction;

use Yii;
use luya\payment\base\Transaction;
use luya\payment\base\TransactionInterface;
use luya\payment\provider\SaferPayProvider;
use luya\payment\PaymentException;

class SaferPayTransaction extends Transaction implements TransactionInterface
{
    public $accountId = null;
   
    public $spPassword = null;
    
    public function init()
    {
        parent::init();
        
        if (empty($this->accountId)) {
            throw new PaymentException("accountId must be set in your saferpay transaction");
        }
    }
    
    public function getProvider()
    {
        return new SaferPayProvider();
    }
    
    public function create()
    {
        $url = $this->provider->call('create', [
            'accountId' => $this->accountId,
            'amount' => $this->process->getAmount(),
            'currency' => $this->process->getCurrency(),
            'orderId' => $this->process->getOrderId(),
            'description' => $this->process->getOrderId(),
            'successLink' => $this->process->getTransactionGatewaySuccessLink(),
            'failLink' => $this->process->getTransactionGatewayFailLink(),
            'backLink' => $this->process->getTransactionGatewayBackLink(),
            'notifyUrl' => $this->process->getTransactionGatewayNotifyLink(),
        ]);
        
        return $this->context->redirect($url);
    }
    
    public function success()
    {
        $signature = Yii::$app->request->get('SIGNATURE', false);
        $data = Yii::$app->request->get('DATA', false);
        
        $confirmResponse = $this->provider->call('confirm', [
            'data' => $data,
            'signature' => $signature,
        ]);
        
        $parts = explode(":", $confirmResponse);
        
        if (isset($parts[0]) && $parts[0] == 'OK' && $parts[1]) {
            
            // create $TOKEN and $ID variable
            parse_str($parts[1]);
            
            $completeResponse = $this->provider->call('complete', [
                'id' => $ID,
                'token' => $TOKEN,
                'amount' => $this->process->getAmount(),
                'action' => 'Settlement',
                'accountId' => $this->accountId,
                'spPassword' => $this->spPassword,
            ]);
            
            $completeParts = explode(":", $completeResponse);
            
            if (isset($completeParts[0]) && $completeParts[0] == 'OK') {
                return $this->context->redirect($this->process->getApplicationSuccessLink());
            }
        }
        
        return $this->context->redirect($this->process->getApplicationErrorLink());
    }
    
    public function notify()
    {
        return 'what shal we do??';
    }
    
    public function fail()
    {
        return $this->context->redirect($this->process->getApplicationErrorLink());
    }
    
    public function back()
    {
        return $this->context->redirect($this->process->getApplicationBackLink());
    }
}
