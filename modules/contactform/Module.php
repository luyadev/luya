<?php

namespace contactform;

use luya\Exception;

/**
 * Example Configuration:
 * 
 * ```
 * 'contactform' => [
 *     'class' => 'contactform\Module',
 *     'attributes' => ['name', 'email', 'street', 'city', 'tel', 'message'],
 *     'rules' => [
 *         [['name', 'email', 'street', 'city', 'message'], 'required'],
 *         ['email', 'email'],
 *     ],
 *     'recipients' => ['admin@example.com'],
 * ],
 * ```
 * 
 * @author nadar
 * @since 1.0.0-beta6
 */
class Module extends \luya\base\Module
{
    public $attributes = null;
    
    public $attributeLabels = [];
    
    public $rules = [];
    
    public $callback = null;
    
    public $recipients = null;
    
    public function init()
    {
        parent::init();
        
        if ($this->attributes === null) {
            throw new Exception("The attributes attributed must be defined with an array of available attributes.");
        }
        
        if ($this->recipients === null) {
            throw new Exception("The recipients attributed must be defined with an array of recipients who will recieve an email.");
        }
    }
}