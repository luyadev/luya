<?php

namespace luya\payment\transaction;

use luya\payment\base\Transaction;
use yii\web\Response;
use luya\payment\base\TransactionInterface;

class SaferPayTransaction extends Transaction implements TransactionInterface
{
    public $accountId = null;
    
    public $amount = null;
    
    public $currency = null;
    
    public $description = null;
    
    public $orderId = null;
    
    public $successLink = null;
    
    public $failLink = null;
    
    public $backLink = null;
    
    public $notifyUrl = null;
    
    public function create()
    {
        $url = $this->provider->call('create', [
            'accountId' => $this->accountId,
            'amount' => $this->amount,
            'currency' => $this->currency,
            'description' => $this->description,
            'orderId' => $this->orderId,
            
            'successLink' => $this->successLink,
            'failLink' => $this->failLink,
            'backLink' => $this->backLink,
            'notifyUrl' => $this->notifyUrl,
        ]);
        
        return (new Response())->redirect($url);
    }
    
    public function success()
    {
        
    }
    
    public function notify()
    {
        
    }
    
    public function fail()
    {
        
    }
    
    public function back()
    {
        
    }
}