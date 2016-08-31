<?php

namespace luya\account;

interface RegisterInterface
{
    public function rules();
    
    public function register();
    
    public function getModel();
}
