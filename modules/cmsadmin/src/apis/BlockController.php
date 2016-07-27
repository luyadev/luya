<?php

namespace cmsadmin\apis;

/**
 * Block Api delivers all availables CMS Blocks.
 * 
 * @author Basil Suter <basil@nadar.io>
 */
class BlockController extends \admin\ngrest\base\Api
{
    public $modelClass = 'cmsadmin\models\Block';
}
