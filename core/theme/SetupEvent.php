<?php

namespace luya\theme;

use yii\base\Event;

/**
 * Event class for theme manager on setup the active theme.
 *
 * @author Bennet Klarhoelter <boehsermoe@me.com>
 */
class SetupEvent extends Event
{
    public $basePath;
}