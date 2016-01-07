<?php

namespace cms\menu;

use Yii;
use Exception;

/**
 * Menu Query Builder.
 * 
 * Ability to create menu query condition similar behavior, changing the language container and define with
 * specification to fit your needs.
 * 
 * Basic example of making a menu selection:
 * 
 * ```php
 * $items = (new \cms\menu\Query())->where(['parent_nav_id' => 0])->all();
 * ```
 * 
 * By default the Menu Query will get the default language, or the current active language. To force
 * a specific language use the `lang()` method in your query chain:
 * 
 * ```php
 * $items = (new \cms\menu\Query())->where(['parent_nav_id' => 0])->lang('en')->all();
 * ```
 * 
 * You can also find one element instead of all
 * 
 * ```php
 * $item = (new \cms\menu\Query())->where(['id' => 1])->one();
 * ```
 * 
 * To include hidden pages to your selection use with:
 * 
 * ```php
 * $items = (new \cms\menu\Query())->where(['parent_nav_id' => 0])->with(['hidden'])->all();
 * ```
 * 
 * @property object $menu Contains menu Object.
 * @since 1.0.0-beta1
 * @author nadar
 */
class Query extends \yii\base\Object
{
    private $_where = [];

    private $_lang = null;

    private $_menu = null;

    private $_whereOperators = ['<', '<=', '>', '>=', '=', '=='];
    
    private $_with = ['hidden' => false];
    
    private $_offset = null;
    
    private $_limit = null;
    
    /**
     * Getter method to return menu component
     * 
     * @return \cms\menu\Container Menu Container object
     */
    public function getMenu()
    {
        if ($this->_menu === null) {
            $this->_menu = Yii::$app->get('menu');
        }

        return $this->_menu;
    }

    /**
     * Query where similar behavior of filtering items.
     * 
     * **Operator Filtering**
     * 
     * ```php
     * where(['operator', 'field', 'value']);
     * ```
     * 
     * Allowed operators
     * + **<** expression where field is smaller then value.
     * + **>** expression where field is bigger then value.
     * + **=** expression where field is equal value.
     * + **<=** expression where field is small or equal then value.
     * + **>=** expression where field is bigger or equal then value.
     * + **==** expression where field is equal to the value and even the type must be equal.
     * 
     * Only one operator speific argument can be provided, to chain another expression
     * use the `andWhere()` method.
     * 
     * **Multi Dimension Filtering**
     * 
     * The most common case for filtering items is the equal expression combined with
     * add statements.
     * 
     * For example the following expression
     * 
     * ```php
     * where(['=', 'parent_nav_id', 0])->andWhere(['=', 'container', 'footer']);
     * ```
     * 
     * is equal to the short form multi deimnsion filtering expression
     * 
     * ```php
     * where(['parent_nav_id' => 0, 'container' => 'footer']);
     * ```
     * 
     * @param array $args
     *
     * @return \cms\menu\Query
     */
    public function where(array $args)
    {
        foreach ($args as $key => $value) {
            if (in_array($value, $this->_whereOperators, true)) {
                if (count($args) !== 3) {
                    throw new Exception(sprintf("Wrong where(['%s']) condition, see http://luya.io/api/cms-menu-query.html#where()-detail for all available conditions.", implode("', '", $args)));
                }
                $this->_where[] = ['op' => $args[0], 'field' => $args[1], 'value' => $args[2]];
                break;
            } else {
                $this->_where[] = ['op' => '=', 'field' => $key, 'value' => $value];
            }
        }

        return $this;
    }

    /**
     * 
     * @param array $args
     */
    public function andWhere(array $args)
    {
        return $this->where($args);
    }

    /**
     * Changeing the container in where the data should be collection, by default the composition
     * `langShortCode` is the default language code. This represents the current active language,
     * or the default language if no information is presented.
     * 
     * @param string $langShortCode Language Short Code e.g. de or en
     *
     * @return \cms\menu\Query
     */
    public function lang($langShortCode)
    {
        $this->_lang = $langShortCode;

        return $this;
    }

    /**
     * @param string|array $with can be a string  containg "hidden" or an array with multiple patters
     * for example `['hidden']`. Further with statements upcoming.
     */
    public function with($types)
    {
        $types = (array) $types;
        foreach ($types as $type) {
            if (array_key_exists($type, $this->_with)) {
                $this->_with[$type] = true;
            }
        }
 
        return $this;
    }

    public function getLang()
    {
        if ($this->_lang === null) {
            $this->_lang = $this->menu->composition['langShortCode'];
        }

        return $this->_lang;
    }

    public function arrayFilter($value, $field)
    {
        if ($field == 'is_hidden' && $this->_with['hidden'] === false && $value == 1) {
            return false;
        }

        foreach ($this->_where as $expression) {
            if ($expression['field'] == $field) {
                switch ($expression['op']) {
                    case '=':
                        return ($value == $expression['value']);
                    case '==':
                        return ($value === $expression['value']);
                    case '>':
                        return ($value > $expression['value']);
                    case '>=':
                        return ($value >= $expression['value']);
                    case '<':
                        return ($value < $expression['value']);
                    case '<=':
                        return ($value <= $expression['value']);
                }
            }
        }

        return true;
    }

    public function limit($count)
    {
        if (is_numeric($count)) {
            $this->_limit = $count;
        }
        
        return $this;
    }
    
    public function offset($count)
    {
        if (is_numeric($count)) {
            $this->_offset = $count;
        }
        
        return $this;
    }
    
    public function filter(array $whereExpression, $containerData)
    {
        $data = array_filter($containerData, function ($item) {
            foreach ($item as $field => $value) {
                if (!$this->arrayFilter($value, $field)) {
                    return false;
                }
            }

            return true;
        });
        
        if ($this->_offset !== null) {
            $data = array_slice($data, $this->_offset, null, true);
        }
        
        if ($this->_limit !== null) {
            $data = array_slice($data, 0, $this->_limit, true);
        }
        
        return $data;
    }

    public function one()
    {
        $data = $this->filter($this->_where, $this->menu[$this->getLang()]);

        if (count($data) == 0) {
            return false;
        }

        return static::createItemObject(array_values($data)[0], $this->getLang());
    }

    public function all()
    {
        return static::createArrayIterator($this->filter($this->_where, $this->menu[$this->getLang()]), $this->getLang());
    }
    
    public function count()
    {
        return count($this->filter($this->_where, $this->menu[$this->getLang()]));
    }

    public static function createArrayIterator($data, $langContext)
    {
        return Yii::createObject(['class' => QueryIterator::className(), 'data' => $data, 'lang' => $langContext]);
    }

    public static function createItemObject(array $itemArray, $langContext)
    {
        return Yii::createObject(['class' => Item::className(), 'itemArray' => $itemArray, 'lang' => $langContext]);
    }
}
