<?php

namespace tests\src\web\ngrest\plugins;

use Yii;
use DOMDocument;

class BasePlugin extends \tests\BaseWebTest
{
    protected function renderListHtml($obj)
    {
        $doc = new DOMDocument('1.0');
        $obj->renderList($doc);
        return trim($doc->saveHtml());
    }
    
    protected function renderCreateHtml($obj)
    {
        $doc = new DOMDocument('1.0');
        $obj->renderCreate($doc);
        return trim($doc->saveHtml());
    }
    
    protected function renderUpdateHtml($obj)
    {
        $doc = new DOMDocument('1.0');
        $obj->renderUpdate($doc);
        return trim($doc->saveHtml());
    }
}