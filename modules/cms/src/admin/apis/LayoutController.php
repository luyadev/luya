<?php

namespace luya\cms\admin\apis;

/**
 * Layout Api provides CMS Layout Data.
 *
 * @author Basil Suter <basil@nadar.io>
 */
class LayoutController extends \luya\admin\ngrest\base\Api
{
    public $modelClass = 'luya\cms\models\Layout';
}
