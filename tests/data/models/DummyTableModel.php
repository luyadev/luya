<?php

namespace luyatests\data\models;

class DummyTableModel extends \luya\admin\ngrest\base\NgRestModel
{
    public static function tableName()
    {
        return 'dummy_table';
    }

    public function rules()
    {
        return [
            [['i18n_text', 'i18n_textarea', 'date', 'datetime', 'file_array', 'image_array', 'select', 'cms_page'], 'safe'],
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
        $config->list->field('cms_page')->cmsPage();

        $config->update->copyFrom('list');
        $config->create->copyFrom('list');
    }

    public function ngRestApiEndpoint()
    {
        return 'api-tests-model';
    }
}
