<?php

namespace luya\theme;

use yii\base\Event;

/**
 * Event class for theme manager on setup the active theme.
 *
 * @author Bennet Klarhoelter <boehsermoe@me.com>
 * @since  1.1.0
 */
class SetupEvent extends Event
{
    /**
     * @var string Base path of the theme to setup.
     */
    public $basePath;
}
