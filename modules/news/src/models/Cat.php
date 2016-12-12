<?php

namespace luya\news\models;

use luya\news\admin\Module;

/**
 * News Category Model
 *
 * @author Basil Suter <basil@nadar.io>
 */
class Cat extends \luya\admin\ngrest\base\NgRestModel
{
    public $i18n = ['title'];
    
    public function init()
    {
        parent::init();
        $this->on(self::EVENT_BEFORE_DELETE, [$this, 'eventBeforeDelete']);
    }
    
    public function eventBeforeDelete($event)
    {
        if (count($this->articles) > 0) {
            $this->addError('id', Module::t('cat_delete_error'));
            $event->isValid = false;
        }
    }
    
    public static function tableName()
    {
        return 'news_cat';
    }

    public function scenarios()
    {
        return [
            'restcreate' => ['title'],
            'restupdate' => ['title'],
        ];
    }

    public function rules()
    {
        return [
            [['title'], 'required'],
        ];
    }

    /**
     * 
     * {@inheritDoc}
     * @see \yii\base\Model::attributeLabels()
     */
    public function attributeLabels()
    {
        return [
            'title' => Module::t('cat_title'),
        ];
    }

    public function ngRestAttributeTypes()
    {
        return [
            'title' => 'text',
        ];
    }

    public static function ngRestApiEndpoint()
    {
        return 'api-news-cat';
    }

    public function ngRestConfig($config)
    {
        $this->ngRestConfigDefine($config, 'list', ['title']);

        $config->create->copyFrom('list', ['id']);
        $config->update->copyFrom('list', ['id']);

        $config->delete = true;

        return $config;
    }
    
    /**
     * Get articles for this category.
     */
    public function getArticles()
    {
        return $this->hasMany(Article::className(), ['cat_id' => 'id']);
    }
}
