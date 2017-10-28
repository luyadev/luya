<?php

namespace luya\cms\admin\apis;

/**
 * NavContainer api provides cms_nav_container data.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class NavContainerController extends \luya\admin\ngrest\base\Api
{
    public $modelClass = 'luya\cms\models\NavContainer';
}
