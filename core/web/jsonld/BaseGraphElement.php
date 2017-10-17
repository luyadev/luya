<?php

namespace luya\web\jsonld;

use yii\base\Object;
use yii\base\Arrayable;
use yii\base\ArrayableTrait;

abstract class BaseGraphElement extends Object implements Arrayable
{
    use ArrayableTrait;
}
