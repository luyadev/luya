<?php

namespace luya\web\jsonld;

/**
 * http://schema.org/Comment
 * 
 * @author nadar
 *
 */
class ContactPoint extends BaseThing implements ContactPointInterface
{
    use ContactPointTrait;
    
    /**
     * @inheritdoc
     */
    public function typeDefintion()
    {
        return 'ContactPoint';
    }
}