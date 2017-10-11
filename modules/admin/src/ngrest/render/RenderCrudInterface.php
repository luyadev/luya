<?php

namespace luya\admin\ngrest\render;

/**
 * Interface for CRUD renderers.
 *
 * All CRUD renderers must implement this interface in order to interact with the API and Controllers.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
interface RenderCrudInterface
{
    public function getRelationCall();
    
    public function setRelationCall(array $options);
    
    /**
     * Get whether the inline mode is enabled or not.
     *
     * @return boolena Determine whether this ngrest config is runing as inline window mode (a modal dialog with the
     * crud inside) or not. When inline mode is enabled some features like ESC-Keys and URL chaning must be disabled.
     */
    public function getIsInline();
    
    /**
     * Setter method for inline mode.
     *
     * @param boolean $inline
     */
    public function setIsInline($inline);
    
    public function setModelSelection($selection);
    
    public function getModelSelection();
    
    public function setSettingButtonDefinitions(array $buttons);
    
    public function getSettingButtonDefinitions();
}
