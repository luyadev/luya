<?php

namespace luyatests\core\widgets;

use luya\widgets\SubmitButtonWidget;
use luyatests\LuyaWebTestCase;
use yii\base\InvalidConfigException;
use yii\widgets\ActiveForm;

class SubmitButtonWidgetTest extends LuyaWebTestCase
{
    public function testException()
    {
        $this->expectException(\TypeError::class);
        SubmitButtonWidget::widget(['label' => 'foo', 'pushed' => 'barfoo', 'activeForm' => 'wrongType', 'options' => ['class' => 'btn']]);
    }

    public function testRun()
    {
        $this->assertSame('<button type="submit" class="btn" onclick="this.disabled=true; this.innerHTML=\'barfoo\';">foo</button>', SubmitButtonWidget::widget(['label' => 'foo', 'pushed' => 'barfoo', 'options' => ['class' => 'btn']]));
        $this->assertSame('<button type="submit" class="btn">foo</button>', SubmitButtonWidget::widget(['label' => 'foo', 'pushed' => 'barfoo', 'activeForm' => new ActiveForm(), 'options' => ['class' => 'btn']]));
    }

    public function testInvalidCall()
    {
        $this->expectException(InvalidConfigException::class);
        SubmitButtonWidget::widget();
    }
}
