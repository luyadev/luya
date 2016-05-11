<?php

namespace crawleradmin\models;

use yii\helpers\Html;
use crawleradmin\Module;

class Index extends \admin\ngrest\base\Model
{
    /* yii model properties */

    public static function tableName()
    {
        return 'crawler_index';
    }

    public function scenarios()
    {
        return [
            'default' => ['url', 'content', 'title', 'language_info', 'added_to_index', 'last_update', 'url_found_on_page'],
            'restcreate' => ['url', 'content', 'title', 'language_info', 'url_found_on_page'],
            'restupdate' => ['url', 'content', 'title', 'language_info', 'url_found_on_page'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'url' => Module::t('index_url'),
            'title' => Module::t('index_title'),
            'language_info' => Module::t('index_language_info'),
            'content' => Module::t('index_content'),
            'url_found_on_page' => Module::t('index_url_found'),
        ];
    }

    /* custom methods */
    
    public static function indexer($item, &$index)
    {
        if (empty($index)) {
            $index = $item;
        } else {
            foreach ($index as $k => $v) {
                if (!array_key_exists($k, $item)) {
                    unset($index[$k]);
                }
            }
        }
    }

    public static function searchByQuery($query, $languageInfo)
    {
        $query = trim(htmlentities($query, ENT_QUOTES));
        
        if (strlen($query) < 1) {
            return [];
        }
        
        $parts = explode(" ", $query);
        
        $index = [];
        
        foreach ($parts as $word) {
            $q = self::find()->select(['id', 'content'])->where(['like', 'content', $word]);
            if (!empty($languageInfo)) {
                $q->andWhere(['language_info' => $languageInfo]);
            }
            $data = $q->asArray()->indexBy('id')->all();
            static::indexer($data, $index);
        }
        
        $ids = [];
        foreach ($index as $item) {
            $ids[] = $item['id'];
        }
        
        
        return self::find()->where(['in', 'id', $ids])->all();
    }
    
    public static function flatSearchByQuery($query, $languageInfo)
    {
        $query = trim(htmlentities($query, ENT_QUOTES));
        
        if (strlen($query) < 1) {
            return [];
        }
        
        $q = self::find()->where(['like', 'content', $query]);
        if (!empty($languageInfo)) {
            $q->andWhere(['language_info' => $languageInfo]);
        }
        
        return $q->all();
    }

    public function preview($word, $cutAmount = 150)
    {
        return $this->highlight($word, $this->cut($word, $this->content, $cutAmount));
    }

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
            $context = substr($context, 0, -(strlen($originalContext) - ($pos + strlen($word)) - $truncateAmount)).'...';
        }

        return $context;
    }

    public function highlight($word, $text, $sheme = "<span style='background-color:#FFEBD1; color:black;'>%s</span>")
    {
        return preg_replace("/".preg_quote(htmlentities($word, ENT_QUOTES), '/')."/i", sprintf($sheme, $word), $text);
    }

    /* ngrest model properties */

    public function genericSearchFields()
    {
        return ['url', 'content', 'title', 'language_info'];
    }

    public function ngRestApiEndpoint()
    {
        return 'api-crawler-index';
    }

    public function ngrestAttributeTypes()
    {
        return [
            'url' => 'text',
            'title' => 'text',
            'language_info' => 'text',
            'url_found_on_page' => 'text',
            'content' => 'textarea',
        ];
    }

    public function ngRestConfig($config)
    {
        $this->ngRestConfigDefine($config, 'list', ['url', 'title', 'language_info', 'url_found_on_page']);
        $this->ngRestConfigDefine($config, ['create', 'update'], ['url', 'title', 'language_info', 'url_found_on_page', 'content']);
        return $config;
    }
}
