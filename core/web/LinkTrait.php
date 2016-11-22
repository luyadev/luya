<?php

namespace luya\web;

/**
 * Link resources Trait Integrator.
 *
 * @author Basil Suter <basil@nadar.io>
 */
trait LinkTrait
{
    public function __toString()
    {
        return $this->getHref();
    }
}
