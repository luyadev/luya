<?php

namespace tests\src\web\ngrest;

use admin\ngrest\render\RenderCrud;

class RenderCrudTest extends \tests\BaseWebTest
{
    private function getConfig()
    {
        $config = new \admin\ngrest\ConfigBuilder();
    
        $config->list->field('create_var_1', 'testlabel in list')->text();
        $config->list->field('list_var_1', 'testlabel')->textarea();
        $config->list->field('list_var_2', 'testlabel')->textarea();
    
        $config->create->field('create_var_1', 'testlabel')->text();
        $config->create->extraField('create_extra_var_2', 'extratestlabel')->text();
    
        $config->update->copyFrom('list', ['list_var_2']);
    
        $config->getConfig();

        $ngrest = new \admin\ngrest\Config();
        $ngrest->setConfig($config->getConfig());
        $ngrest->appendFieldOption('create_extra_var_2', 'i18n', 1);
        return $ngrest;
    }
    
    public function testObject()
    {
        $crud = new RenderCrud();
        $crud->setConfig($this->getConfig());
        
        $this->assertEquals(false, $crud->can(RenderCrud::TYPE_LIST));
        $this->assertEquals(false, $crud->can(RenderCrud::TYPE_CREATE));
        $this->assertEquals(false, $crud->can(RenderCrud::TYPE_UPDATE));
        
        $fields = $crud->getFields('list');
        
        $this->assertArrayHasKey(2, $fields);
        $this->assertEquals(3, count($fields));
        $this->assertEquals('create_var_1', $fields[0]);
        $this->assertEquals(2, count($crud->getFields('create')));
        $this->assertEquals(2, count($crud->getFields('update')));
        $this->assertEquals(0, count($crud->getButtons()));
        $this->assertEquals('ngrestCall=1&ngrestCallType=list&fields=create_var_1,list_var_1,list_var_2&expand=create_extra_var_2', $crud->apiQueryString('list'));
        $this->assertEquals('ngrestCall=1&ngrestCallType=create&fields=create_var_1,create_extra_var_2&expand=create_extra_var_2', $crud->apiQueryString('create'));
        $this->assertEquals('ngrestCall=1&ngrestCallType=update&fields=create_var_1,list_var_1&expand=create_extra_var_2', $crud->apiQueryString('update'));
        
    }
    
    public function testi18nElement()
    {
        $crud = new RenderCrud();
        $crud->setConfig($this->getConfig());
        
        $p = $crud->config->getPointer('create');
        
        
        $this->arrayHasKey('create_var_1', $p);
        $this->arrayHasKey('create_extra_var_2', $p);
        $single = $crud->createElements($p['create_var_1'], 'create');
        $multi = $crud->createElements($p['create_extra_var_2'], 'create');

        $this->assertEquals(1, count($single));
        $this->assertEquals(2, count($multi));
        
        $this->assertEquals("id-b7d30cdb9fb07806eba16560e8f1886a", $single[0]['id']);
        $this->assertEquals("data.create.create_var_1", $single[0]['ngModel']);
        $this->assertEquals('<zaa-text fieldid="id-b7d30cdb9fb07806eba16560e8f1886a" fieldname="create_var_1" model="data.create.create_var_1" label="testlabel" grid="12" placeholder=""></zaa-text>', $single[0]['html']);
    
        $this->assertEquals("id-8c4eef840c2154c03371710f803dee51", $multi[0]['id']);
        $this->assertEquals("data.create.create_extra_var_2['de']", $multi[0]['ngModel']);
        $this->assertEquals('<zaa-text fieldid="id-8c4eef840c2154c03371710f803dee51" fieldname="create_extra_var_2" model="data.create.create_extra_var_2[\'de\']" label="extratestlabel Deutsch" grid="12" placeholder=""></zaa-text>', $multi[0]['html']);
        
        $this->assertEquals("id-ee7d7b56d54cd3af4b7f9a4b4bfddf36", $multi[1]['id']);
        $this->assertEquals("data.create.create_extra_var_2['en']", $multi[1]['ngModel']);
        $this->assertEquals('<zaa-text fieldid="id-ee7d7b56d54cd3af4b7f9a4b4bfddf36" fieldname="create_extra_var_2" model="data.create.create_extra_var_2[\'en\']" label="extratestlabel English" grid="12" placeholder=""></zaa-text>', $multi[1]['html']);
        
    }
}