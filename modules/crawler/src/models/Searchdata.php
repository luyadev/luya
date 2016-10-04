<?php

namespace luya\crawler\models;

use Yii;

/**
 * NgRest Model created at 24.05.2016 15:56 on LUYA Version 1.0.0-beta7-dev.
 *
 * @property string $query
 * @property integer $results
 * @property integer $timestamp
 * @property string $language
 */
class Searchdata extends \luya\admin\ngrest\base\NgRestModel
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
    public function attributeLabels()
    {
        return [
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
             [['query', 'results', 'timestamp', 'language'], 'required'],
        ];
    }
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['restcreate'] = ['query', 'results', 'timestamp', 'language'];
        $scenarios['restupdate'] = ['query', 'results', 'timestamp', 'language'];
        return $scenarios;
    }
    
    /**
     * @return array An array containing all field which can be lookedup during the admin search process.
     */
    public function genericSearchFields()
    {
        return ['query', 'language'];
    }
    
    /**
     * @return string Defines the api endpoint for the angular calls
     */
    public static function ngRestApiEndpoint()
    {
        return 'api-crawler-searchdata';
    }
    
    /**
     * @return array An array define the field types of each field
     */
    public function ngrestAttributeTypes()
    {
        return [
            'query' => 'text',
            'results' => 'number',
            'timestamp' => 'datetime',
            'language' => 'text',
        ];
    }
    
    /**
     * Define the NgRestConfig for this model with the ConfigBuilder object.
     *
     * @param \admin\ngrest\ConfigBuilder $config The current active config builder object.
     * @return \admin\ngrest\ConfigBuilder
     */
    public function ngRestConfig($config)
    {
        // define fields for types based from ngrestAttributeTypes
        $this->ngRestConfigDefine($config, 'list', ['query', 'results', 'timestamp', 'language']);
        $this->ngRestConfigDefine($config, ['create', 'update'], ['query', 'results', 'timestamp', 'language']);
        
        // enable or disable ability to delete;
        $config->delete = false;
        
        return $config;
    }
}
