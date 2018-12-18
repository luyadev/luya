<?php

namespace luya\web\jsonld;

/**
 * Bar or Pub
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.14
 */
class BarOrPub extends FoodEstablishment
{
    /**
     * {@inheritDoc}
     */
    public function typeDefintion()
    {
        return 'BarOrPub';
    }
}
