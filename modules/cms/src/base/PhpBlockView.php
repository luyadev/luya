<?php

namespace luya\cms\base;

use Yii;
use luya\web\View;

/**
 * View context helper of php block view file.
 *
 * @property \luya\cms\base\PhpBlock $context Get the block context.
 * @property integer $index Get the current index number of the block inside the current placeholder.
 * @property boolean $isFirst Whether this is the first block element inside this placeholder or not.
 * @property boolean $isLast Whether this is the last block element inside this placeholder or not.
 * @property integer $itemsCount Returns the number of items inside this placeholder.
 * @property boolean $isNextEqual Whether the next element (the element after the current element) is the same or not.
 * @property boolean $isLastEqual Whether the previous element (the element before the current element) is the same or not.
 * @property integer $equalIndex Get the index number within the equal elements.
 * @property \luya\web\View $appView The application view object in order to register data to the layout view.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class PhpBlockView extends View
{
    /**
     * Get the current index number of the block inside the current placeholder.
     *
     * @return integer
     */
    public function getIndex()
    {
        return $this->context->getEnvOption('index');
    }
    
    /**
     * Whether this is the first block element inside this placeholder or not.
     *
     * @return boolean
     */
    public function getIsFirst()
    {
        return $this->context->getEnvOption('isFirst');
    }
    
    /**
     * Whether this is the last block element inside this placeholder or not.
     *
     * @return boolean
     */
    public function getIsLast()
    {
        return $this->context->getEnvOption('isLast');
    }
    
    /**
     * Returns the number of items inside this placeholder.
     *
     * @return integer
     */
    public function getItemsCount()
    {
        return $this->context->getEnvOption('itemsCount');
    }
    
    /**
     * Whether the next element (the element after the current element) is the same or not.
     *
     * If there is no next element, false will be returned.
     *
     * @return boolean
     */
    public function getIsNextEqual()
    {
        return $this->context->getEnvOption('isNextEqual');
    }
    
    /**
     * Whether the previous element (the element before the current element) is the same or not.
     *
     * If there is no previous element, false will be returned.
     *
     * @return boolean
     */
    public function getIsPrevEqual()
    {
        return $this->context->getEnvOption('isPrevEqual');
    }
    
    /**
     * Get the index number within the equal elements.
     *
     * If the list of elements are the same after each other, the equal index counter +1.
     *
     * @return integer
     */
    public function getEqualIndex()
    {
        return $this->context->getEnvOption('equalIndex');
    }
    
    /**
     * Get a block environment value.
     *
     * + **id**: Return the unique identifier from the cms context
     * + **blockId**: Returns the id of this block (unique identifier)
     * + **context**: Returns frontend or backend to find out in which context you are.
     * + **pageObject**: Returns the `luya\cms\models\NavItem` Object where you can run `getNav()` to retrievew the Nav Object.
     * + **isFirst**: Returns whether this block is the first in its placeholder or not.
     * + **isLast**: Return whether his block is the last in its placeholder or not.
     * + **index**: Returns the number of the index/position within this placheholder.
     * + **itemsCount**: Returns the number of items inside this placeholder.
     * + **isPrevEqual**: Returns whether the previous item is of the same origin (block type, like text block) as the current.
     * + **isNextEqual**: Returns whether the next item is of the same origin (block type, like text block) as the current.
     * + **equalIndex**: Get the current index/position of this element within the list of *same* elements.
     *
     * @param string $key The key identifier of the context variable.
     * @param mixed $defaultvalue If the env value is not found this value will be returned.
     * @return mixed
     */
    public function env($key, $defaultvalue = null)
    {
        return $this->context->getEnvOption($key, $defaultvalue);
    }
    
    /**
     * Get the content of a placeholder.
     *
     * @param string $placeholder The name of the placeholder to return, defined as `varName` inside the `config()` method of the placeholders section.
     * @return string
     */
    public function placeholderValue($placeholder)
    {
        return $this->context->getPlaceholderValue($placeholder);
    }
    
    /**
     * Wrap a very basic template arounte the value if value is not `empty()`.
     *
     * Assuming to have variable `title` with the value `Hello World` and a template `<p>{{title}}</p>` renders:
     *
     * ```
     * <p>Hello World</p>
     * ```
     *
     * If a template is provided and $value is not empty return the wrapped template, otherwise the original $value input is returned.
     *
     * @param string $key The variable name to idenfier as {{key}}.
     * @param mixed $value The value which should be replaced for the $key.
     * @param string $template The template as a string which replates the $key enclosed in {{
     * @return string If a template is provided and $value is not empty return the wrapped template, otherwise the original $value input.
     */
    public function wrapTemplate($key, $value, $template)
    {
        if (!$template || empty($value)) {
            return $value;
        }
        
        return str_replace(['{{'.$key. '}}'], $value, $template);
    }
    
    /**
     * The the content value of a var.
     *
     * @param string $key The name of the var value to return, defined as `varName` inside the `config()` method of the vars section.
     * @param string $defaultValue Env value is not found this value will be returned.
     * @param string $template Provde a template which replaces the current variable if value is not `empty()`. e.g. `<p>{{variable}}≤/p>` See {{luya\cms\base\PhpBlockView::wrapTemplate}}.
     * @return mixed
     */
    public function varValue($key, $defaultValue = null, $template = false)
    {
        return $this->wrapTemplate($key, $this->context->getVarValue($key, $defaultValue), $template);
    }
    
    /**
     * Get the content of a cfg.
     *
     * @param string $key The name of the cfg value to return, defined as `varName` inside the `config()` method of the cfgs section.
     * @param string $defaultValue Env value is not found this value will be returned.
     * @param string $template Provde a template which replaces the current variable if value is not `empty()`. e.g. `<p>{{variable}}≤/p>` See {{luya\cms\base\PhpBlockView::wrapTemplate}}.
     * @return mixed
     */
    public function cfgValue($key, $defaultValue = null, $template = false)
    {
        return $this->wrapTemplate($key, $this->context->getCfgValue($key, $defaultValue), $template);
    }
    
    /**
     * Get the value of an extra var.
     *
     * @param string $key The name of the extra var to return, defined as key inside the `extraVars()` method return array.
     * @param string $defaultValue Env value is not found this value will be returned.
     * @param string $template Provde a template which replaces the current variable if value is not `empty()`. e.g. `<p>{{variable}}≤/p>` See {{luya\cms\base\PhpBlockView::wrapTemplate}}.
     * @return mixed
     */
    public function extraValue($key, $defaultValue = null, $template = false)
    {
        return $this->wrapTemplate($key, $this->context->getExtraValue($key, $defaultValue), $template);
    }
    
    /**
     * The Application View Object to Register Data.
     *
     * As the PhpBlockView is an own instance, registered assets files would not be available. In order to assign
     * meta keywords, add essets the application view object is required, therfore this getter method will
     * give you access.
     *
     * Example of registering an asset from the block view:
     *
     * ```php
     * MyBlockAsset::register($this->appView);
     * ```
     *
     * @return \luya\web\View The global application View Object which is also the same as the layout or cmslayout.
     */
    public function getAppView()
    {
        return Yii::$app->getView();
    }
}
