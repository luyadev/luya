<?php

namespace luya\web\jsonld;

class Event extends BaseGraphElement
{
    private $_locations = [];
    
    public function getLocations()
    {
        return $this->_locations;
    }
    
    public function setLocation(array $config = [])
    {
        $object = new Location($config);
        
        $this->_locations[] = $object;

        return $object;
    }
    
    public function fields()
    {
        return [
            'locations',
            
        ];
    }
}
