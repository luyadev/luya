<?php

namespace tests\web\admin\ngrest\plugins;

class FileArrayTest extends \tests\web\BasePlugin
{
    public function testPlugin()
    {
        $text = new \admin\ngrest\plugins\FileArray();
        $this->assertEquals('<span>[Datei-Liste]</span>', $this->renderListHtml($text));
        $this->assertEquals('<zaa-file-array-upload fieldid="" fieldname="" model="" label="" i18n=""></zaa-file-array-upload>', $this->renderCreateHtml($text));
        $this->assertEquals('<zaa-file-array-upload fieldid="" fieldname="" model="" label="" i18n=""></zaa-file-array-upload>', $this->renderUpdateHtml($text));

        /* @todo: test against real config values 
        $text->setConfig('id', 'foo', 'bar', 'baz', 12);
        $this->assertEquals("<span>{{item.}}</span>", $this->renderListHtml($text));
        $this->assertEquals('<zaa-text fieldid="" fieldname="" model="" label="" grid="" placeholder=""></zaa-text>', $this->renderCreateHtml($text));
        $this->assertEquals('<zaa-text fieldid="" fieldname="" model="" label="" grid="" placeholder=""></zaa-text>', $this->renderUpdateHtml($text));
        */
    }
}
