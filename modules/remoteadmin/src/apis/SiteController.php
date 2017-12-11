<?php

namespace luya\remoteadmin\apis;

/**
 * Site model API.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class SiteController extends \luya\admin\ngrest\base\Api
{
    public $modelClass = 'luya\remoteadmin\models\Site';
}
