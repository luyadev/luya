<?php

namespace luya\web\jsonld;

class Event extends BaseThing
{
    private $_locations = [];
    
    public function getLocations()
    {
        return $this->_locations;
    }
    
    public function setLocation(Location $location)
    {
        $this->_locations[] = $location;
    
        return $this;
    }
    
    public function fields()
    {
        return [
            'locations',
        ];
    }
}
