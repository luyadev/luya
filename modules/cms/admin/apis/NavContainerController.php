<?php

namespace luya\cms\admin\apis;

/**
 * NavContainer api provides cms_nav_container data.
 * 
 * @author Basil Suter <basil@nadar.io>
 */
class NavContainerController extends \admin\ngrest\base\Api
{
    public $modelClass = 'luya\cms\models\NavContainer';
}
