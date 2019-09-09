<?php

namespace luyatests\core\widgets;

use luya\widgets\SubmitButtonWidget;
use luyatests\LuyaWebTestCase;
use yii\base\InvalidConfigException;

class SubmitButtonWidgetTest extends LuyaWebTestCase
{
    public function testRun()
    {
        $this->assertSame('<button type="submit" class="btn" onclick="this.disabled=true; this.innerHTML=\'barfoo\';">foo</button>', SubmitButtonWidget::widget(['label' => 'foo', 'pushed' => 'barfoo', 'options' => ['class' => 'btn']]));
    }

    public function testInvalidCall()
    {
        $this->expectException(InvalidConfigException::class);
        SubmitButtonWidget::widget();
    }
}
