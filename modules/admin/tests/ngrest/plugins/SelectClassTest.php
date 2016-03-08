<?php

namespace tests\web\admin\ngrest\plugins;

/**
 * @todo test against real config data.
 * 
 * @author nadar
 */
class SelectClassTest extends \tests\web\BasePlugin
{
    public function testPlugin()
    {
        $text = new \admin\ngrest\plugins\SelectClass('\\tests\\data\\models\\UserModel', 'id', 'firstname');
        $this->assertEquals('<span>{{item.}}</span>', $this->renderListHtml($text));
        $this->assertEquals('<zaa-select fieldid="" fieldname="" model="" label="" i18n="" initvalue="" options="service..selectdata"></zaa-select>', $this->renderCreateHtml($text));
        $this->assertEquals('<zaa-select fieldid="" fieldname="" model="" label="" i18n="" initvalue="" options="service..selectdata"></zaa-select>', $this->renderUpdateHtml($text));
    }
}
