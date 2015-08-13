<?php

namespace admin\ngrest\interfaces;

interface Config
{
    public function setConfig(array $config);
    
    public function getConfig();
    
    public function getHash();
    
    public function getExtraFields();
    
    public function onFinish();
}
