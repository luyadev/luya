<?php

namespace tests\web;

use DOMDocument;

class BasePlugin extends \tests\web\Base
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
