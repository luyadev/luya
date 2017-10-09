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
    
    public function getIsInline();
    
    public function setIsInline($inline);
    
    public function setModelSelection($selection);
    
    public function getModelSelection();
    
    public function setGlobalButtons(array $buttons);
    
    public function getGlobalButtons();
}
