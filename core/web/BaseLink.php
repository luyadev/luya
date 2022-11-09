<?php

namespace luya\web;

use yii\base\Arrayable;
use yii\base\ArrayableTrait;
use yii\base\BaseObject;

/**
 * The basic class for LinkInterface object.
 *
 * It ensures the Arrayable and Linkinterface for a given Link implementation.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.10
 */
abstract class BaseLink extends BaseObject implements LinkInterface, Arrayable
{
    use LinkTrait;
    use ArrayableTrait;

    /**
     * @inheritdoc
     */
    public function fields()
    {
        return ['href', 'target'];
    }
}
