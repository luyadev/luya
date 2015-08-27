<?php

namespace luya\cli;

class Application extends \yii\console\Application
{
    use \luya\traits\Application;

    public $mute = false;
}
