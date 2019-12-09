<?php

namespace luya\widgets;

use luya\base\Widget;
use luya\helpers\Html;
use luya\helpers\ArrayHelper;
use yii\base\InvalidConfigException;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

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
 * @property ActiveForm $activeForm Set active form context of the button.
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

    private $_activeForm;

    /**
     * Setter method for Active Form context.
     *
     * @param ActiveForm $activeForm Set $activeForm and check for type "ActiveForm"
     * @since 1.0.24
     */
    public function setActiveForm(ActiveForm $activeForm)
    {
        $this->_activeForm = $activeForm;
    }

    /**
     * Getter method for Active Form context.
     *
     * @return ActiveForm Return $activeForm
     * @since 1.0.24
     */
    public function getActiveForm()
    {
        return $this->_activeForm;
    }

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
     * Add beforeSubmit handler which disables button and replaces button text
     * @return string
     * @since 1.0.24 Added "ActiveForm-Mode" which only disables button when given ActiveForm is validated successful
     */
    public function run()
    {
        if ($this->_activeForm) {
            $this->view->registerJs("            
            $(document).on('beforeSubmit', function (e) {                
                var buttonSelector = $(e.target).find(':submit');
                var formSelector = $(e.target);
                if (formSelector.find('div." . $this->_activeForm->errorCssClass . "').length === 0) {
                    buttonSelector.attr('disabled', true);
                    var newButtonLabel = '" . $this->pushed . "';
                    if (newButtonLabel) { buttonSelector.html('" . $this->pushed . "'); }                            
                }
                return true;});");
        } else {
            $js = [
                'this.disabled=true;',
            ];

            if ($this->pushed) {
                $js[] = "this.innerHTML='{$this->pushed}';";
            }
            $this->options = ArrayHelper::merge([
                'onclick' => new JsExpression(implode(" ", $js)),
                'encoding' => false,
            ], $this->options);
        }

        return Html::decode(Html::submitButton($this->label, $this->options));
    }

}
