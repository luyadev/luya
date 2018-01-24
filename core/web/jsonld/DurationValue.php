<?php

namespace luya\web\jsonld;

/**
 * Convert Timestamp or String to duration.
 * 
 * Example usage:
 * 
 * ```php
 * new DurationValue(strtotime("1 hour 30 minutes", 0));
 * ```
 * 
 * Or as string
 * 
 * ```php
 * new DurationValue("1 hour 30 minutes");
 * ```
 * 
 * 
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.3
 */
class DurationValue extends BaseValue
{
    private $_duration;
    
    /**
     * Set duration data.
     * 
     * @param string|integer $duration
     */
    public function __construct($duration)
    {
        $this->_duration = $duration;    
    }
    
    /**
     * {@inheritDoc}
     */
    public function getValue()
    {
        // if its not a unix timestamp, try to convert "strtotime("1 hour 30 minutes", 0);"
        if (!is_numeric($this->_duration)) {
            $this->_duration = strtotime($this->_duration, 0);   
        }
        
        return $this->timeToIso8601Duration($this->_duration);
    }
    
    /**
     * Convert time to iso date.
     * 
     * @see https://stackoverflow.com/a/13301472/4611030
     * @param integer $time
     * @return string
     */
    protected function timeToIso8601Duration($time)
    {
        $units = array(
            "Y" => 365*24*3600,
            "D" =>     24*3600,
            "H" =>        3600,
            "M" =>          60,
            "S" =>           1,
        );
        
        $str = "P";
        $istime = false;
        
        foreach ($units as $unitName => &$unit) {
            $quot  = intval($time / $unit);
            $time -= $quot * $unit;
            $unit  = $quot;
            if ($unit > 0) {
                if (!$istime && in_array($unitName, array("H", "M", "S"))) { // There may be a better way to do this
                    $str .= "T";
                    $istime = true;
                }
                $str .= strval($unit) . $unitName;
            }
        }
        
        return $str;
    }
}