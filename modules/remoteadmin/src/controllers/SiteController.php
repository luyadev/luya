<?php

namespace luya\remoteadmin\controllers;

/**
 * SiteController provides Site management via Active Record.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class SiteController extends \luya\admin\ngrest\base\Controller
{
    public $modelClass = 'luya\remoteadmin\models\Site';
}
