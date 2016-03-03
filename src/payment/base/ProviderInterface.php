<?php

namespace luya\payment\base;

interface ProviderInterface
{
    public function getId();
    
    public function call($method, array $vars = []);
}
