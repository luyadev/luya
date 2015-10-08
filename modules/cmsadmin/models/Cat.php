<?php

namespace cmsadmin\models;

use admin\models\Lang;

class Cat extends \admin\ngrest\base\Model
{
    use \admin\traits\SoftDeleteTrait;

    public function ngRestApiEndpoint()
    {
        return 'api-cms-cat';
    }

    private $_langId = null;

    public function getLangId()
    {
        if ($this->_langId === null) {
            $array = Lang::getDefault();
            $this->_langId = $array['id'];
        }

        return $this->_langId;
    }

    private function getNavData()
    {
        $_data = [];
        foreach (Nav::find()->all() as $item) {
            $x = $item->getNavItems()->where(['lang_id' => $this->getLangId()])->asArray()->one();
            if ($x) {
                $_data[$x['nav_id']] = $x['title'];
            }
        }

        return $_data;
    }

    public function ngRestConfig($config)
    {
        $config->delete = true;

        $config->list->field('name', 'Name')->text();
        $config->list->field('default_nav_id', 'Default-Nav-Id')->selectArray($this->getNavData());
        $config->list->field('rewrite', 'Rewrite')->text();
        $config->list->field('is_default', 'Ist Starteintrag')->toggleStatus();

        $config->create->copyFrom('list');
        $config->update->copyFrom('list');

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

    /** 
     * @todo should be en static instance variable isntead of line 16
     */
    public static function getDefault()
    {
        return self::find()->where(['is_default' => 1])->asArray()->one();
    }

    private static $_queryInstance = null;

    public static function getQuery()
    {
        if (self::$_queryInstance === null) {
            self::$_queryInstance = self::find()->asArray()->indexBy('id')->all();
        }

        return self::$_queryInstance;
    }
}
