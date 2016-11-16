<?php

namespace luya\web;

abstract class Link
{
	abstract public function getHref();
	
	abstract public function getTarget();
	
	public function __toString()
	{
		return $this->getHref();
	}
}