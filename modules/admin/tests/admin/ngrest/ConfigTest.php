<?php

namespace admintests\admin\ngrest;

use admintests\AdminTestCase;
use luya\admin\ngrest\Config;

class ConfigTest extends AdminTestCase
{
    /**
     * @expectedException yii\base\InvalidConfigException
     */
    public function testSetConfigException()
    {
        $cfg = new Config(['apiEndpoint' => 'rest-url', 'primaryKey' => 'id']);
        $cfg->setConfig(['foo' => 'bar']);
        $cfg->setConfig(['not' => 'valid']); // will throw exception: Cant set config if config is not empty
    }

    public function testAddFieldIfExists()
    {
        $cfg = new Config(['apiEndpoint' => 'rest-url', 'primaryKey' => 'id']);
        $this->assertEquals(true, $cfg->addField('list', 'foo'));
        $this->assertEquals(false, $cfg->addField('list', 'foo'));
    }
}
