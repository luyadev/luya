<?php

namespace luya\web\jsonld;

/**
 * JsonLd - Creative Work
 *
 * The most generic kind of creative work, including books, movies, photographs, software programs, etc.
 *
 * @see http://schema.org/CreativeWork
 *
 * @author Alex Schmid <alex.schmid@stud.unibas.ch>
 * @since 1.0.1
 */
class CreativeWork extends BaseThing implements CreativeWorkInterface
{
    use CreativeWorkTrait;
    /**
     * @inheritdoc
     */
    public function typeDefintion()
    {
        return 'CreativeWork';
    }
}
