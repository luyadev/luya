<?php

namespace admin\ngrest;

interface NgRestModeInterface
{
    public function ngRestConfig($config);
    
    public function ngRestApiEndpoint();
}