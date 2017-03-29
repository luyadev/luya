<?php

namespace admintests\admin\ngrest\base;

use admintests\AdminTestCase;
use luya\admin\models\User;
use yii\base\InvalidConfigException;

class ModelClassTest extends AdminTestCase
{
    const STRING_TYPE = 0;

    const OBJECT_TYPE = 1;

    public $modelClass;

    public function testCallString()
    {
        $this->setupModelClass(static::STRING_TYPE);
        $modelClass = $this->modelClass;

        $this->assertSame('admin_user', $modelClass::tableName());
        $this->assertSame('api-admin-user', $modelClass::ngRestApiEndpoint());
    }

    public function testCallObject()
    {
        $this->setupModelClass(static::OBJECT_TYPE);
        $modelClass = $this->modelClass;

        $this->assertSame('admin_user', $modelClass::tableName());
        $this->assertSame('api-admin-user', $modelClass::ngRestApiEndpoint());
    }

    protected function setupModelClass($type)
    {
        if ($type === static::STRING_TYPE) {
            $this->modelClass = User::className();
        } elseif ($type === static::OBJECT_TYPE) {
            $this->modelClass = new User();
        } else {
            throw new InvalidConfigException('Not support model type: ' . $type);
        }
    }
}
