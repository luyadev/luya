<?php

namespace admin\ngrest\plugins;

use cebe\markdown\GithubMarkdown;

/**
 * Create a textarea input for a given field.
 * 
 * Example uf using the nl2br option
 * 
 * ```php
 * ['mytext' => ['textarea', 'nl2br' => true]],
 * ```
 * 
 * This will automatically generate nl2br on after find event (before display).
 * 
 * @author nadar
 */
class Textarea extends \admin\ngrest\base\Plugin
{
    /**
     * @var string Html5 placholder attribute value to set and example for the user
     */
    public $placeholder = null;

    /**
     * @var bool Defines whether the textarea output value should be nl2br or not. This only 
     * will be triggerd after find (in frontend output).
     */
    public $nl2br = false;
    
    /**
     * @var bool Define whether the textarea output value should be automaticcally parsed as 
     * markdown or not. This will only trigger after find (in frontend output).
     */
    public $markdown = false;

    /**
     * {@inheritDoc}
     * @see \admin\ngrest\base\Plugin::renderList()
     */
    public function renderList($id, $ngModel)
    {
        return $this->createListTag($ngModel);
    }

    /**
     * {@inheritDoc}
     * @see \admin\ngrest\base\Plugin::renderCreate()
     */
    public function renderCreate($id, $ngModel)
    {
        return $this->createFormTag('zaa-textarea', $id, $ngModel, ['placeholder' => $this->placeholder]);
    }

    /**
     * {@inheritDoc}
     * @see \admin\ngrest\base\Plugin::renderUpdate()
     */
    public function renderUpdate($id, $ngModel)
    {
        return $this->renderCreate($id, $ngModel);
    }
    
    private $_markdownParser = null;
    
    /**
     * Get markdown parser instance
     * 
     * @return \cebe\markdown\GithubMarkdown
     */
    public function getMarkdownParser()
    {
        if ($this->_markdownParser === null) {
            $this->_markdownParser = new GithubMarkdown();
            $this->_markdownParser->enableNewlines = true;
        }
    }
    
    /**
     * {@inheritDoc}
     * @see \admin\ngrest\base\Plugin::onAfterFind()
     */
    public function onAfterFind($event)
    {
        if ($this->nl2br) {
            $event->sender->setAttribute($this->name, nl2br($event->sender->getAttribute($this->name)));
        }
        
        if ($this->markdown) {
            $event->sender->setAttribute($this->name, $this->markdownPaser->parse($event->sender->getAttribute($this->name)));
        }
    }
}
