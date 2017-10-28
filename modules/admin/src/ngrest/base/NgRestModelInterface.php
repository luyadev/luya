<?php

namespace luya\admin\ngrest\base;

/**
 * Interface For NgRest Model.
 *
 * Each Active-Record which is used as an NgRest Configuration must implement this Interface.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
interface NgRestModelInterface
{
    /**
     * Defines the base inline configuration for the current Model.
     *
     * @param \luya\admin\ngrest\ConfigBuilder $config ConfigBuilder Object
     * @return \luya\admin\ngrest\ConfigBuilder
     */
    public function ngRestConfig($config);
    
    /**
     * Defines the Api Endpoint for the current Active Record model.
     *
     * @return string
     */
    public static function ngRestApiEndpoint();
    
    /**
     * Whether current model is in ngrest context or not
     *
     * @return boolean
     */
    public function getIsNgRestContext();
}
