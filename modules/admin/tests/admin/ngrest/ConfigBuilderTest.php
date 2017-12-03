<?php

namespace admintests\admin\ngrest;

use Yii;
use admintests\AdminTestCase;
use luya\admin\ngrest\ConfigBuilder;
use luya\admin\ngrest\Config;

class ConfigBuilderTest extends AdminTestCase
{
    private function getConfig()
    {
        $config = new ConfigBuilder('model\class\name');

        $config->list->field('create_var_1', 'testlabel in list')->text();
        $config->list->field('list_var_1', 'testlabel')->textarea();
        $config->list->field('list_var_2', 'testlabel')->textarea();

        $config->create->field('create_var_1', 'testlabel')->text();
        $config->create->extraField('create_extra_var_2', 'extratestlabel')->text();

        $config->update->copyFrom('list', ['textvar2']);

        return $config->getConfig();
    }

    public function testNgRestConfigBuilder()
    {
        $array = $this->getConfig();

        $this->assertArrayHasKey('update', $array);
        $this->assertArrayNotHasKey('delete', $array);
        $this->assertArrayHasKey('list', $array);
        $this->assertArrayHasKey('create', $array);

        $list = $array['list'];
        $create = $array['create'];

        $this->assertArrayHasKey('list_var_1', $list);
        $this->assertArrayHasKey('create_var_1', $create);

        $testvar = $list['list_var_1'];

        $this->assertArrayHasKey('name', $testvar);
        $this->assertArrayHasKey('i18n', $testvar);
        $this->assertArrayHasKey('alias', $testvar);
        $this->assertArrayHasKey('type', $testvar);
        $this->assertArrayHasKey('i18n', $testvar);
        $this->assertArrayHasKey('extraField', $testvar);

        $plugin = $testvar['type'];

        $this->assertArrayHasKey('class', $plugin);
        $this->assertArrayHasKey('args', $plugin);
        // check if args
        $this->assertEquals('\luya\admin\ngrest\plugins\Textarea', $plugin['class']);
        // text extraField = 1
        $this->assertEquals(1, $create['create_extra_var_2']['extraField']);
    }

    public function testNgRestConfigAW()
    {
        $config = new ConfigBuilder('model\class\name');
        $config->aw->load(['class' => 'luya\admin\aws\ChangePasswordActiveWindow', 'label' => 'Change Password']);
        $cfg = $config->getConfig();

        $this->assertArrayHasKey('aw', $cfg);
        $aw = $cfg['aw'];
        
        $this->assertArrayHasKey('ff21bd877239c16ade6e598df6d2bfa91c127953', $aw);
        $obj = $aw['ff21bd877239c16ade6e598df6d2bfa91c127953'];

        $this->assertArrayHasKey('objectConfig', $obj);
        $this->assertArrayHasKey('label', $obj);
        $this->assertArrayHasKey('icon', $obj);


        $ngRestConfig = new Config(['apiEndpoint' => 'api-admin-test', 'primaryKey' => 'id']);
        $ngRestConfig->setConfig($cfg);
    }

    public function testNgRestConfigPlugins()
    {
        $configData = $this->getConfig();
        $ngRest = new Config(['apiEndpoint' => 'api-admin-test', 'primaryKey' => 'id']);
        $ngRest->setConfig($configData);
        $plugins = $ngRest->getPlugins();

        $this->assertEquals(4, count($plugins));
    }

    public function testNgRestConfigExtraFields()
    {
        $configData = $this->getConfig();
        $ngRest = new Config(['apiEndpoint' => 'api-admin-test', 'primaryKey' => 'id']);
        $ngRest->setConfig($configData);

        $fields = $ngRest->getExtraFields();
        $this->assertEquals(1, count($fields));
        $this->assertEquals('create_extra_var_2', $fields[0]);

        $fields = $ngRest->extraFields;
        $this->assertEquals(1, count($fields));
        $this->assertEquals('create_extra_var_2', $fields[0]);
    }

    public function testNgRestConfigAppendFieldOption()
    {
        $configData = $this->getConfig();
        $ngRest = new Config(['apiEndpoint' => 'api-admin-test', 'primaryKey' => 'id']);
        $ngRest->setConfig($configData);

        $ngRest->appendFieldOption('list_var_1', 'i18n', true);
        $field = $ngRest->getField('list', 'list_var_1');
        $this->assertEquals(true, $field['i18n']);
        $field = $ngRest->getField('list', 'list_var_2');
        $this->assertEquals(false, $field['i18n']);
    }

    public function testNgRestConfig()
    {
        $configData = $this->getConfig();

        $ngRestConfig = Yii::createObject(['class' => '\luya\admin\ngrest\Config', 'apiEndpoint' => 'api-admin-test']);
        //$ngRestConfig = new \admin\ngrest\Config('api-admin-test', 'id');
        $ngRestConfig->setConfig($configData);

        $this->assertEquals('2082601d161230ac7b3092fa7f58a05d', $ngRestConfig->getHash());
        $this->assertEquals('2082601d161230ac7b3092fa7f58a05d', $ngRestConfig->hash);
        $this->assertEquals(true, $ngRestConfig->hasPointer('list'));
        $this->assertEquals(true, $ngRestConfig->hasPointer('create'));
        $this->assertEquals(true, $ngRestConfig->hasPointer('update'));
        $this->assertEquals(false, $ngRestConfig->hasPointer('delete'));
        $this->assertEquals(false, $ngRestConfig->hasPointer('aw'));

        $this->assertEquals(true, $ngRestConfig->hasField('list', 'create_var_1'));
        $this->assertEquals(false, $ngRestConfig->hasField('list', 'id'));

        $this->assertEquals(false, $ngRestConfig->isDeletable());

        $ngRestConfig->addField('list', 'foo', [
            'name' => 'foo',
            'alias' => 'ID',
            'plugins' => [
                [
                    'class' => '\luya\admin\ngrest\plugins\Text',
                    'args' => [],
                ],
            ],
        ]);
        $this->assertEquals(true, $ngRestConfig->hasField('list', 'foo'));
    }

    public function testOnFinish()
    {
        $configData = $this->getConfig();
        $ngRestConfig = Yii::createObject(['class' => '\luya\admin\ngrest\Config', 'apiEndpoint' => 'api-admin-test', 'primaryKey' => ['id']]);
        //$ngRestConfig = new \admin\ngrest\Config('api-admin-test', 'id');
        $this->assertEquals(false, $ngRestConfig->hasField('list', 'id'));
        $ngRestConfig->setConfig($configData);
        $ngRestConfig->onFinish();
        $this->assertEquals(true, $ngRestConfig->hasField('list', 'id'));
    }
}
