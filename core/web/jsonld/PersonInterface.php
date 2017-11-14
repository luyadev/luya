<?php

namespace luya\web\jsonld;

/**
 * JsonLd - Person interface
 *
 * @see http://schema.org/Organization
 *
 * @author Alex Schmid
 * @since 1.0.0
 */
interface PersonInterface
{
    /**
     * Return the fields
     */
    public function fields();
}