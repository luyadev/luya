<?php

namespace luya\widgets;

use luya\base\Widget;
use luya\helpers\Html;
use luya\helpers\ArrayHelper;
use yii\base\InvalidConfigException;
use yii\web\JsExpression;

/**
 * Generates a submit button for a form. This should be used when submiting payment forms
 * in order to ensure a request is not send twice.
 *
 * ```php
 * $form = ActiveForm::begin();
 * // form code
 *
 * SubmitButtonWidget::widget(['label' => 'Save', 'pushed' => 'Saving ...', 'options' => ['class' => 'btn btn-primary']]);
 * $form::end();
 * ```
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.21
 */
class SubmitButtonWidget extends Widget
{
    /**
     * @var string The label which should be displayed on button.
     */
    public $label;
    
    /**
     * @var string The label which should be visible when the button is pushed. for example `... sending`.
     */
    public $pushed;

    /**
     * @var array An array with Options which can be passed to the button, see {{luya\helpers\Html::submitButton}}.
     */
    public $options = [];

    /**
     * {@inheritDoc}
     */
    public function init()
    {
        parent::init();

        if (!$this->label) {
            throw new InvalidConfigException("The label property can not be empty.");
        }
    }

    /**
     * {@inheritDoc}
     */
    public function run()
    {
        $js = [
            'this.disabled=true;',
        ];

        if ($this->pushed) {
            $js[] = "this.innerHTML='{$this->pushed}';";
        }

        return Html::decode(Html::submitButton($this->label, ArrayHelper::merge([
            'onclick' => new JsExpression(implode(" ", $js)),
            'encoding' => false,
        ], $this->options)));
    }
}