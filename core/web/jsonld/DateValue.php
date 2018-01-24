<?php

namespace luya\web\jsonld;

/**
 * A date value in ISO 8601 date format.
 * 
 * Auto convert timestamp values to iso 8601 date.
 * 
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.3
 */
class DateValue extends BaseValue
{
    private $_date;
    
    /**
     * Provide date data.
     * 
     * @param string|integer $date
     */
    public function __construct($date)
    {
        $this->_date = $date;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getValue()
    {
        if (is_numeric($this->_date)) {
            $this->_date = date("Y-m-d", $this->_date);
        }
        
        return $this->_date;
    }
}