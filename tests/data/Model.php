<?php

namespace tests\data;

class Model extends \admin\ngrest\base\Model
{
    public static function tableName()
    {
        return 'dummy_table';
    }
    
    public function rules()
    {
        return [
            [['i18n_text', 'i18n_textarea', 'date', 'datetime', 'file_array', 'image_array', 'select'], 'safe'],
        ];
    }
    
    public $i18n = ['i18n_text', 'i18n_textarea'];
    
    public function ngRestConfig($config)
    {
        $config->list->field('i18n_text')->text();
        $config->list->field('i18n_textarea')->textarea();
        $config->list->field('date')->date();
        $config->list->field('datetime')->datetime();
        $config->list->field('file_array')->fileArray();
        $config->list->field('image_array')->imageArray();
        $config->list->field('select')->selectArray([1 => 'foo', 2 => 'bar']);
        
        $config->update->copyFrom('list');
        $config->create->copyFrom('list');
    }
    
    public function ngRestApiEndpoint()
    {
        return 'api-tests-model';
    }
}