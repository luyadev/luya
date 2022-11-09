<?php

namespace luyatests\core\behaviors;

use luya\behaviors\Timestamp;
use luyatests\data\models\DummyBaseModel;
use luyatests\LuyaWebTestCase;
use yii\base\ModelEvent;

class TimestampTest extends LuyaWebTestCase
{
    public function testInsertEvent()
    {
        $event = new ModelEvent();
        $event->sender = new DummyBaseModel();

        $behavior = new Timestamp();
        $behavior->insert = ['foo'];
        $behavior->beforeInsert($event);

        $this->assertNotNull($event->sender->foo);
        $this->assertNull($event->sender->bar);
    }

    public function testUpdateEvent()
    {
        $event = new ModelEvent();
        $event->sender = new DummyBaseModel();

        $behavior = new Timestamp();
        $behavior->update = ['foo'];
        $behavior->beforeUpdate($event);

        $this->assertNotNull($event->sender->foo);
        $this->assertNull($event->sender->bar);
    }
}
