<?php

namespace luya\web\jsonld;

use yii\base\InvalidConfigException;

/**
 * Opening Hours value.
 *
 * Days: Mo, Tu, We, Th, Fr, Sa, Su.
 * Time: Times are specified using 24:00 time. For example, 3pm is specified as 15:00.
 *
 * Output: Mo 10:00-23:00, We 11:00-22:00
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.14
 */
class OpeningHoursValue extends BaseValue
{
    private $_days = [];

    public const DAY_MONDAY = 1;
    public const DAY_TUESDAY = 2;
    public const DAY_WEDNESDAY = 3;
    public const DAY_THURSDAY = 4;
    public const DAY_FRIDAY = 5;
    public const DAY_SATURDAY = 6;
    public const DAY_SUNDAY = 7;

    private $_dayMap = [
        self::DAY_MONDAY => 'Mo',
        self::DAY_TUESDAY => 'Tu',
        self::DAY_WEDNESDAY => 'We',
        self::DAY_THURSDAY => 'Th',
        self::DAY_FRIDAY => 'Fr',
        self::DAY_SATURDAY => 'Sa',
        self::DAY_SUNDAY => 'Su',
    ];

    /**
     * Set a a value for a day.
     *
     * ```php
     * setDay(OpeningHoursValue::DAY_MONDAY, ['08:00' => '12:00', '14:00' => '20:00']);
     * ```
     *
     * @param [type] $name
     * @param array $time
     * @return void
     */
    public function setDay($name, array $time)
    {
        if (is_numeric($name)) {
            if (!array_key_exists($name, $this->_dayMap)) {
                throw new InvalidConfigException("The given day numeric value {$name} is not available in the list of valid day values.");
            }

            $name = $this->_dayMap[$name];
        }

        if (!array_search($name, $this->_dayMap)) {
            throw new InvalidConfigException("The given day {$name} is not in the list of valid day names.");
        }

        foreach ($time as $from => $to) {
            $this->_days[] = "{$name} {$from}-{$to}";
        }
    }

    public function getValue()
    {
        return implode(", ", $this->_days);
    }
}
