<?php

namespace luya\web;

/**
 * Link Resource Interface.
 * 
 * Each Linkable resource object should integrate this.
 * 
 * @author Basil Suter <basil@nadar.io>
 */
interface LinkInterface
{
    public function getHref();
	
	public function getTarget();
}