<?php

namespace luya\cms\menu;

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
 * Attention: When you append the `with['hidden']` state, the visibility of the item will be overriden, even when you
 * change them with event inject. So take care of using with hidden when protecting items for beeing seen by guest users
 * (in example of protected several items for not logged in users).
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
     * Its **not possibile** to make where conditions on the same column:
     *
     * ```php
     * where(['>', 'id', 1])->andWHere(['<', 'id', 3]);
     * ```
     *
     * This will only appaend the first condition where id is bigger then 1 and ignore the second one
     *
     * @param array $args The where defintion can be either an key-value pairing or a condition representen as array.
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
     * Add another where statement to the existing, this is the case when using compare operators, as then only
     * one where definition can bet set.
     *
     * @see \cms\menu\Query->where()
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
     * @return \cms\menu\Query
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

    /**
     * Return the current language from composition if not set via `lang()`.
     *
     * @return string
     */
    public function getLang()
    {
        if ($this->_lang === null) {
            $this->_lang = $this->menu->composition['langShortCode'];
        }

        return $this->_lang;
    }

    /**
     * Set a limition for the amount of results.
     *
     * @param integer $count The number of rows to return
     * @return \cms\menu\Query
     */
    public function limit($count)
    {
        if (is_numeric($count)) {
            $this->_limit = $count;
        }
        
        return $this;
    }
    
    /**
     * Define offset start for the rows, if you defined offset to be 5 and you have 11 rows, the
     * first 5 rows will be skiped. This is commonly used to make pagination function in combination
     * with the limit() function.
     *
     * @param integer $offset Defines the amount of offset start position.
     * @return \cms\menu\Query
     */
    public function offset($offset)
    {
        if (is_numeric($offset)) {
            $this->_offset = $offset;
        }
        
        return $this;
    }

    /**
     * Retrieve only one result for your query, even if there are more rows then one, it will
     * just pick the first row from the filtered result and return the item object. If the filtering
     * based on the query settings does not return any result, the return will be false.
     *
     * @return \cms\menu\Item|boolean Returns the Item object or false if nothing found.
     */
    public function one()
    {
        $data = $this->filter($this->_where, $this->menu[$this->getLang()]);

        if (count($data) == 0) {
            return false;
        }

        return static::createItemObject(array_values($data)[0], $this->getLang());
    }

    /**
     * Retrieve all found rows based on the filtering options and returns the the QueryIterator object
     * which is represents an array.
     *
     * @return \cms\menu\QueryIterator Returns the QueryIterator object.
     */
    public function all()
    {
        return static::createArrayIterator($this->filter($this->_where, $this->menu[$this->getLang()]), $this->getLang(), $this->_with);
    }
    
    /**
     * Returns the count for the provided filter options.
     *
     * @return integer The number of rows for your filtering options.
     */
    public function count()
    {
        return count($this->filter($this->_where, $this->menu[$this->getLang()]));
    }
    
    /**
     * Static method to create an iterator object based on the provided array data with
     * optional language context.
     *
     * @param array $data The filtere results where the iterator object should be created with
     * @param string $langContext The language short code context, if any.
     * @return \cms\menu\QueryIterator
     */
    public static function createArrayIterator(array $data, $langContext, $with)
    {
        return (new QueryIteratorFilter(Yii::createObject(['class' => QueryIterator::className(), 'data' => $data, 'lang' => $langContext, 'with' => $with])));
    }
    
    /**
     * Static method to create the item object itself, is used for the one() method and in the current() method
     * of the QueryIterator class.
     *
     * @param array $itemArray The item array data for the object
     * @param string  $langContext The language short code context, if any.
     * @return \cms\menu\Item
     */
    public static function createItemObject(array $itemArray, $langContext)
    {
        return Yii::createObject(['class' => Item::className(), 'itemArray' => $itemArray, 'lang' => $langContext]);
    }
    
    protected function filter(array $whereExpression, $containerData)
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
    
    protected function arrayFilter($value, $field)
    {
        if ($field == 'is_hidden' && $this->_with['hidden'] === false && $value == 1) {
            return false;
        }
    
        foreach ($this->_where as $expression) {
            if ($expression['field'] == $field) {
                switch ($expression['op']) {
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
                    default:
                        return ($value == $expression['value']);
                }
            }
        }
    
        return true;
    }
}
