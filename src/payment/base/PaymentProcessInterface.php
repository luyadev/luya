<?php

namespace luya\payment\base;

interface PaymentProcessInterface
{
    public function getAmount();
    
    public function getCurrency();
    
    public function getOrderId();

    public function getTransactionGatewaySuccessLink();
    
    public function getTransactionGatewayFailLink();
    
    public function getTransactionGatewayBackLink();
    
    public function getTransactionGatewayNotifyLink();
    
    public function getApplicationSuccessLink();
    
    public function getApplicationErrorLink();
    
    public function getApplicationBackLink();
}
