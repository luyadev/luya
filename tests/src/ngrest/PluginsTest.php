<?php

namespace tests\src\ngrest;

use Yii;

class PluginsTest extends \tests\BaseTest
{
    public $constructors = [
        'CheckboxRelation' => ['\\tests\\data\\Model', 'a', 'b', 'c', [1,2,3], 'de'],
        'SelectArray' => [['foo' => 'bar', 'baz' => 'foo'], 'baz'],
        'SelectClass' => ['\\tests\\data\\Model', 'id', 'firstname'],
    ];

    public $skip = [
        'Select'
    ];
    
    private function constructorDescriber($class)
    {
        if (array_key_exists($class, $this->constructors)) {
            return $this->constructors[$class];
        }
        
        return [];
    }
    
    private function getPlugins()
    {
        $objects = [];
        foreach(scandir(Yii::getAlias('@admin/ngrest/plugins')) as $file) {
            if (substr($file, 0, 1) == ".") {
                continue;
            }
            $name = pathinfo($file, PATHINFO_FILENAME);
            if (in_array($name, $this->skip)) {
                continue;
            }
            $objects[] = [
                'name' => $name,
                'class' => 'admin\\ngrest\\plugins\\' . $name,
                'constructor' => $this->constructorDescriber($name),
            ];
        }       
        
        return $objects;
    }
    
    public function testPluginObjects()
    {
        foreach($this->getPlugins() as $class) {
            $obj = Yii::createObject($class['class'], $class['constructor']);
            $obj->setConfig('id', 'name', 'ngModel', 'alias', 12);
            $this->assertEquals('service.name.foo', $obj->getServiceName('foo'));
        }
    }
}