<?php

namespace luya\admin\components;

use yii\base\Component;
use luya\admin\models\Lang;

/**
 * Admin Language component to make singelton similiar pattern to collect langauges and active language.
 *
 * @author Basil Suter <basil@nadar.io>
 */
class AdminLanguage extends Component
{
    /**
     * Containg the default language assoc array.
     *
     * @var array
     */
    private $_activeLanguage = null;
    
    /**
     * Containg all availabe languages from Lang Model.
     *
     * @var array
     */
    private $_languages = null;
    
    /**
     * Get the array of the current active language (its not an AR object!)
     *
     * @return array
     */
    public function getActiveLanguage()
    {
        if ($this->_activeLanguage === null) {
            $this->_activeLanguage = Lang::findActive();
        }
        
        return $this->_activeLanguage;
    }
    
    /**
     * Get the current active langauge Short-Code
     *
     * @return string
     */
    public function getActiveShortCode()
    {
        return $this->getActiveLanguage()['short_code'];
    }
    
    /**
     * Get the current active language ID
     *
     * @return int
     */
    public function getActiveId()
    {
        return (int) $this->getActiveLanguage()['id'];
    }
    
    /**
     * Get an array of all languages (its not an AR object!)
     *
     * @return array
     */
    public function getLanguages()
    {
        if ($this->_languages === null) {
            $this->_languages = Lang::getQuery();
        }
    
        return $this->_languages;
    }
    
    public function getLanguageByShortCode($shortCode)
    {
        return isset($this->getLanguages()[$shortCode]) ? $this->getLanguages()[$shortCode] : false;
    }
}
