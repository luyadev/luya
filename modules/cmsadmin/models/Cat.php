<?php
namespace cmsadmin\models;

class Cat extends \admin\ngrest\base\Model
{
    public $ngRestEndpoint = 'api-cms-cat';

    private function getNavData()
    {
        $_data = [];
        foreach(\cmsadmin\models\Nav::find()->all() as $item) {
            $x = $item->getNavItems()->where(['lang_id' => \admin\models\Lang::getDefault()->id])->one();
            $_data[$x->nav_id] =  $x->title;
        }
        
        return $_data;
    }
    
    public function ngRestConfig($config)
    {
        $config->list->field("name", "Name")->text()->required();
        $config->list->field("default_nav_id", "Default-Nav-Id")->selectArray($this->getNavData());
        $config->list->field("rewrite", "Rewrite")->text()->required();
        $config->list->field("is_default", "Ist Starteintrag")->toggleStatus();
        $config->list->field("id", "ID")->text();

        $config->create->copyFrom('list', ['id']);
        $config->update->copyFrom('list', ['id']);

        return $config;
    }

    public static function tableName()
    {
        return 'cms_cat';
    }

    public function rules()
    {
        return [
            [['name', 'rewrite', 'default_nav_id'], 'required'],
        ];
    }

    public function scenarios()
    {
        return [
            'restcreate' => ['name', 'rewrite', 'default_nav_id', 'is_default'],
            'restupdate' => ['name', 'rewrite', 'default_nav_id', 'is_default'],
        ];
    }

    public static function getDefault()
    {
        return self::find()->where(['is_default' => 1])->one();
    }
}
