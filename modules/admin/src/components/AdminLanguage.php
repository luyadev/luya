<?php

namespace luya\admin\components;

use yii\base\Component;
use luya\admin\models\Lang;

/**
 * Admin Language Component.
 *
 * The component is registered by the admin module and provides methods to collect language data.
 *
 * @property string $getLanguageByShortCode Get the language from a shortCode..
 * @property array $languages Get an array of all languages (its not an AR object!).
 * @property integer $activeId Get the current active language ID.
 * @property string $activeShortCode Get the current active langauge Short-Code.
 * @property array $activeLanguage Get the array of the current active language (its not an AR object!).
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class AdminLanguage extends Component
{
    /**
     * Containg the default language assoc array.
     *
     * @var array
     */
    private $_activeLanguage;
    
    /**
     * Containg all availabe languages from Lang Model.
     *
     * @var array
     */
    private $_languages;
    
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
    
    /**
     * Get the language from a shortCode.
     *
     * @param string $shortCode
     * @return boolean|mixed
     */
    public function getLanguageByShortCode($shortCode)
    {
        return isset($this->getLanguages()[$shortCode]) ? $this->getLanguages()[$shortCode] : false;
    }
}
