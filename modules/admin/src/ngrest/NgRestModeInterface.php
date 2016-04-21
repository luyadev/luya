<?php

namespace admin\ngrest;

/**
 * Interface For NgRest Modle
 * 
 * @todo move to interfaces
 * @author Basil Suter <basil@nadar.io>
 */
interface NgRestModeInterface
{
    public function ngRestConfig($config);
    
    public function ngRestApiEndpoint();
}
