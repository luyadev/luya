<?php

namespace luyatests\core\behaviors;

use luya\base\DynamicModel;
use luya\behaviors\JsonBehavior;
use luyatests\LuyaWebTestCase;
use yii\db\ActiveRecord;

class JsonBehaviorTest extends LuyaWebTestCase
{
    public function testEncodingDecodingOfAttributes()
    {
        $model = new DynamicModel(['json' => null]);
        $model->attachBehavior('jsonBehavior', ['class' => JsonBehavior::class, 'attributes' => ['json'], 'decodeAfterFind' => true]);

        $model->addRule('json', 'string');

        $model->json = ['foo' => 'bar'];

        $this->assertTrue($model->validate());

        $this->assertSame('{"foo":"bar"}', $model->json);

        $model->trigger(ActiveRecord::EVENT_AFTER_FIND);
        
        $this->assertSame(['foo' => 'bar'], $model->json);
    }
}