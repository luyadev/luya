<?php

namespace luya\crawler\models;

use Yii;
use luya\crawler\admin\Module;
use luya\crawler\models\Searchdata;
use luya\helpers\Url;
use yii\helpers\Inflector;
use Nadar\Stemming\Stemm;
use yii\db\Expression;

/**
 * This is the model class for table "crawler_index".
 *
 * @property integer $id
 * @property string $url
 * @property string $title
 * @property string $content
 * @property string $description
 * @property string $language_info
 * @property string $url_found_on_page
 * @property string $group
 * @property integer $added_to_index
 * @property integer $last_update
 * @property string $clickUrl
 */
class Index extends \luya\admin\ngrest\base\NgRestModel
{
    public static $counter = 0;
    
    public static $searchDataId = 0;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'crawler_index';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['url'], 'required'],
            [['content', 'description'], 'string'],
            [['added_to_index', 'last_update'], 'integer'],
            [['url', 'title'], 'string', 'max' => 200],
            [['language_info'], 'string', 'max' => 80],
            [['url_found_on_page'], 'string', 'max' => 255],
            [['group'], 'string', 'max' => 120],
            [['url'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'url' => Module::t('index_url'),
            'title' => Module::t('index_title'),
            'language_info' => Module::t('index_language_info'),
            'content' => Module::t('index_content'),
            'url_found_on_page' => Module::t('index_url_found'),
            'added_to_index' => ' add to index on',
            'last_update' => 'last update'
        ];
    }
    
    /**
     * Search by general Like statement.
     *
     * @param string $query
     * @param string $languageInfo
     * @return \yii\db\ActiveRecord[]
     */
    public static function flatSearchByQuery($query, $languageInfo)
    {
        $query = static::encodeQuery($query);
    
        $query = Stemm::stemPhrase($query, $languageInfo);
        
        if (strlen($query) < 1) {
            return [];
        }
    
        $q = self::find()->where(['like', 'content', $query]);
        $q->orWhere(['like', 'description', $query]);
        $q->orWhere(['like', 'title', $query]);
        if (!empty($languageInfo)) {
            $q->andWhere(['language_info' => $languageInfo]);
        }
        $result = $q->all();
    
        $searchData = new SearchData();
        $searchData->detachBehavior('LogBehavior');
        $searchData->attributes = [
            'query' => $query,
            'results' => count($result),
            'timestamp' => time(),
            'language' => $languageInfo,
        ];
        $searchData->save();
    
        return $result;
    }
    
    /**
     * Intelligent searc
     * @param unknown $query
     * @param unknown $languageInfo
     * @param string $returnQuery
     * @return \yii\db\ActiveRecord
     */
    public static function searchByQuery($query, $languageInfo)
    {
        
        if (strlen($query) < 1) {
            return [];
        }
        
        $activeQuery = self::activeQuerySearch($query, $languageInfo);
        
        $result = $activeQuery->all();
        
        $searchData = new SearchData();
        $searchData->detachBehavior('LogBehavior');
        $searchData->attributes = [
            'query' => $query,
            'results' => count($result),
            'timestamp' => time(),
            'language' => $languageInfo,
        ];
        $searchData->save();
        
        return $result;
    }
    
    /**
     * Smart search by a query.
     *
     * @param unknown $query
     * @param unknown $languageInfo
     * @param string $returnQuery
     * @return \yii\db\ActiveQuery
     */
    public static function activeQuerySearch($query, $languageInfo)
    {
        $query = static::encodeQuery($query);
        
        $parts = explode(" ", $query);
        
        $index = [];
        foreach ($parts as $word) {

            if (empty($word)) {
                continue;
            }
            
            $word = Stemm::stem($word, $languageInfo);
            $q = self::find()->select(['id', 'url', 'title']);
            $q->where(['like', 'content', $word]);
            $q->orWhere(['like', 'description', $query]);
            $q->orWhere(['like', 'title', $query]);
            if (!empty($languageInfo)) {
                $q->andWhere(['language_info' => $languageInfo]);
            }
            $data = $q->asArray()->indexBy('id')->all();
        
            static::indexer($word, $data, $index);
        }
        
        
        $ids = [];
        $foundOld = 1;
        foreach ($index as $item) {
            if (isset($ids[$item['urlwordpos']])) {
                $foundOld++;
                $ids[$item['urlwordpos'] + $foundOld] = $item['id'];
            } else {
                $ids[$item['urlwordpos']] = $item['id'];
            }
        
        }
        
        arsort($ids);
        
        $activeQuery = self::find()->where(['in', 'id', $ids]);
        if (!empty($ids)) {
            $activeQuery->orderBy(new Expression('FIELD (id, ' . implode(', ', $ids) . ')'));
        }
        
        return $activeQuery;
    }
    
    /**
     *
     * @param unknown $item
     * @param unknown $index
     */
    private static function indexer($keyword, $item, &$index)
    {
        if (empty($index)) {
            $index = $item;
            foreach ($index as $k => $v) {
                $index[$k]['urlwordpos'] = static::evalPosition($v, $keyword);
            }
        } else {
            foreach ($index as $k => $v) {
                if (!array_key_exists($k, $item)) {
                    unset($index[$k]);
                } else {
                    $index[$k]['urlwordpos'] = static::evalPosition($v, $keyword);
                }
            }
        }
    }
    
    private static $_midImportant = 500;
    
    private static $_unImportant = 1000;
    
    private static function evalPosition(array $item, $keyword)
    {
        $newpos = strpos($item['url'], $keyword);
        
        if ($newpos === false) {
            $posInTitle = strpos($item['title'], $keyword);
            
            if ($posInTitle !== false) {
                $newpos = $posInTitle + self::$_midImportant;
                self::$_midImportant++;
            } else {
                $newpos = self::$_unImportant;
                self::$_unImportant++;
            }
        }
        
        $after = substr($item['url'], $newpos + 1);
        
        if ($after) {
            $newpos = $newpos + strlen($after);
        }
        
        if (isset($item['urlwordpos']) && $item['urlwordpos'] < $newpos) {
            return $item['urlwordpos'];
        }
        
        return $newpos;
    }
    
    /**
     * Encode the input query.
     *
     * @param unknown $query
     * @return string
     */
    public static function encodeQuery($query)
    {
        return trim(htmlentities($query, ENT_QUOTES));
    }
    

    /**
     * Generate preview from the search word and the corresponding cut amount.
     *
     * @param string $word The word too lookup in the `$content` variable.
     * @param number $cutAmount The amount of words on the left and right side of the word.
     * @return mixed
     */
    public function preview($word, $cutAmount = 150)
    {
        return $this->highlight($word, $this->cut($word, html_entity_decode($this->content), $cutAmount));
    }

    /**
     *
     * @param unknown $word
     * @param unknown $context
     * @param number $truncateAmount
     * @return string
     */
    public function cut($word, $context, $truncateAmount = 150)
    {
        $pos = strpos($context, $word);
        $originalContext = $context;
        // cut lef
        if ($pos > $truncateAmount) {
            $context = '...'.substr($context, (($pos - 1) - $truncateAmount));
        }
        // cut right
        if ((strlen($originalContext) - $pos) > $truncateAmount) {
            $context = substr($context, 0, -(strlen($originalContext) - ($pos + strlen($word) + 1) - $truncateAmount)).'...';
        }

        return $context;
    }

    /**
     *
     * @param unknown $word
     * @param unknown $text
     * @param string $sheme
     * @return mixed
     */
    public function highlight($word, $text, $sheme = "<span style='background-color:#FFEBD1; color:black;'>%s</span>")
    {
        return preg_replace("/".preg_quote(htmlentities($word, ENT_QUOTES), '/')."/i", sprintf($sheme, $word), $text);
    }
    
    /**
     * @inheritdoc
     */
    public function genericSearchFields()
    {
        return ['url', 'content', 'title'];
    }

    /**
     * @inheritdoc
     */
    public static function ngRestApiEndpoint()
    {
        return 'api-crawler-index';
    }

    /**
     * @inheritdoc
     */
    public function ngRestAttributeTypes()
    {
        return [
            'url' => 'text',
            'title' => 'text',
            'language_info' => 'text',
            'url_found_on_page' => 'text',
            'content' => 'textarea',
            'last_update' => 'datetime',
            'added_to_index' => 'datetime',
        ];
    }

    /**
     * @inheritdoc
     */
    public function ngRestConfig($config)
    {
        $this->ngRestConfigDefine($config, 'list', ['title', 'url', 'language_info', 'last_update', 'added_to_index']);
        $this->ngRestConfigDefine($config, ['create', 'update'], ['url', 'title', 'language_info', 'url_found_on_page', 'content', 'last_update', 'added_to_index']);
        return $config;
    }
}
