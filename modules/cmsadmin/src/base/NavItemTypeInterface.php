<?php

namespace cmsadmin\base;

/**
 * 
 * @author nadar
 * @since 1.0.0-beta6
 */
interface NavItemTypeInterface
{

	/**
	 * Returns the databas-nummeric identifier to make the navItem relation.
	 *
	 * @return integer The numeric identifier for the type (1=page, 2=module, 3=redirect, ...)
	 */
	static public function getNummericType();
}