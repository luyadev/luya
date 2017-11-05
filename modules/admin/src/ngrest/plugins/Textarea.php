<?php

namespace luya\admin\ngrest\plugins;

use luya\admin\ngrest\base\Plugin;
use luya\TagParser;
use luya\helpers\Html;

/**
 * Create a textarea input for a given field.
 *
 * Example uf using the nl2br option
 *
 * ```php
 * ['mytext' => ['textarea', 'nl2br' => true]]
 * ```
 *
 * This will automatically generate nl2br on after find event (before display).
 *
 * In order to enable the markdown parsing use the code below:
 *
 * ```php
 * ['mytext' => ['textarea', 'markdown' => true]]
 * ```
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class Textarea extends Plugin
{
    /**
     * @var string Html5 placholder attribute value to set and example for the user
     */
    public $placeholder;
    
    /**
     * @var boolean Whether the value should be encoded after find by {{luya\helpers\Html::encode()}} or not.
     */
    public $encoding = true;

    /**
     * @var boolean Defines whether the textarea output value should be nl2br or not. This only will be triggerd after find (in frontend output).
     */
    public $nl2br = false;
    
    /**
     * @var boolean Define whether the textarea output value should be automaticcally parsed as
     * markdown or not. This will only trigger after find (in frontend output).
     */
    public $markdown = false;

    /**
     * @inheritdoc
     */
    public function renderList($id, $ngModel)
    {
        return $this->createListTag($ngModel);
    }

    /**
     * @inheritdoc
     */
    public function renderCreate($id, $ngModel)
    {
        return $this->createFormTag('zaa-textarea', $id, $ngModel, ['placeholder' => $this->placeholder]);
    }

    /**
     * @inheritdoc
     */
    public function renderUpdate($id, $ngModel)
    {
        return $this->renderCreate($id, $ngModel);
    }
    
    /**
     * @inheritdoc
     */
    public function onAfterFind($event)
    {
        if ($this->encoding) {
            $event->sender->setAttribute($this->name, Html::encode($event->sender->getAttribute($this->name)));
        }
        
        if ($this->nl2br) {
            $event->sender->setAttribute($this->name, nl2br($event->sender->getAttribute($this->name)));
        }
        
        if ($this->markdown) {
            $event->sender->setAttribute($this->name, TagParser::convertWithMarkdown($event->sender->getAttribute($this->name)));
        }
    }
}
