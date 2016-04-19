<?php

namespace admin\components;

use yii\base\Component;
use admin\models\Lang;

/**
 * Admin Language component to make singelton similiar pattern to retrievie langauges
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
    

    private $_activeLanguageShortCode = null;
    
    public function getActiveLanguage()
    {
        if ($this->_activeLanguage === null) {
            $this->_activeLanguage = Lang::findActive();
        }
        
        return $this->_activeLanguage;
    }
    
    public function getActiveShortCode()
    {
        if ($this->_activeLanguageShortCode === null) {
            $lang = $this->getActiveLanguage();
            $this->_activeLanguageShortCode = $lang['short_code'];
        }
        
        return $this->_activeLanguageShortCode;
    }
    
    public function getLanguages()
    {
        if ($this->_languages === null) {
            $this->_languages = Lang::getQuery();
        }
    
        return $this->_languages;
    }
    
    
}