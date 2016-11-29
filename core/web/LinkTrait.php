<?php

namespace luya\web;

/**
 * Link resources Trait Integrator.
 *
 * Implementation of this trait will allow to echo the object in order to return the href of the link.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0-RC2
 */
trait LinkTrait
{
    /**
     * Return the href string from getHref() when echoing the object.
     */
    public function __toString()
    {
        return $this->getHref();
    }
}
