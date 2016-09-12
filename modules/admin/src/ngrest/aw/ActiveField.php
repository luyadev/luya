<?php

namespace luya\admin\ngrest\aw;

use yii\base\Object;
use yii\helpers\Html;

/**
 * ActiveWindow ActiveField Configration
 *
 * @since 1.0.0-beta7
 * @author Basil Sutert <basil@nadar.io>
 */
class ActiveField extends Object
{
    /**
     * @var \admin\ngrest\aw\CallbackFormWidget The form widget object
     */
    public $form = null;
    
    /**
     * @var string The attribute name of the field is isued as identifier to send the post data.
     */
    public $attribute = null;
    
    /**
     * @var string Pre defined value of the option
     */
    public $value = null;
    
    /**
     * @var string|boolean A label which is used when no label is provided from class creation config
     */
    public $label = false;
    
    /**
     * @var string The template to build the element, the {} variables will be replace on render().
     */
    public $template = '<div class="{class}">{label}<div class="input__field-wrapper">{input}</div></div>';
    
    protected $parts = [];
    
    /**
     * Define a label for this field. If false, no label will be used, if a label is provided from the configration
     * object (form) this will be overritten by this method.
     *
     * @param string $label The label of the element
     * @return \admin\ngrest\aw\ActiveField
     */
    public function label($label)
    {
        if ($label === false) {
            $this->parts['{label}'] = '';
        } else {
            $this->parts['{label}'] = '<label class="input__label" for="'.$this->form->getFieldId($this->attribute).'">'.$label.'</label>';
        }
        return $this;
    }
    
    /**
     * Text input field
     *
     * @param array $options Optional data for the text input array.
     * @return \admin\ngrest\aw\ActiveField
     */
    public function textInput(array $options = [])
    {
        $this->parts['{input}'] = Html::textInput($this->attribute, $this->value, [
            'class' => 'input__field',
            'id' => $this->form->getFieldId($this->attribute),
            'ng-model' => 'params.'.$this->attribute,
        ]);
        $this->parts['{class}'] = 'input input--text input--vertical';
        
        return $this;
    }
    
    /**
     * Create text area
     *
     * @param array $options Optional data for the textarea input
     * @return \admin\ngrest\aw\ActiveField
     */
    public function textarea(array $options = [])
    {
        $this->parts['{input}'] = Html::textarea($this->attribute, $this->value, [
            'class' => 'input__field',
            'id' => $this->form->getFieldId($this->attribute),
            'ng-model' => 'params.'.$this->attribute,
        ]);
        $this->parts['{class}'] = 'input input--textarea input--vertical';
        
        return $this;
    }
    
    /**
     * Render the template based on input values of $parts.
     *
     * @return string
     */
    private function render()
    {
        if (!isset($this->parts['{input}'])) {
            $this->textInput();
        }
    
        if (!isset($this->parts['{label}'])) {
            $this->label($this->label);
        }
    
        if (!isset($this->parts['{class}'])) {
            $this->parts['{class}'] = $this->class;
        }
    
        return str_replace([
                '{input}',
                '{label}',
                '{class}',
        ], [
                $this->parts['{input}'],
                $this->parts['{label}'],
                $this->parts['{class}'],
        ], $this->template);
    }
    
    /**
     * When the element is directly forced to echo its output this method is called and the template will be
     * render with the `render()` method.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }
}
