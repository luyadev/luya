<?php


namespace luyatests\core\traits;

use Yii;
use luya\traits\RegistryTrait;
use luyatests\LuyaWebTestCase;
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
		
		$r = Yii::$app->sqllite->createCommand()->createTable('mytest', ['name' => 'varchar(120)', 'value' => 'varchar(120)'])->execute();
		
		$this->assertFalse(UserStub::has('foo'));
		$this->assertNull(UserStub::get('foo'));
		$this->assertTrue(UserStub::set('foo', 'bar'));
		$this->assertSame('bar', UserStub::get('foo'));
		$this->assertTrue(UserStub::has('foo'));
		$this->assertTrue(UserStub::remove('foo'));
		$this->assertFalse(UserStub::has('foo'));
		
	}
}