<?php

namespace luya\web\jsonld;

/**
 * A combination of date and time of day in the form [-]CCYY-MM-DDThh:mm:ss[Z|(+|-)hh:mm] (see Chapter 5.4 of ISO 8601).
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.3
 */
class DateTimeValue extends BaseValue
{
    private $_datetime;

    /**
     * Provide datetime value.
     *
     * @param string|integer $datetime
     */
    public function __construct($datetime)
    {
        $this->_datetime = $datetime;
    }

    /**
     * @inheritDoc
     */
    public function getValue()
    {
        if (is_numeric($this->_datetime)) {
            $this->_datetime = date("c", $this->_datetime);
        }

        return $this->_datetime;
    }
}
