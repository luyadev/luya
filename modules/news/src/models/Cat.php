<?php

namespace luya\news\models;

use luya\news\admin\Module;
use luya\admin\ngrest\base\NgRestModel;

/**
 * News Category Model
 *
 * @author Basil Suter <basil@nadar.io>
 */
class Cat extends NgRestModel
{
	/**
	 * @inheritdoc
	 */
    public $i18n = ['title'];
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
    	return 'news_cat';
    }
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->on(self::EVENT_BEFORE_DELETE, [$this, 'eventBeforeDelete']);
    }
    
    /**
     * @inheritdoc
     */
    public function eventBeforeDelete($event)
    {
        if (count($this->articles) > 0) {
            $this->addError('id', Module::t('cat_delete_error'));
            $event->isValid = false;
        }
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
    	return [
    			'title' => Module::t('cat_title'),
    	];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function ngRestApiEndpoint()
    {
    	return 'api-news-cat';
    }

    /**
     * @inheritdoc
     */
    public function ngRestAttributeTypes()
    {
        return [
            'title' => 'text',
        ];
    }

    /**
     * @inheritdoc
     */
    public function ngRestScopes()
    {
    	return [
    		[['list', 'create', 'update'], ['title']],
    		[['delete'], true],
    	];
    }
    
    /**
     * Get articles for this category.
     */
    public function getArticles()
    {
        return $this->hasMany(Article::class, ['cat_id' => 'id']);
    }
}
