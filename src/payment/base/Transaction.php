<?php

namespace luya\payment\base;

use yii\base\Object;

class Transaction extends Object
{
    public $provider = null;
    
    public function __construct(ProviderInterface $provider, array $config = [])
    {
        $this->provider = $provider;
        parent::__construct($config);
    }
}