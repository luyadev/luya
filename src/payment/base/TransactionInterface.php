<?php

namespace luya\payment\base;

interface TransactionInterface
{
    public function create();
    
    public function success();
    
    public function notify();
    
    public function fail();
    
    public function back();
    
    public function getProvider();
}
