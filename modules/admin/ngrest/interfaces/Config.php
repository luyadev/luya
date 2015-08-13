<?php

namespace admin\ngrest\interfaces;

interface Config
{
    public function setConfig(array $config);
    
    public function getConfig();
    
    public function getHash();
    
    public function getApiEndpoint();
    
    public function getPrimaryKey();
    
    public function onFinish();
}
