<?php

namespace cms\menu;

/**
 * Menu Query Builder
 * 
 * Ability to create menu querys to find your specifc menu items.
 * 
 * Basic where conditions:
 * 
 * ```php
 * $data = (new \cms\menu\Query())->where(['parent_nav_id' => 0])->all();
 * ```
 * 
 * By default the Menu Query will get the default language, or the current active language. To force
 * a specific language use the `lang()` method in your query chain:
 * 
 * ```php
 * $data = (new \cms\menu\Query())->where(['parent_nav_id' => 0])->lang('en')->all();
 * ```
 * 
 * @since 1.0.0-beta1
 * @author nadar
 */
class Query extends \yii\base\Object
{
    private $_where = [];
    
    private $_lang = null;
    
    private $_menu = null;
    
    public function setMenu(\cms\components\Menu $menu)
    {
        $this->_menu = $menu;
    }
    
    public function getMenu()
    {
        if ($this->_menu === null) {
            $this->_menu = Yii::$app->get('menu');
        }
        
        return $this->_menu;
    }
    
    public function where(array $args)
    {
        $this->_where[] = $args;
        return $this;
    }
    
    public function lang($langShortCode)
    {
        $this->_lang = $langShortCode;
        return $this;
    }
    
    public function getLang()
    {
        if ($this->_lang === null) {
            $this->_lang = $this->menu->composition['langShortCode'];
        }
        
        return $this->_lang;
    }
    
    public function one()
    {
        array_filter($this->menu->languageContainerData($this->lang), function($var, $key) {
            
        }, ARRAY_FILTER_USE_BOTH);
    }
    
    public function all()
    {
        
    }
}