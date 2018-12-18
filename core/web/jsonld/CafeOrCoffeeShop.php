<?php

namespace luya\web\jsonld;

/**
 * Cafe or Coffee Shop
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.14
 */
class CafeOrCoffeeShop extends FoodEstablishment
{
    /**
     * {@inheritDoc}
     */
    public function typeDefintion()
    {
        return 'CafeOrCoffeeShop';
    }
}
