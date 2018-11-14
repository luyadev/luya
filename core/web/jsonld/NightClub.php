<?php

namespace luya\web\jsonld;

/**
 * Night Club
 * 
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.14
 */
class NightClub extends EntertainmentBusiness
{
    /**
     * {@inheritDoc}
     */
    public function typeDefintion()
    {
        return 'NightClub';
    }
}