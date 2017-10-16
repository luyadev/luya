<?php

namespace luya\crawler\models;

use Yii;
use luya\admin\ngrest\base\NgRestModel;
use luya\admin\aws\DetailViewActiveWindow;

/**
 * Searchdata contains Search Queries from Users.
 * 
 * This table represents all search queries made by the users from the frontend. This is also used in order to
 * send weekly search report.
 *
 * @property integer $id
 * @property string $query
 * @property integer $results
 * @property integer $timestamp
 * @property string $language
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class Searchdata extends NgRestModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'crawler_searchdata';
    }

    /**
     * @inheritdoc
     */
    public static function ngRestApiEndpoint()
    {
        return 'api-crawler-searchdata';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'query' => Yii::t('app', 'Query'),
            'results' => Yii::t('app', 'Results'),
            'timestamp' => Yii::t('app', 'Timestamp'),
            'language' => Yii::t('app', 'Language'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['query', 'timestamp'], 'required'],
            [['results', 'timestamp'], 'integer'],
            [['query'], 'string', 'max' => 120],
            [['language'], 'string', 'max' => 12],
        ];
    }

    /**
     * @inheritdoc
     */
    public function genericSearchFields()
    {
        return ['query', 'language'];
    }

    /**
     * @inheritdoc
     */
    public function ngRestAttributeTypes()
    {
        return [
            'query' => 'text',
            'results' => 'number',
            'timestamp' => 'datetime',
            'language' => 'text',
        ];
    }

    /**
     * @inheritdoc
     */
    public function ngRestScopes()
    {
        return [
            ['list', ['query', 'results', 'timestamp', 'language']],
            ['delete', false],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function ngRestActiveWindows()
    {
        return [
            ['class' => DetailViewActiveWindow::class, 'attributes' => [
               'language', 'query', 'results', 'timestamp:date',
            ]],
        ];
    }
}
