<?php

namespace crawleradmin\models;

use yii\helpers\Html;
use yii\helpers\StringHelper;

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
            'default' => ['url', 'content', 'title', 'arguments_json', 'language_info', 'added_to_index', 'last_update'],
            'restcreate' => ['url', 'content', 'title', 'arguments_json', 'language_info'],
            'restupdate' => ['url', 'content', 'title', 'arguments_json', 'language_info'],
        ];
    }
    
    /* custom methods */
    
    public static function searchByQuery($query)
    {
        return self::find()->where(['like', 'content', Html::encode($query)])->all();
    }
    
    public function preview($word, $cutAmount = 150)
    {
        return $this->highlight($word, $this->cut($word, $this->content, $cutAmount));
    }
    
    public function cut($word, $context, $truncateAmount = 150) {
		$pos = strpos($context, $word);
		$originalContext = $context;
		// cut lef
		if ($pos > $truncateAmount) {
			$context = "..." . substr($context, (($pos-1)-$truncateAmount));
		}
		// cut right
		if ((strlen($originalContext) - $pos) > $truncateAmount) {
			$context = substr($context, 0, -(strlen($originalContext)-($pos+strlen($word)) - $truncateAmount)) . "...";
		}
		
		return $context;
	}
	
	public function highlight($word, $text, $sheme = "<span style='background-color:#FFEBD1; color:black;'>%s</span>")
	{
		return preg_replace("/$word/i", sprintf($sheme, $word), $text);
	}

    /* ngrest model properties */

    public function genericSearchFields()
    {
        return ['url', 'content', 'title', 'arguments_json', 'language_info'];
    }

    public function ngRestApiEndpoint()
    {
        return 'api-crawler-index';
    }

    public function ngRestConfig($config)
    {
        $config->list->field('url', 'Url')->text();
        $config->list->field('title', 'Title')->text();
        $config->list->field('language_info', 'Language_info')->text();
        $config->list->field('content', 'Content')->textarea();
        $config->list->field('arguments_json', 'Arguments_json')->textarea();
        $config->create->copyFrom('list', ['id']);
        $config->update->copyFrom('list', ['id']);
        return $config;
    }
}