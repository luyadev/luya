<?php

namespace luyatests\core\traits;

use luya\traits\RegistryTrait;
use luyatests\LuyaWebTestCase;
use Yii;
use yii\db\ActiveRecord;

class UserStub extends ActiveRecord
{
    use RegistryTrait;

    public static function getDb()
    {
        return Yii::$app->sqllite;
    }

    public static function tableName()
    {
        return 'mytest';
    }
}

class RegistryTraitTest extends LuyaWebTestCase
{
    public function testRegistryTraitHandler()
    {
        Yii::$app->sqllite->createCommand()->createTable('mytest', ['id' => 'INT(11) PRIMARY KEY', 'name' => 'varchar(120)', 'value' => 'varchar(120)'])->execute();

        $this->assertFalse(UserStub::has('foo'));
        $this->assertNull(UserStub::get('foo'));
        $this->assertTrue(UserStub::set('foo', 'bar'));
        $this->assertSame('bar', UserStub::get('foo'));
        $this->assertTrue(UserStub::has('foo'));
        $this->assertTrue(UserStub::remove('foo'));
        $this->assertFalse(UserStub::has('foo'));

        // test override

        $this->assertTrue(UserStub::set('foo', 'bar'));
        $this->assertTrue(UserStub::set('foo', 'baz'));
        $this->assertSame('baz', UserStub::get('foo'));
        $this->assertTrue(UserStub::remove('foo'));
        $this->assertFalse(UserStub::remove('foo'));
    }
}
