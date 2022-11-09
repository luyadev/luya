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
        $model->attachBehavior('jsonBehavior', ['class' => JsonBehavior::class, 'attributes' => ['json'], 'decodeAfterFind' => true, 'encodeBeforeValidate' => true]);

        $model->addRule('json', 'string');

        $model->json = ['foo' => 'bar'];

        $this->assertTrue($model->validate());

        $this->assertSame('{"foo":"bar"}', $model->json);

        $model->trigger(ActiveRecord::EVENT_AFTER_FIND);

        $this->assertSame(['foo' => 'bar'], $model->json);
    }

    public function testOfAttributes()
    {
        $model = new DynamicModel(['json' => null]);
        $model->attachBehavior('jsonBehavior', ['class' => JsonBehavior::class, 'attributes' => ['json'], 'decodeAfterFind' => true, 'encodeBeforeValidate' => false]);

        $model->addRule('json', 'string');

        $model->json = "[1,2,3]";

        $this->assertTrue($model->validate());

        $this->assertSame('[1,2,3]', $model->json);

        $model->trigger(ActiveRecord::EVENT_AFTER_FIND);

        $this->assertSame([1,2,3], $model->json);
    }

    public function testOfAttributesAlreadyArray()
    {
        $model = new DynamicModel(['json' => null]);
        $model->attachBehavior('jsonBehavior', ['class' => JsonBehavior::class, 'attributes' => ['json'], 'decodeAfterFind' => true, 'encodeBeforeValidate' => false]);

        $model->addRule('json', 'each', ['rule' => ['safe']]);

        $model->json = [1,2,3];

        $this->assertTrue($model->validate());

        $this->assertSame('[1,2,3]', $model->json);

        $model->trigger(ActiveRecord::EVENT_AFTER_FIND);

        $this->assertSame([1,2,3], $model->json);

        $model->trigger(ActiveRecord::EVENT_AFTER_FIND);

        $this->assertSame([1,2,3], $model->json);

        $this->assertSame('[1,2]', $model->jsonEncode('[1,2]'));
    }

    public function testExpectedDefaultBehavior()
    {
        $model = new DynamicModel(['json' => null]);
        $model->attachBehavior('jsonBehavior', ['class' => JsonBehavior::class, 'attributes' => ['json']]);
        $model->addRule('json', 'each', ['rule' => ['safe']]);

        $model->json = [1,2,3];

        $this->assertTrue($model->validate());

        $this->assertSame('[1,2,3]', $model->json);

        $model->trigger(ActiveRecord::EVENT_AFTER_FIND);

        $this->assertSame([1,2,3], $model->json);
    }
}
