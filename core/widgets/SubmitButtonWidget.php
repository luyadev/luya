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
     * @since 1.0.24 First time this was introduced
     *
     * @var activeForm Define activeForm context to use widget in context and only disable button when validation succeeded
     */
    protected $activeForm;

    /**
     * @since 1.0.24 First time this was introduced
     *
     * @param $activeForm Set $activeForm and check for type "ActiveForm"
     */
    public function setActiveForm(ActiveForm $activeForm)
    {
        $this->activeForm = $activeForm;
    }

    /**
     * @since 1.0.24 First time this was introduced
     *
     * @return ActiveForm Return $activeForm
     */
    public function getActiveForm()
    {
        return $this->activeForm;
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
     * * @since 1.0.24 Added "ActiveForm-Mode" which only disables button when given ActiveForm is validated successful
     *
     * Add beforeSubmit handler which disables button and replaces button text
     * @return string
     */
    public function run()
    {
        if ($this->activeForm) {
            $this->view->registerJs("            
            $(document).on('beforeSubmit', function (e) {                
                var buttonSelector = $(e.target).find(':submit');
                var formSelector = $(e.target);
                if (formSelector.find('div." . $this->activeForm->errorCssClass . "').length === 0) {
                    buttonSelector.attr('disabled', true);
                    var newButtonLabel = '" . $this->pushed . "';
                    if (newButtonLabel) {
                        buttonSelector.html('" . $this->pushed . "');
                    }                            
                }
                return true;
            });");
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
