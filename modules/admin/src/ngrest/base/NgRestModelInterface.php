<?php

namespace luya\admin\ngrest\base;

/**
 * Interface For NgRest Model.
 *
 * Each Active-Record which is used as an NgRest Configuration must implement this Interface.
 *
 * @author Basil Suter <basil@nadar.io>
 */
interface NgRestModelInterface
{
    /**
     * Defines the base inline configuration for the current Model.
     *
     * @param \admin\ngrest\ConfigBuilder $config ConfigBuilder Object
     * @return \admin\ngrest\ConfigBuilder
     */
    public function ngRestConfig($config);
    
    /**
     * Defines the Api Endpoint for the current Active Record model.
     *
     * @return string
     */
    public static function ngRestApiEndpoint();
}
